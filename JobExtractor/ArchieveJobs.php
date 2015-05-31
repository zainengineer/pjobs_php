<?php
require_once dirname(__FILE__)."/ArchieveJobFunctions.php";
$FileName=__FILE__;
echo "<br/> FileName is [$FileName] <br/>";
$GLOBALS["IgnoreStamp"]=true;

AddAllJobComponents();


$CurrentJobs= GetCurrentJobsList();

//printr($CurrentJobs,"Current Jobs");

foreach ($CurrentJobs as $key=>$Item){
	//printr($Item,"$key");
	$AccessID=$Item["AccessID"];
	//echo "<br/> CurrentJobs [$AccessID] <br/>";
	if (JobExistsInHTML($AccessID)){
		//echo "<br/> Exists [$AccessID] <br/>";
	}else{
		//echo "<br/> Missing [$AccessID] <br/>";
		ArchieveJob($AccessID);
	}
	
	
}

//printr($AllJobComponents,"All Components");
echo "<br/>  <br/>";

foreach ($AllJobComponents as $key=>$Item){

	$AccessID=$Item["AccessID"];	
	//echo "<br/> AllJobComponents [$AccessID] <br/>";
}
?>