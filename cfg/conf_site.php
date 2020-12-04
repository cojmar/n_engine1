<?php
$config = array();
###### ABSOLUTE PATH
$config['absolutepath']=str_replace("//","/","http:///{$_SERVER['HTTP_HOST']}".str_replace("\\","/",dirname($_SERVER['PHP_SELF']))."/");
###### TEMPLATES FOLDER
$config['templates'] = "./templates/";
$config['matrix'] = "matrice";
###### SCRIPTS FOLDER
$config['scripts'] = "./scripts/";
?>