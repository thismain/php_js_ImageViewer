<?php
$imurl=false;
$folder='';
if(isset($_GET['folder'])){$folder=$_GET['folder'];}else{$folder="";}
if(isset($_GET['imurl'])){$imurl=$_GET['imurl'];}else{$imurl=false;}

if($imurl){
unlink('../someFolder/'.$folder.'/'.$imurl);
unlink('../someFolder/'.$folder.'/thumbs/'.$imurl);
echo $imurl.' deleted';
}else{
echo 'nothing deleted';
}

?>
