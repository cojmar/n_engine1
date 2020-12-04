<?php
//========================================================= INIT
//=====Site items init
$site_items =array('script'=>'');
//=====Include
$cwd = getcwd();chdir("../");
include ("functions.php");$site_items['absolutepath']=$config['absolutepath'];
$include_array = array('mysql','xmlar','session');
foreach ($include_array as $script) if (include_s($script)===false) die ("missing file $script");
chdir($cwd);chdir("..");


//=====MYSQL PROT
array_walk_recursive ($_POST, 'mysql_walk');array_walk_recursive ($_GET, 'mysql_walk');

$page="";
$pg = (isset($_POST['pg']))?$_POST['pg']:'';
if (isset($_GET['pg'])) $pg = $_GET['pg'];



$page = get_t($pg);


switch ($pg){
default :
break;
}




print $page;


?>