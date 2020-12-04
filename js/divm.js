function divm( whichLayer ,me) //------- if me is 2 = show , if me is 3 = hide  else is togle
{
var elem, vis;
if( document.getElementById ) // this is the way the standards work
 elem = document.getElementById( whichLayer );
 else if( document.all ) // this is the way old msie versions work
 elem = document.all[whichLayer];
 else if( document.layers ) // this is the way nn4 works
 elem = document.layers[whichLayer];
 vis = elem.style;
 // if the style.display value is blank we try to figure it out here
 if (vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)
 vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';
 vis.display = (vis.display==''||vis.display=='block')?'none':'block';
 if (me=='2') vis.display = 'block';
 if (me=='3') vis.display = 'none';
}