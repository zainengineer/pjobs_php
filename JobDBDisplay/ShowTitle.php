<?php
require_once dirname(__FILE__)."/../modules/zincludethis.php";

//echo "<br />  $mainQuery <br />";
if (isset($_GET["imagefile"])){
	$imagefile=	$_GET["imagefile"];
	$AccessID = str_replace(".jpg","",$imagefile);
	$AccessID = str_replace(".JPG","",$AccessID);
	
	$sql="select * from tblaccessjobs where AccessID='$AccessID'";
	
	$SingleJobRow= GetSingleRow($sql);
	//printr($SingleJobRow, "$sql");
	$JobTitle=$SingleJobRow["JobTitle"];
	$JobContent=$SingleJobRow["Content"];
	$PageTitleStart = $JobTitle;
}else{
	$JobTitle="";
}