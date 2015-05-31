<?php
require_once "../modules/zincludethis.php";

Function InsertJob($JobNumber){
global $AllJobComponents;
	
	$Exists=JobExists($JobNumber);
	echo "<br/> Attempting to Insert [$JobNumber] <br/>";
	if ($Exists){
	
		$UpdateArr=$AllJobComponents[$JobNumber];		
		$sql=GetUpdateQuery("tblaccessjobs", $UpdateArr , "AccessID='$JobNumber'" ,true, true);
		ExecuteQuery($sql);
		echo "<br/> Updating already exists [$JobNumber] [$sql]<br/>";
		return false;
	}else{
	
		$InsertArr=$AllJobComponents[$JobNumber];		
		$sql=GetInsertQueryWithEscape("tblaccessjobs",$InsertArr,true,true);		
		$InsertID=ExecuteQuery($sql);
		return $InsertID;
		
	}
}
function InsertAllJobs(){
global $AllJobComponents;
	printr($AllJobComponents,"AllJobComponents");
	foreach($AllJobComponents as $JobNumber=>$JobArray){
		InsertJob($JobNumber);
	}
}
function JobExists($JobNumber){
	$sql="select ID from tblaccessjobs where AccessID='$JobNumber' ";
	$SingleRow=GetSingleRow($sql);
	if ($SingleRow){
		return true;
	}else{
		return false;
	}
}
	
?>