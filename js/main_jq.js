var mn_c_item=0;

//=====================
function scrl_menu(inc,tt){
//=====================
if ((tt==null)||(tt==undefined)) tt=200;
var max_s_items=7;
var max_items = 0;
$('#ul1 .a').each(function(i){max_items=i;});
max_items++;
rmax_items = max_items/3;
mn_c_item +=inc;
if (inc==0) mn_c_item = rmax_items;


if (mn_c_item==max_items-rmax_items){
scrl_menu(0,0);
scrl_menu(-1,0);
mn_c_item++;
}
if (mn_c_item<0){
mn_c_item=rmax_items;
scrl_menu(0,0);
mn_c_item--;
}




$('#ul1 .a').each(function(i,item){
if (mn_c_item==i)  pos1 = $(item).position();
if (i<=mn_c_item+max_s_items) pos2 = $(item).position();
});
	
var ww =  Math.round(pos2.left-pos1.left-15);


    $('.menu_holder').animate({ 'width': ww + 'px'}, 200, function(){});

$('.menu_holder').css("margin-left",Math.round((ww/2)*-1));


    $('#scr_right').animate({ 'margin-left':Math.round(ww/2) + 'px'}, 100, function(){});
    $('#scr_left').animate({ 'margin-left':Math.round(((ww/2)*-1)-$('#scr_left').width()-20) + 'px'}, 100, function(){});

$('.menu_holder').css("height",'100%');
$('#scr_right').css("display",'block');
$('#scr_left').css("display",'block');

	var l = pos1.left*-1;
    $('#menu_cont').animate({ 'top': '0px', 'left': l + 'px'}, tt, function(){
        //end of animation.. if you want to add some code here
    });




}
