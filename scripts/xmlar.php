<?php
function ar_xml($ar){
$ret ='';
foreach ($ar as $k=>$v){
$k=str_replace(" ","_",$k);
$ret .="<{$k}>\n";
$ret .= (is_array($v))?ar_xml($v):"$v\n";
$ret .="</{$k}>\n";
}
return $ret;
}

function xml_ar($xml) {
        $xmlary = array();
                
        $reels = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
        $reattrs = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';

        preg_match_all($reels, $xml, $elements);

        foreach ($elements[1] as $ie => $xx) {
		$name = $elements[1][$ie];
		$xmlary[$name] = $elements[1][$ie];
                

                $cdend = strpos($elements[3][$ie], "<");
                if ($cdend > 0) {
                        $xmlary[$name] = substr($elements[3][$ie], 0, $cdend - 1);
                }

                if (preg_match($reels, $elements[3][$ie]))
                        $xmlary[$name] = xml_ar($elements[3][$ie]);
                else if ($elements[3][$ie]) {
                        $xmlary[$name] = str_replace("\n","",$elements[3][$ie]);
                }
        }

        return $xmlary;
}

function ar_xml_sv($ar,$file){
$dta = ar_xml($ar);
$f=fopen($file,"w");
fwrite($f,$dta);
fclose($f);
}

function xml_ar2(&$string) {
$rep_ar = array("&"=>"~and~");
$string = enc_xml($string,$rep_ar);
$string = "<imba_xml>\n$string\n</imba_xml>";

$parser = xml_parser_create();
xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
xml_parse_into_struct($parser, $string, $vals, $index);
xml_parser_free($parser);
$mnary=array();
$ary=&$mnary; 
foreach ($vals as $r) {
$t=$r['tag'];
if ($r['type']=='open') {
if (isset($ary[$t])) { 
if (isset($ary[$t][0])) $ary[$t][]=array(); else $ary[$t]=array($ary[$t], array()); 
$cv=&$ary[$t][count($ary[$t])-1]; 
} else $cv=&$ary[$t]; 
$cv=array();
if (isset($r['attributes'])) {
foreach ($r['attributes'] as $k=>$v) $cv[$k]=$v;
}   

$cv['_p']=&$ary;  
$ary=&$cv;      
} elseif ($r['type']=='complete') {      
if (isset($ary[$t])) { // same as open          
if (isset($ary[$t][0])) $ary[$t][]=array();
else $ary[$t]=array($ary[$t], array());
$cv=&$ary[$t][count($ary[$t])-1];    
} else $cv=&$ary[$t];    
if (isset($r['attributes'])) {
foreach ($r['attributes'] as $k=>$v) $cv[$k]=$v;
} 
//$cv=(isset($r['value']) ? $r['value'] : ''); 
} elseif ($r['type']=='close') {
$ary=&$ary['_p']; 
}    } 
_del_p($mnary);

array_walk_recursive($mnary, 'dec_ar',$rep_ar);
return $mnary['imba_xml'];
}

// _Internal: Remove recursion in result array
function _del_p(&$ary) { 
foreach ($ary as $k=>$v) { 
if ($k==='_p') unset($ary[$k]);
elseif (is_array($ary[$k])) _del_p($ary[$k]);   
 }}

###############################
function enc_xml($dta,$rep_ar){
foreach ($rep_ar as $k=>$v) $dta =str_replace($k,$v,$dta);
return $dta;
}

function dec_ar(&$item, $key,$rep_ar){
foreach ($rep_ar as $k=>$v) $item =str_replace($v,$k,$item);
}
###############################

?>