<?php
require_once dirname(__FILE__)."/ExtractComponentFunctions.php";
require_once dirname(__FILE__)."/InsertJobFunctions.php";

function GetCurrentJobsList(){
	$sql="select * from tblaccessjobs where ArchieveIT=0";
	$AllRows=GetAllRows($sql);
	
	return $AllRows;
}
function JobExistsInHTML($AccessID){
	global $AllJobComponents;	
	if (isset($AllJobComponents[$AccessID]["AccessID"])){
		return true;
	}else{
		return false;
	}
	
}
function ArchieveJob($AccessID){	
	$sql="update tblaccessjobs set ArchieveIT='1' where AccessID = '$AccessID' ";
	
	ExecuteQuery($sql);
}
?>