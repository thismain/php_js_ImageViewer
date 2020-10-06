<html>
<head>
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

function toggleFullScreen(event){
if(event.which==3){
if(isFullScreen()){exitFullScreen();
}else{requestFullScreen();
}
}}//end toggle full screen
</script>
</head>
<body style="margin:0px;" onmousedown="toggleFullScreen(event);" oncontextmenu="event.preventDefault();">
<?php
$folder='';
if(isset($_GET['folder'])){$folder=$_GET['folder'];}else{$folder="";}

$imma=array();
$typa=array();
//$i=0;
$dir="../someFolder/".$folder."/"; //the directory to scan for images

//last modified shown at the top
function mtimecmp($a, $b){
$mt_a=filemtime($a);
$mt_b=filemtime($b);
if($mt_a == $mt_b){return 0;}else if($mt_a < $mt_b){return -1;}else{return 1;}
}
$imma=glob($dir."*.{jpg,png,gif,jpeg,bmp,gif,JPG,PNG,GIF,JPEG,BMP,GIF}", GLOB_BRACE);
usort($imma, "mtimecmp");
array_reverse($imma);
for($j=0;$j<count($imma);$j++){$imma[$j]=basename($imma[$j]);}


for($i=0;$i<count($imma);$i++){
          $it=strpos($imma[$i],".jpg");$itype='.jpg';
if(!$it){$it=strpos($imma[$i],".JPEG");$itype='.JPEG';}
if(!$it){$it=strpos($imma[$i],".JPG");$itype='.JPG';}
if(!$it){$it=strpos($imma[$i],".PNG");$itype='.PNG';}
if(!$it){$it=strpos($imma[$i],".jpeg");$itype='.jpeg';}
if(!$it){$it=strpos($imma[$i],".png");$itype='.png';}
if(!$it){$it=strpos($imma[$i],".gif");$itype='.gif';}
if(!$it){$it=strpos($imma[$i],".GIF");$itype='.GIF';}
if($it){$typa[$i]=$itype;}
}



function make_thumb($src, $dest, $desired_height, $imtype){
if($imtype=='.jpg'||$imtype=='.JPG'||$imtype=='.jpeg'||$imtype=='.JPEG'){
$source_image = imagecreatefromjpeg($src);
}else if($imtype=='.png'||$imtype=='.PNG'){
$source_image = imagecreatefrompng($src);
}else if($imtype=='.gif'||$imtype=='.GIF'){
$source_image = imagecreatefromgif($src);
}

$width = imagesx($source_image);
$height = imagesy($source_image);

$desired_width = floor($width * ($desired_height / $height));

$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

if($imtype=='.jpg'||$imtype=='.JPG'||$imtype=='.jpeg'||$imtype=='.JPEG'){
imagejpeg($virtual_image, $dest);
}else if($imtype=='.png'||$imtype=='.PNG'){
imagepng($virtual_image, $dest);
}
}//end make_thumb

for($i=0;$i<count($imma);$i++){
if(!file_exists($dir.'thumbs/'.$imma[$i])){
make_thumb($dir.$imma[$i], $dir.'thumbs/'.$imma[$i], 150, $typa[$i]);
}
echo '<a target="_blank" href="../someFolder/imageViewerU.php?a='.$i.'&folder='.$folder.'"><img src="'.$dir.'thumbs/'.$imma[$i].'"></img></a>';
}


?>

</body>
</html>

