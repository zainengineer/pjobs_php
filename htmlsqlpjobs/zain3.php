<?php
set_time_limit ( 10000 );
ob_start();

	$PjobBase="http://www.peshawarjobs.com/";
	$PjobURL="$PjobBase/recentjobs.htm?" . time();	
	
 
	
	$MyTime=$today = date("D M j Y G:i:s ");
	echo ("<br/> Starting at '$MyTime' <br/>");
  //$qfbase=$qfbaseonline;


    /*
    ** htmlSQL - Example 1
    **
    ** Shows a simple query
    */
    
    require_once("snoopy.class.php");
    require_once("htmlsql.class.php");
    require_once("zinclude.php");
    require_once("imagechecker.php");
    
    
    
    // connect to a URL
		
function GetPageImageList($wsql){
	
	
	$sql="SELECT * FROM a WHERE strpos(\$href,'howjob.php?imagefile=')";
	
	
	
	if (!$wsql->query($sql)){
		print "Query error: " . $wsql->error; 
		exit;
	}
 $hrefarr=array();
	foreach($wsql->fetch_array() as $row){        
		$href=$row['href'];				
		//$pos=strpos($href,'showjob.php?imagefile=');
		$code=substr($href,22);
		//$hrefarr[$code]=$href;		
   	$hrefarr[$code]=$code;		
   	
		
	}
	return $hrefarr;
	
}

function SetNextRemoteObject($wsql){
global $PjobURL,$PjobBase;
	
	
		
	if (!$wsql)	{
		$url=		$PjobURL;
		$wsql = new htmlsql();
		if (!$wsql->connect('url', $url)){
			print 'Error while connecting: ' . $wsql->error;
			exit;
		}else{
			//echo ("<br/> connected to $url <br/>");
		}
		return $wsql;
	}else{
	
		//printrz($wsql,"wsql	");		
		$sql="SELECT * FROM a WHERE \$text=='Next'";
		
		
		if (!$wsql->query($sql)){
			print "Query error: " . $wsql->error; 
			exit;
		}else{
			//echo ("<br/> trying query '$sql' <br/>");
		}
		
		
		$row=$wsql->fetch_array();
		//printrz($row,"\$row using $sql is");
		if (!$row){
			return false;
		}else{
			$href=$row[0]['href'];
			$url="$PjobBase/$href?" . time();		
				//echo ("<br/> base is '$PjobBase' Next url is '$url' <br/>");
		}
	}
	
	
	$wsql = new htmlsql();
	if (!$wsql->connect('url', $url)){
		print 'Error while connecting: ' . $wsql->error;
		exit;
	}else{
		echo ("<br/> connected to $url <br/>");
		ob_flush();
		return $wsql;
	}
	
}	
    
		
		
		
		
	
    
	$wsql=false;
	$continueloop=true;
  $allrows=array();	
	while ($continueloop){
	
		$wsql=SetNextRemoteObject($wsql);		
		if ($wsql){
			$rows=GetPageImageList($wsql);		
			//printrz($rows,"Adding Rows");
			$allrows=$allrows+$rows;
		}
		
		if ($wsql===false) $continueloop=false;
		
	}
	//printrz($allrows,"all Rows");
	ob_flush();
	$existimg=array();
	$absentimg=array();
	
	foreach ($allrows as $key=>$value){

		$imageexist=ImageExists($key);
		if ($imageexist){
			$existimg[$key]=$key;
		}else{
			$absentimg[$key]=$key;
		}
		
		
		ob_flush();
	}
	
	printrz($absentimg,"absent links are");
	printrz($existimg,"exist links  are");

	
	include "joblist.php";
	$result = array_diff_assoc($imagearray, $existimg);
	printrz($result,"Difference is (Files to be removed)");
		
?>