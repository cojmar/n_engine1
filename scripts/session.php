<?php
//$lifetime = 3600 * 24 * 30 * 12 *10; // 10 years 
//session_set_cookie_params($lifetime);
//if (isset($_POST['ses_id'])) session_id($_POST['ses_id']);
session_start();
//setcookie(session_name(),session_id(),time()+$lifetime);
 
$tmp = @explode('.',$_SERVER['REDIRECT_URL']);
$ishtml =($tmp[count($tmp)-1] !='html')?0:1;
$_SESSION['js']='da';
GLOBAL $site_items;
$redir='';
###################DEFINE VARS###################
//>this var is used to store the current page in pageing
$session=array();// GET to session
$sessionp=array();// POST to session
$sess_init=array();// init session 
$sess_items=array('uname');// SESSION to site_items


$sess_init['admin']=0;
$sess_init['init']='';
$sess_init['forum']=0;
$sess_init['login']=1;
$sess_init['login_f']=0;
$sess_init['tabs']=array();
$sess_init['tab']=0;
$sess_init['tree']='0';
$sess_init['f_src']='';
$sess_init['f_inp_dta']=array('usr_src'=>'','ord'=>'time');

$sess_init['login'] =0;
$sess_init['login_dta'] = array();

$session['pg']='home';
//$session['admin']='0';


foreach($sess_init as $k=>$v) if (!isset($_SESSION[$k])) $_SESSION[$k]=$v;
foreach($session as $k=>$v){
$_SESSION[$k]=(isset($_SESSION[$k]))?$_SESSION[$k]:$v;
$_SESSION[$k]=(isset($_GET[$k]))?$_GET[$k]:$_SESSION[$k];
}

foreach($sessionp as $k=>$v){
$_SESSION[$k]=(isset($_SESSION[$k]))?$_SESSION[$k]:$v;
$_SESSION[$k]=(isset($_POST[$k]))?$_POST[$k]:$_SESSION[$k];
}

foreach($sess_items as $k=>$v){
if (isset($_SESSION[$v])) $site_items[$v]=$_SESSION[$v];
}
//>this var is used form RA (random access)
$_SESSION['ram']='';


###############################################
function redo_url($omit){
GLOBAL $site_items;
$url = '';foreach ($_GET as $k=>$v) if (!in_array($k, $omit)) $url .=($url=='')?"?$k=$v":"&$k=$v";
$url = "{$site_items['absolutepath']}{$url}";
return $url;
}

?>