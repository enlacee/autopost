## README INSTALL 

Script for send data to wordpress and see it as post.
You follow the installation steps
**useful for creating automated post**


How to Install step and step

### 1 step:
Downloader the wordpress v4 (2014)

### 2 step:
Copy and Paste in your directory main
result : (wordpress/wp-autopost.php)

### 3 step:
You must change into form tag in attribute 'action' <form>
example:

    <form id="alemania" name="form1" method="post" action="http://localhost/wordpress/wp-autopost.php">

### 4 step: (optional)
If unusual characters shown in html set to UTF-8 that htmls
so add this line in file .htaccess
  
    # add config .htacces UTF-8
    AddDefaultCharset utf-8