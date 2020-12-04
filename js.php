<?php
session_start();
$jss='';
$insert=array();
$scripts =array('main','ajax','divm','calendar');
//=====Load scripts
foreach ($scripts as $s) {
$file = "./js/{$s}.js";
if (file_exists($file)) $jss.= implode("\n",file($file));
}
//======Print
$jss=str_replace("<!--ses_id-->",session_id(),$jss);
print $jss;





?>