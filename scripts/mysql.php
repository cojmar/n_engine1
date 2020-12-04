<?php
/*
This module conects to the data base
*/
function con()
{
$script = explode('/',$_SERVER['PHP_SELF']);$script = $script[count($script)-1];
$rr = array('index.php','switch2.php','switch_f.php','file.php','f_upl.php','p_upl.php');
$pth = (in_array($script,$rr))?"./cfg":"../cfg";
require ("$pth/mysql.php");
if ($host!=''){
mysql_connect($host,$user,$pass);
mysql_select_db($db);
mysql_query('SET NAMES utf8');
}
}
con();

function vec_sql($dta,$table){
$sql='';
foreach ($dta as $k=>$v){
if (is_array($v)) $v=ar_xml($v);
$sql .= ($sql=='')?"`$k`='".mysql_real_escape_string($v)."'":",`$k`='".mysql_real_escape_string($v)."'";
}
$sql ="insert into `$table` set $sql on duplicate key update $sql";
return $sql;
}

?>