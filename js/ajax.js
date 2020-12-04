function open_in_box(params){
ld ("switch2",params,'boxcont','divm("T2",2)');
}

function set_title(title){
write_div('btitle','<b>'+title+'</b>');
}

function ldf(replaceid,uri,width,height){
 var embed = document.createElement('embed');
 embed.setAttribute('width',width);
 embed.setAttribute('height',height);
 embed.setAttribute('src',uri);
 embed.setAttribute('wmode', 'transparent');
write_div(replaceid,'');
var div = document.getElementById(replaceid);
div.appendChild(embed);
}


function ld(url,snd,target, after)
{
var xmlhttp;
xmlhttp=null;
// code for Mozilla, etc.
if (window.XMLHttpRequest)
  {
  xmlhttp=new XMLHttpRequest()
  }
// code for IE
else if (window.ActiveXObject)
  {
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP")
  }
if (xmlhttp!=null)
  {
  xmlhttp.open("POST","scripts/"+url+'.php',true);
  xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xmlhttp.send(snd+'&ses_id=<!--ses_id-->');
  xmlhttp.onreadystatechange=function()
{

// if xmlhttp shows "loaded"
if (xmlhttp.readyState==4)
  {
  // if "OK"
  if (xmlhttp.status==200)
  {
if  ((target !='null')&&(xmlhttp.responseText!='null')) 
if(document.getElementById(target)!=null) document.getElementById(target).innerHTML=xmlhttp.responseText;
//else alert(target);
var scr = xmlhttp.responseText.split('<script>');
if (scr.length>1){
for (i=1;i<scr.length;i++){
var scr2 = scr[i];
scr2= scr2.split('</script>');
scr2 = scr2[0];
eval(scr2);
}
}


if (after !='')eval(after);
  }
  else
  {
  alert("Problem retrieving data:" + xmlhttp.statusText)
  }
  }


}
  }
else
  {
  alert("Your browser does not support XMLHTTP.")
  }
}


function checkEnter(e){
var characterCode

if(e && e.which){ 
e = e
characterCode = e.which 
}
else{
e = event
characterCode = e.keyCode
}

if(characterCode == 13){ 
return true
}
else{
return false
}

}



function ontop(elem){
pnode = elem.parentNode;
if (elem.getAttribute('id')!=pnode.childNodes[pnode.childNodes.length-1].getAttribute('id')){
pnode.removeChild(elem);
pnode.appendChild(elem);
}
}


function write_div(id,txt){
document.getElementById(id).innerHTML=txt;
}

function write_plus(id,txt){
document.getElementById(id).innerHTML+=txt;
}

function dodrag(id,id2){
var theHandle = document.getElementById(id);
var theRoot = document.getElementById(id2);
Drag.init(theHandle, theRoot);
}


function dodrag2(id,id2){
var theHandle = document.getElementById(id);
var theRoot = document.getElementById(id2);

theRoot.onDragEnd2	= function(el){
var sv=Array();
var pars ='';

var id =el.id.split('gad_')[1];
sv['x'] =el.style.left.split('px')[0];
sv['y'] =el.style.top.split('px')[0];

for (i in sv) pars+="&dta["+i+"]="+sv[i];
ld ("switch2","&pg=save_gadget&id="+id+pars,'null',"");

}
Drag.init(theHandle, theRoot);

}

function open_in_pop(link,target){
window.open(link,target,'width=1000, height=700, left=0, top=0, scrollbars=yes');
}

function findPosH(obj){
var mydiv = document.getElementById(obj);
var the_height = mydiv.clientHeight;
return the_height;
}

 function findPosX(obj)
  {
    var curleft = 0;
    if(obj.offsetParent)
        while(1) 
        {
          curleft += obj.offsetLeft;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.x)
        curleft += obj.x;
    return curleft;
  }

  function findPosY(obj)
  {
    var curtop = 0;
    if(obj.offsetParent)
        while(1)
        {
          curtop += obj.offsetTop;
          if(!obj.offsetParent)
            break;
          obj = obj.offsetParent;
        }
    else if(obj.y)
        curtop += obj.y;
    return curtop;
  }

function getElementsByClass( searchClass, domNode, tagName) {
	if (domNode == null) domNode = document;
	if (tagName == null) tagName = '*';
	var el = new Array();
	var tags = domNode.getElementsByTagName(tagName);
	var tcl = " "+searchClass+" ";
	for(i=0,j=0; i<tags.length; i++) {
		var test = " " + tags[i].className + " ";
		if (test.indexOf(tcl) != -1)
			el[j++] = tags[i];
	}
	return el;
}

function move_div(divv,xx,yy){
var dv = document.getElementById(divv);
dv.style.left=xx+'px';
dv.style.top=yy+'px';
}

 function get_form(id_frm)
    {
        var str = '';
        var elem = document.getElementById(id_frm).elements;
        for(var i = 0; i < elem.length; i++)
        {
				var ok=1;
		  var zval=elem[i].value;
if ((elem[i].type=='checkbox')&&(!elem[i].checked)) {
var name2=elem[i].name.split('[');
name2 = name2[name2.length-1].split(']').join('');
switch(name2){
default :ok=0;break;

case 'active':zval='inactive';break;
case 'paidfree':zval='free';break;

}}
				if ((elem[i].type=='radio')&&(!elem[i].checked)) ok=0;
		  if (ok==1) str+="&"+elem[i].name+"="+escape(zval);
        } 
        return(str);
    }

