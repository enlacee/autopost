<?php
/**
 * @package AutoPost
 * @version 1.0
 */

/*
Plugin Name: AutoPost
Plugin URI: #
Description: TThis plugin created posts  file callback 
Author: Anibal Copitan
Version: 1.0
Author URI: http://acopitan.blogspot.com/
*/


/** Make sure that the WordPress bootstrap has run before continuing. */
require(dirname(__FILE__) . '/wp-load.php');

/** This filter is documented in wp-admin/options.php */
if ( ! apply_filters( 'enable_post_by_email_configuration', true ) )
    wp_die( __( 'This action has been disabled by the administrator.' ) );

/**
* Autogenerate post into wordpress
*
* @param $rs array data post
* @return mix (integer or boolean) (integer number of that post was created)
*/
function autoPost($rs) {

    $return = false;

    if (is_array($rs) && count($rs)) {

        $title = $rs['team1'] . ' vs ' . $rs['team2'] . ' en vivo';

        $hour1 = $rs['dateHour'] . ':' . str_pad($rs['dateMinute'], 2, "00", STR_PAD_LEFT) . ' hs.';
        $hour2 = ($rs['dateHour'] + 1) . ':' . str_pad($rs['dateMinute'], 2, "00", STR_PAD_LEFT) . ' hs.';
        $hour3 = ($rs['dateHour'] + 2) . ':' . str_pad($rs['dateMinute'], 2, "00", STR_PAD_LEFT) . ' hs.';

        $des = "<b>{$rs['team1']} vs {$rs['team2']}</b> en vivo,"
            . "  <b>{$rs['dateDayName']} {$rs['dateDayNumber']} de {$rs['dateMouth']} del {$rs['dateYear']} </b>"
            . "juegan las escuadras de <b>    {$rs['team1']} contra    {$rs['team2']}</b> partido interesante "
            . "<b>Amistosos Internacionales</b>"
            . "<br>Competición: <b>Partidos amistosos - FIFA</b><br><b><u>Sede - Estadio</u>: {$rs['stadium']}</b> </br>"
            . "<b><u>Horario del partido</u></b>: Hora por países<br><b>Perú,</b> Ecuador, Colombia, México:"
            . " {$hour1}<br>Chile, Bolivia, Paraguay: {$hour2}<br>Argentina, Uruguay, Brasil: {$hour3}<br>"
            . "Después del encuentro todo el <b>resumen del partido.</b> No te pierdas el partido de fútbol <b>"
            . "{$rs['team1']} -     {$rs['team2']}</b> online por los <b><u>Diversos Canales de Transmisión por la TV y la Internet</u></b>";

        // Add post
        $post = array(
            'post_content' => $des,
            'post_name' => $title,
            'post_title' => $title,
            'post_status' => 'publish',
            'post_type' => 'post',
            'post_category'  => array(1), // change categorie_id for other(id).
            'tags_input'     => array($rs['team1'], $rs['team2'])
        );

        $idPost = wp_insert_post($post, true);

        if ($idPost > 0) {
            echo "The number record is : [{$idPost}]";
            echo "<hr><br>";
            echo $des;
        } else {
            echo "Error in process"; die;
        }
    } 

    return $return;
}

/**
* Formating data 
*
* @param $rs data $_REQUEST
* @return array with values of football
*/
function _formatDataPost($rs)
{
    $data['team1'] = empty($rs['equipo_a']) ? '' : trim(ucfirst($rs['equipo_a']));
    $data['team2'] = empty($rs['equipo_b']) ? '' : trim(ucfirst($rs['equipo_b']));
    $data['dateDayName'] = empty($rs['dia']) ? '' : $rs['dia'];
    $data['dateDayNumber'] = empty($rs['fecha']) ? '' : $rs['fecha'];
    $data['dateMouth'] = empty($rs['mes']) ? '' : $rs['mes'];
    $data['dateYear'] = empty($rs['anio']) ? '' : $rs['anio'];
    $data['stadium'] = empty($rs['estadio']) ? '' : trim($rs['estadio']);
    $data['dateHour'] = empty($rs['hora']) ? '' : (int) $rs['hora'];
    $data['dateMinute'] = empty($rs['minutos']) ? '' : (int) $rs['minutos'];

    return $data;
}


/**  init app ***/
$data = _formatDataPost($_REQUEST);
autoPost($data);



/*** FORMAT DESCRIPTION
<b>Argentina vs    Peru</b> en vivo,  <b>lunes 1 de enero del 2014 </b>juegan las escuadras de &nbsp<b>    Argentina contra    Peru</b> partido interesante &nbsp<b>Amistosos Internacionales</b>
<br>Competición: <b>Partidos amistosos - FIFA</b><br><b><u>Sede - Estadio</u>: ESTADIO1</b></br><b><u>Horario del partido</u></b>: Hora por países<br><b>Perú,</b> Ecuador, Colombia, México: 1:1 hs.<br>Chile, Bolivia, Paraguay: 2:1 hs.<br>Argentina, Uruguay, Brasil: 3:1 hs.<br>Después del encuentro todo el <b>resumen del partido.</b> No te pierdas el partido de fútbol <b>   Argentina -     Peru</b> online por los <b><u>Diversos Canales de Transmisión por la TV y la Internet</u></b>
*/

