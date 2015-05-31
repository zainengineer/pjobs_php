<?php
require_once("snoopy.class.php");
require_once("zinclude.php");
	
	$snoopy = new Snoopy;
	$snoopy->expandlinks=false;
	$snoopy->fetchlinks("http://peshawarjobs.com/jobimg/");
	$links=$snoopy->results;
	$imagearray=array();
	foreach ($links as $key=>$value){
		$jpgpos=strpos($value,"jpg");
		//echo ("<br/> jpb pos is  '$jpgpos' <br/>");
		if ($jpgpos){
			$imagearray[$value]=$value;
		}
	}
	//printrz($links,"links");
	//printrz($imagearray,"imagearray");


?>