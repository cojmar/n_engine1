//==================show_file
function get_file(id){
ld('switch2','&pg=show_file&id='+id,'null', '');
}
//==================Search regular
function src_exp(regexp,string) {
var regex = new RegExp(regexp);
var match = regex.exec(string);
return match;
}

//==================Pharse upload name to get date and name
function do_up_name_date(val){
var name = document.getElementById('up_name');
var date = document.getElementById('up_date');
var datec = document.getElementById('up_date_c').checked;
var type = document.getElementById('up_type');

val = val.split('\\');val=val[val.length-1];

var tname = val.split('.');
if (type) type.value=tname[tname.length-1].toLowerCase();
tname.length = tname.length-1;
tname = tname.join('.');
var regex = /[0-9](?:[0-9]|)\.[0-9][0-9](?:\.\s|\.|\s)[0-9][0-9][0-9][0-9]/;

var src = src_exp(regex,tname);
if (src!=null){
//alert(src);
var tmp =src[0].replace(' ','').split('.');
var tdate ='';
for (var i=0;i<tmp.length ;i++ )
{
tdate +=(tdate=='')?''+tmp[i]:'/'+tmp[i];
}
if (datec) date.value=tdate;

}

if ((name)&&(name.value=='')) name.value=tname;

}

//==================Show upload window
function show_upload(para){
ld('switch2','&pg=show_up'+para,'upload', '');
}

//==================Do del
function do_del(id){
if (confirm("Sigur doriti sa stergeti fisierul cu id : "+id))
ld('switch2','&pg=do_del&id='+id,'null', '');
}

//==================Get tree 2
function get_tree2(id){

if (id==null) id='';
after=(id!='')?"get_tab('1','&name=Document Tree&type=tree');":'';
//if (document.getElementById('categ_desc')) tinyMCE.execCommand('mceRemoveControl', false, 'categ_desc');

ld('switch2','&pg=get_tree&id='+id,'null', after);
}
//==================Get tree 2
function get_tree(id){

if (id==null) id='';
after=(id!='')?"get_tab('1','&name=Document Tree&type=tree');":'';
//if (document.getElementById('categ_desc')) tinyMCE.execCommand('mceRemoveControl', false, 'categ_desc');

ld('switch2','&pg=get_tree&id='+id,'null', after);
}
//==================Get tree 
function get_tree_old(id){

if (id==null) id='';
var after='';


if (document.getElementById('categ_desc')) tinyMCE.execCommand('mceRemoveControl', false, 'categ_desc');

if (id!=''){
after="get_tab('1','&name=Document Tree&type=tree');";
}

ld('switch2','&pg=get_tree&id='+id,'tree', after);

}

//==================Get tabs
function get_tabs(){
ld('switch2','&pg=get_tabs','tabs', '');
}

//==================Get tab
function get_tab(id,para){
if (para==null) para='';
ld('switch2','&pg=get_tab&id='+id+para,'cont2', 'get_tabs();');
}

//==================Close tab/s id=0 all
function close_tab(id){
if (document.getElementById('categ_desc')) tinyMCE.execCommand('mceRemoveControl', false, 'categ_desc');
//var after=(id==0)?"get_tree('1');":'get_tabs();';
ld('switch2','&pg=close_tab&id='+id,'null', 'get_tabs();');
}

//==================Set tab 
function set_tab(el){
ld('switch2','&pg=set_tab&scrollTop='+el.scrollTop,'null', '');
}

//==================Del file
function del_file(id){
ld('switch2','&pg=del_file&id='+id,'upload', 'window.location.href=window.location.href');
}

//==================Log
function log(logt){
document.getElementById('my_log').innerHTML=logt;
}

//==================Log
function set_label(lab){
document.getElementById('big_label').innerHTML=lab;
}

//==================filter
function filter_show(val){

var els = getElementsByClass('file_list_item');
for (var el in els)
{
var dis ='block';

var node =(els[el].childNodes.length==3)?0:1;
var dta =(document.all)?els[el].childNodes[node].innerText.toLowerCase():els[el].childNodes[node].textContent.toLowerCase();
//log (dta);

if (dta.indexOf(val.toLowerCase())<0) dis='none';

els[el].style.display=dis;
}


}
//ADD EDITOR
function add_editor(id){
var instance = CKEDITOR.instances[id];
if (instance) CKEDITOR.remove(instance);
CKEDITOR.replace(id);
}

//INIT EDITOR
function init_editor(){
}
function init_editor2(){
tinyMCE.init({
	// General options
	mode : "textareas",
	theme : "advanced",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen",

	// Theme options
	theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

	skin : "o2k7",
	skin_variant : "silver",

	// Example content CSS (should be your site CSS)
	content_css : "css/example.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	},

	autosave_ask_before_unload : false // Disable for example purposes
});


}