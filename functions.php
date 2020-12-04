<?php
require_once("./cfg/conf_site.php");

//=======GET /  POST
array_walk_recursive ($_GET, 'n_walk');
array_walk_recursive ($_POST, 'n_walk');

function n_walk(&$item){
if (!is_array($item)) nprot($item);
}

function mysql_walk(&$item){
if (!is_array($item)) nprot($item);
}

//======FILES
foreach ($_FILES as $k=>$v) $_FILES[$k]['name'] = nprot($_FILES[$k]['name']);
//=====PROT
function nprot(&$ss){
$rep = array("\0"=>"");
foreach ($rep as $kk=>$vv) $ss=str_replace($kk,$vv,$ss);
}

function mysql_prot(&$ss){
$ss=mysql_real_escape_string($ss);
}

function header2($url){
GLOBAL $site_items;
$url = trim($url);
if  (strtolower(substr($url,1,4))!='http') $url=$site_items['absolutepath']."index.php".$url;
header("location:$url");
die();
}





################################
function logout(){ //=========>Logout
################################
$_SESSION['login'] =0;
$_SESSION['login_dta'] = array();
}

################################
function login($ar){ //=========>Login
################################
if ((is_array($ar))&&(isset($ar['user']))&&(isset($ar['pass']))){
foreach ($ar as $k=>$v) $ar[$k] = mysql_real_escape_string($v);

$sql = "select * where `user`='{$ar['user']}' and `pass`='{$ar['pass']}'  limit 1";
if (($q=mysql_query($sql))&&($r=mysql_fetch_assoc($q))){
$_SESSION['login'] = $r['id'];
$_SESSION['login_dta'] = $r;
} else $_SESSION['ses_msg']=$sql;
}

}


################################
function insert_ar($ret,$ar){ //=========>Inser array
################################
foreach ($ar as $k=>$v) if (!is_array($v)) $ret=str_replace("<!--$k-->",$v,$ret);
$ar = array_reverse($ar);
foreach ($ar as $k=>$v) if (!is_array($v)) $ret=str_replace("<!--$k-->",$v,$ret);
return ($ret);
}

################################
function get_t($t){ //=============> Get template
################################
GLOBAL $config;
$ret ='';
if ((isset($_SESSION['lang']))&&($_SESSION['lang']!='')){
$file = substr($config['templates'],0,strlen($config['templates'])-1)."_{$_SESSION['lang']}/".$t.".html";
if (file_exists($file)) $ret = implode(file($file));
}
if ($ret==''){
$file = $config['templates'].$t.".html";
if (file_exists($file)) $ret = implode(file($file));
}
return $ret;
}
################################
function include_s($t){ //=============> Include script
################################
GLOBAL $config;
$file = $config['scripts'].$t.".php";
$ret =false;
if (file_exists($file)) $ret = include_once($file);
return $ret;
}


################################
function getdir($fol){ //=============> Dir
################################
//the $cod var is optional it can look like : ".jpg" or ".php;.jpg;" and it specifies a searching condition
$ret=array();
$dr = scandir($fol);
$ret = $dr;

unset($ret[0]);
unset($ret[1]);

return $ret;
}

################################
function print_vec($vec){ //=============>Capture Vecotor in a string
################################
$ret = '';
ob_start();
print "<xmp>";
print_r($vec);
print "</xmp>";
$ret .= ob_get_contents();
ob_end_clean();
return $ret;
}


################################
function pharse_form($dta,$prefix,$sufix,$form){ 
//====>This function will pharse the html searching for fields and compleats values in them $dta = array('field'=>'value')
################################
foreach ($dta as $k=>$v){
$fiend = "name=\"{$prefix}{$k}{$sufix}\"";

if (strpos($form,$fiend)!==false){
$tmp = explode($fiend,$form);

if (strpos(trim($tmp[1]),"value=\"\"")===0){
$kk = strpos ($tmp[1],'"');
$tmp[1]=substr($tmp[1],0,$kk+1).mysql_real_escape_string($v).substr($tmp[1],$kk+1,strlen($tmp[1]));
}
else {
for($i=1;$i<=count($tmp)-1;$i++){
if (strpos(trim($tmp[$i]),"value=\"$v\"")===0){
$kk = strpos ($tmp[$i],"value=\"$v\"")+strlen("value=\"$v\"")-1;
$tmp[$i]=substr($tmp[$i],0,$kk+1)." checked ".substr($tmp[$i],$kk+1,strlen($tmp[$i]));

}

if (strpos($tmp[$i],"option value=\"$v\"")!==false){
$kk =strpos ($tmp[$i],"value=\"$v\"")+strlen("value=\"$v\"")-1;
$tmp[$i]=substr($tmp[$i],0,$kk+1)." selected ".substr($tmp[$i],$kk+1,strlen($tmp[$i]));
}

}

}


$form = implode($fiend,$tmp);
}
//====TEXT AREA
$fiend = "<textarea name=\"{$prefix}{$k}{$sufix}\"";
$ni=strpos($form,$fiend);
if ($ni!==false){
$af=substr($form,$ni);
$ni2=strpos($af,'>');
if ($ni2!==false){
$ta = substr($af,0,$ni2+1);
$form = str_replace("$ta<","{$ta}{$v}<",$form);
}
}
//====END TEXT AREA
}
return $form;
}

################################
function post_ref(){ //=============> refresh keeping GET vars
################################
GLOBAL $site_items;
$url = '?';
if (isset($_GET)){
$url = '';
foreach ($_GET as $k=>$v) $url .= "&$k=$v";
if (strlen($url)>1) $url[0]='?';
}
$url="{$site_items['absolutepath']}$url";
header("location:$url");die();
}
//=======>5:36 AM function
################################
function list_pageing($ord,$max_orders_on_page,$sqlp,$sqll,$paga,$class="pagination"){
################################
if ($paga!='')$paga.="&";
$ret=array();
if (!isset($_SESSION[$ord])) $_SESSION[$ord]=1;
if (isset($_GET['pag']))$_SESSION[$ord]=$_GET['pag'];

if ($q = mysql_query($sqlp))
$max = ($r = mysql_fetch_assoc($q))?$r['max']:1;
else $max =1;
$total =($max%$max_orders_on_page!=0)?floor($max/$max_orders_on_page)+1:$max/$max_orders_on_page;
if ($_SESSION[$ord]>$total) $_SESSION[$ord] = $total;

$nn = ($_SESSION[$ord]-1) * $max_orders_on_page;
if ($nn<0) $nn=0;

$ret['pageing'] = gen_paging($_SESSION[$ord],$total,"?{$paga}pag=",$class);

$ret['sql'] = "$sqll  limit $nn,$max_orders_on_page";
return ($ret);
}
//=======>this functions draws pageing
################################
function gen_paging($curent_page,$total_pages,$link,$cls){
################################
if ($curent_page<1) $curent_page=1;
$ret ='';
$suf=($link[strlen($link)-1]=='(')?')':'';

$start =(floor($curent_page/10) *10==0)?1:floor($curent_page/10) *10;
$stop = ($start + 10 <= $total_pages)?$start + 10:$total_pages;
if ($stop==11) $stop =10;

for ($i=$start;$i<=$stop;$i++){
$ret .=($i!=$curent_page)?" <a href='{$link}{$i}{$suf}' class='$cls'>$i<a>":" <b class=$cls>$i</b>";
}

//====>Next
if ($curent_page+1<=$total_pages){
$i = $curent_page+1;
$ret .= " <a href='{$link}{$i}{$suf}' class='$cls'>&gt;<a>";
}
//====>Next 10
if ($curent_page+10<=$total_pages){
$i = $curent_page+10;
$ret .= " <a href='{$link}{$i}{$suf}' class='$cls'>&gt;&gt;<a>";
}

//====>Prev
if ($curent_page-1>=1){
$i = $curent_page-1;
$ret = "<a href='{$link}{$i}{$suf}' class='$cls'>&lt;<a>".$ret;
}
//====>Next 10
if ($curent_page-10>=1){
$i = $curent_page-10;
$ret = "<a href='{$link}{$i}{$suf}' class='$cls'>&lt;&lt;<a> ".$ret;
}


return $ret;
}

################################
function valid_array2($dta,$pat){
################################
$ok=1;
$len=4;
$ret=array();
foreach ($pat as $k=>$v){
if ((isset($dta[$k]))&&(trim($dta[$k])!='')&&(strlen(trim($dta[$k]))>=$len)) $ok+=0;
else {$ret[]=$v;$ok=0;}
}

$ret=($ok==1)?$ok:$ret;
return $ret;
}

################################
function valid_array($ar,$pat){
################################
$ret=1;
$log='';
foreach($pat as $k=>$v){

if ((isset($ar[$v]))&&(trim($ar[$v])!='')){
$ret=$ret;

if (stripos($v,"email")!==false){
if (valid_email($ar[$v])!=false)$ret=$ret;
else{$ret = 0;$vv=(is_numeric($k))?$v:$k;$log.="<span class='error'>Campul <b>$vv</b> nu este valid ! </span><br>";}
}

if (stripos($v,"cnp")!==false){
if (is_numeric($ar[$v]))$ret=$ret;
else{$ret = 0;$vv=(is_numeric($k))?$v:$k;$log.="<span class='error'>Campul <b>$vv</b> nu este valid ! </span><br>";}
}

}else{$ret = 0;$vv=(is_numeric($k))?$v:$k;$log.="<span class='error'>Campul <b>$vv</b> nu este valid ! </span><br>";}




}
$ret=($ret==1)?$ret:$log;

return $ret;
}


################################
function valid_email($email){
################################
$ret = true;
if(!eregi("^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$", $email)) $ret = false;
return $ret;
}
################################
function sndmail($from,$to,$subject,$message){
################################
$headers  = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From:" .$from ."\n";
$headers .= "Reply-To:".$from ."\n";
mail($to, $subject,  $message, $headers);
}





################################
function move_file($name,$new_name){
################################
if ((isset($_FILES[$name]))&&($_FILES[$name]['tmp_name']!='')){
$oname = $_FILES[$name]['tmp_name'];
move_uploaded_file($oname,$new_name);
}

}


################################
function s_trunc($frm,$end,$str){
################################
$ret='';
$ar = explode($frm,$str);
if (count($ar)>1){
for ($i=1;$i<count($ar);$i++){
$strr = $ar[$i];
$strr= explode($end,$strr);
$strr = $strr[0];
$ret= $strr;
}
}
return $ret;
}


################################
function s_cut($frm,$end,$str){
################################
$ret='';
$ar = explode($frm,$str);
if (count($ar)>1){
for ($i=1;$i<count($ar);$i++){
$strr = $ar[$i];
$strr= explode($end,$strr);
$strr[0]="";
$strr= implode("",$strr);
$ar[$i]= $strr;
}
$ret = implode("",$ar);
}
return $ret;
}

################################
function date_dif($date1, $date2){
################################ 
$date1 = is_int($date1) ? $date1 : strtotime($date1);
 $date2 = is_int($date2) ? $date2 : strtotime($date2);
 
if (($date1 !== false) && ($date2 !== false)) {
 if ($date2 >= $date1) {
 $diff = ($date2 - $date1);
 
if ($days = intval((floor($diff / 86400))))
 $diff %= 86400;
 if ($hours = intval((floor($diff / 3600))))
 $diff %= 3600;
 if ($minutes = intval((floor($diff / 60))))
 $diff %= 60;
 
return array('d'=>$days, 'h'=>$hours, 'm'=>$minutes, 's'=>intval($diff));
 }
 }
 
return false;
 }
?>