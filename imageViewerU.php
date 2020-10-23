<html>
<head><title>javascript image viewer</title>
<?php
$folder='';
if(isset($_GET['folder'])){$folder=$_GET['folder'];}else{$folder="";}


$imma=array();
$i=0;
$dir="../someFolder/".$folder."/"; //the directory to scan for images

//last modified shown at the top
function mtimecmp($a, $b){
$mt_a=filemtime($a);
$mt_b=filemtime($b);
if($mt_a == $mt_b){return 0;}else if($mt_a < $mt_b){return -1;}else{return 1;}
}
$imma=glob($dir."*.{jpg,png,gif,jpeg,bmp,JPG,PNG,GIF,JPEG,BMP,WEBP,webp}", GLOB_BRACE);
usort($imma, "mtimecmp");
array_reverse($imma);
for($j=0;$j<count($imma);$j++){$imma[$j]=basename($imma[$j]);}


if(isset($_GET['a'])){$a=$_GET['a'];}else{$a=0;}
?>

<script>
function isFullScreen(){
return (document.fullScreenElement && document.fullScreenElement !== null)
|| document.mozFullScreen
|| document.webkitIsFullScreen;
}//end is full screen

function requestFullScreen(){
var el=document.documentElement;
var rfs=el.requestFullscreen
|| el.webkitRequestFullScreen
|| el.mozRequestFullScreen
|| el.msRequestFullscreen;
rfs.call(el);
}//end request full screen 

function exitFullScreen(){
var d=document;
var rfs=d.exitFullscreen
|| d.webkitExitFullscreen
|| d.mozCancelFullScreen
|| d.msExitFullscreen ;
rfs.call(d);
}//end exit fullscreen

function toggleFullScreen(){
if(isFullScreen()){exitFullScreen();
}else{requestFullScreen();
}
}//end toggle full screen
</script>
</head>
<body style="margin:0px;overflow:hidden;" onkeydown="keydowner(event);" onkeyup="keyupper(event);" onclick="event.preventDefault();" oncontextmenu="event.preventDefault();" onmousedown="mouseNextBack(event);">
<script>

function el(a){return document.getElementById(a);}
function da(a,b){if(el(a)){el(a).innerHTML=b;}}

var imma='<?php echo json_encode($imma); ?>';
imma=JSON.parse(imma);
var dir='<?php echo $dir; ?>';
var folder='<?php echo $folder; ?>';

var a='<?php echo $a; ?>';
var imurl=dir+imma[a];//'testling.jpg';
var sliding=false;
var slideZooming=false;
var slideZoomTick=0;
var info=false;
var imRatio=1;
var bestFit=true;
var zoom=1;
var oldx=0, oldy=0;
var dragging=false;
var altKey=false;
var w=window.innerWidth;
var h=window.innerHeight;
var zoomW=w, zoomH=h, oldZoomW=zoomW, oldZoomH=zoomH;
var lefter=0, topper=0, zoomLeft=0, zoomTop=0;

window.addEventListener('resize',onWindowResize,false);

function onWindowResize(){
w=window.innerWidth;
h=window.innerHeight;
imDimSetter();
}//end on window resize

function mouseNextBack(event){
event.preventDefault();
if(event.which==2){window.close();}
if(event.which==3){
if(event.clientY<60){toggleFullScreen();
}else if(event.clientX>window.innerWidth/2){nexter();}else{backer();}
}
}//end mouseNextBack


function mousedowner(event){
event.preventDefault();
if(event.which!=3){dragging=true;}
oldx=event.clientX; 
oldy=event.clientY; 
}//end mousedowner


function mouseupper(event){
event.preventDefault();
dragging=false;
}//end mouseupper


function mousemover(event){ 
event.preventDefault();

if(dragging){ 
lefter+=event.clientX-oldx;
topper+=event.clientY-oldy;

el('vzoom').style.left=zoomLeft+lefter +'px'; 
el('vzoom').style.top=zoomTop+topper +'px'; 
oldx=event.clientX;
oldy=event.clientY;

}}//end mousemover



function mousewheeler(event, auto){
if(auto){delta=1;}else{
delta = Math.max(-1, Math.min(1, (event.wheelDelta || -event.detail)));
}

if(delta>0){ zoom=1.2; }else{ zoom=.8; 
if(zoomW<20||zoomH<20){zoom=1;}
}
if(auto){
var mousex=window.innerWidth/2;
var mousey=window.innerHeight/1;
}else{
var mousex=event.clientX;
var mousey=event.clientY;
}
var L=zoomLeft+lefter;
var T=zoomTop+topper;
var mulx=((mousex-L)/zoomW);
var muly=((mousey-T)/zoomH);

zoomW*=zoom;
zoomH*=zoom;

zoomLeft+=(oldZoomW-zoomW)*mulx;
zoomTop+=(oldZoomH-zoomH)*muly;

oldZoomW=zoomW;
oldZoomH=zoomH;

el('vzoom').style.width=zoomW+'px';
el('vzoom').style.height=zoomH+'px';

el('vzoom').style.left=zoomLeft+lefter +'px'; 
el('vzoom').style.top=zoomTop+topper +'px'; 

}//end mousewheeler


function backer(){
a--;if(a<0){a=imma.length-1;}
imurl=dir+imma[a];
el('vzoom').src=imurl;
img.src=imurl;
}//end backer

function nexter(){
a++;if(a>imma.length-1){a=0;}
imurl=dir+imma[a];
el('vzoom').src=imurl;
img.src=imurl;
}//end nexter


function keydowner(event){
if(event.keyCode==90){altKey=true;} //z (alt)
switch(event.keyCode ){
case 65: //a default view
imDimSetter();
break;
case 66: //b 
bestFit=!bestFit;
imDimSetter();
break;
case 67: //c 
sliding=!sliding;
if(sliding){ 
slider();
}else{
window.clearTimeout(slideTime);
}
break;
case 86: //v 
copyToClipboard('/var/www/html/someFolder/'+folder+'/'+imma[a]);
break;
case 68: //d
info=!info;
if(info){
el('tester').style.visibility='visible';
}else{
el('tester').style.visibility='hidden';
}
break;
case 69://e
slideZooming=!slideZooming;
if(slideZooming){ 
slideZoom();
}else{
window.clearTimeout(slideZoomTime); slideZoomTick=0; 
}
break;
case 37: //left 
nexter();
break;
case 39: //right 
backer();
break;

break;case 75: //k
//el('ifr').style.visibility='visible';
el('ifr').src='http://localhost/someFolder/deleterU.php?imurl='+encodeURIComponent(imma[a])+'&a='+a+'&folder='+folder;
a++;if(a>imma.length-1){a=0}
window.location.href='http://localhost/someFolder/imageViewerU.php?a='+a+'&folder='+folder;
break;


}
}//end keydowner

function keyupper(event){
if(event.keyCode==90){altKey=false;} //z (alt)
switch(event.keyCode ){
case 65: //a
break;
}
}//end keyupper

function slider(){
slideTime=window.setTimeout("slider();",100);
nexter();
}//end slider

function slideZoom(){
var ztime=800;
slideZoomTick++;
if(slideZoomTick==9){ztime=800;
}else if(slideZoomTick>9){
nexter();slideZoomTick=0;
}else{
mousewheeler(event, 1);
}
slideZoomTime=window.setTimeout("slideZoom();",ztime);
}//end slideZoom

</script>

<img id="vzoom" style="position:absolute;left:0px;top:0px;" onmousedown="mousedowner(event);this.style.cursor='hand';" onmousemove="mousemover(event);" onmouseup="mouseupper(event);this.style.cursor='default';" onmousewheel="mousewheeler(event);" ondblclick="bestFit=!bestFit;imDimSetter();">
</img>

<script>

el('vzoom').src=imurl;

el('vzoom').style.width=w+'px';
el('vzoom').style.height=h+'px';

el('vzoom').style.left='0px';
el('vzoom').style.top='0px';

function imDimSetter(){
zoom=1,zoomLeft=0,zoomTop=0;

w=img.width, h=img.height; 

imRatio=w/h; 
if(bestFit){h=window.innerHeight; w=h*imRatio; }

topper=window.innerHeight/2-h/2;
el('vzoom').style.top=topper+'px';
lefter=window.innerWidth/2-w/2;
el('vzoom').style.left=lefter+'px';

zoomW=w, zoomH=h, oldZoomW=zoomW, oldZoomH=zoomH;
el('vzoom').style.width=w+'px';
el('vzoom').style.height=h+'px';

da('tester',imma[a]+' --- '+a);
}//end imDimSetter

//parallel image for getting dimensions
var img=new Image();
img.onload=function(){
imDimSetter();
}//end anonymous onload function
img.src=imurl; 

function copyToClipboard(text){
window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
}
</script>

<div id="tester" style="visibility:hidden;left:10px;top:10px;position:absolute;z-index:1000000;background-color:black;color:white;font-family:monospace;font-size:16px;padding:6px;padding-left:8px;padding-right:8px;border-radius:6px;"></div>

<iframe id="ifr" src="" style="visibility:hidden;"></iframe>
</body>
</html>