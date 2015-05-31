<?php
include dirname(__FILE__)."/ShowJobArray.php";
if (isset($_GET['imagefile'])){
	$imagename=$_GET['imagefile'];
}else{
	$imagename="";
}
if (isset($ShowJobArr[$imagename])){
	$TargetPath=$ShowJobArr[$imagename];
	//header ("Location: jobdetails/$TargetPath");
	include dirname(__FILE__)."/start.php";
	include "jobdetails/$TargetPath";
	include dirname(__FILE__)."/end.php";
	exit;
}
?>