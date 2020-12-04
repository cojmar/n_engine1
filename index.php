<?php
//========================================================= INIT
$tmp = @explode('.',$_SERVER['REDIRECT_URL']);
$ishtml =($tmp[count($tmp)-1] !='html')?0:1;
//=====Site items init
$site_items =array('more_js'=>'');
//=====Include
include ("functions.php");$site_items['absolutepath']=$config['absolutepath'];
$include_array = array('session','xmlar','mysql','curl');
foreach ($include_array as $script) if (include_s($script)===false) die ("missing file $script");
$site_items['ses_id']=session_id();
//=====MYSQL PROT
array_walk_recursive ($_POST, 'mysql_walk');array_walk_recursive ($_GET, 'mysql_walk');
//=====Mesaj de sesiune
if ((isset($_SESSION['ses_msg']))&&(trim($_SESSION['ses_msg'])!='')){
$site_items['ses_msg']="<script>alert('{$_SESSION['ses_msg']}');</script>";
unset($_SESSION['ses_msg']);
}
//===>META
$meta=(file_exists("./cfg/meta.xml"))?xml_ar(implode("",file("./cfg/meta.xml"))):array();
$meta=(isset($meta[$_SESSION['pg']]))?$meta[$_SESSION['pg']]:array('m_title'=>'','m_words'=>'','m_desc'=>'');
//========================================================= TEMPLATES
$script = explode('/',$_SERVER['PHP_SELF']);$script = $script[count($script)-1];
$page =get_t($config['matrix']);
$site_items['cont'] =get_t($_SESSION['pg']);
if ($site_items['cont']=='') $site_items['cont'] ="<!--content-->";
//========================================================= MAIN
$tmp = $config['scripts']."switch.php";if (file_exists($tmp)) include_once($tmp);
//========================================================= END
$page=insert_ar($page,$site_items);
$page=insert_ar($page,$meta);
print $page;
?>