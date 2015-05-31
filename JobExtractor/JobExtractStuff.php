<?php
require_once dirname(__FILE__)."/ExtractComponentFunctions.php";
require_once dirname(__FILE__)."/InsertJobFunctions.php";


AddAllJobComponents();

InsertAllJobs();
	
//	$sql=InsertJob(6015);
 //	echo "<br/> [$sql] <br/>";
//printr($AllJobComponents,"All Components");

/*
$SegmentString=$JobSegments[1];
$Components= GetJobComponents($SegmentString);
printr($Components,"Components");
*/

//printr($JobSegments,"JobSegments");
	
	
?>