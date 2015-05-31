<?php 
	require_once "Snoopy.class.php";
	$snoopy = new Snoopy;
	$snoopy->curl_path="C:\curl\bin\curl.exe";
	
	$submit_url="http://www.parachinnar.com/khadim/autopost.php";
	$submit_arr['id']="1007";
	$submit_arr['name']="khadim";
	$submit_arr['city']="peshawar";
	$submit_arr['org']="chinnar";
	
	
	$snoopy->submit($submit_url,$submit_arr);
	print $snoopy->results;
 ?>