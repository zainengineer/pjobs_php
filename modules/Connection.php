<?
$GLOBALS['ZDBHost']="localhost";
if (isset($_SERVER["HTTP_HOST"])){
	$HostName = $_SERVER["HTTP_HOST"];
}
else{
	$HostName = 'unknown';
}

$HostName = $_SERVER["HTTP_HOST"];

if ($HostName=="localhost"){	
	$GLOBALS['ZDBUser']="root";	
	$GLOBALS['ZDBPassword']="";	
	$GLOBALS['ZDBSelect']="pjobs";	
}elseif ($HostName="peshawarjobs.com"){	
	$GLOBALS['ZDBUser']="peshawar_jobs";	
	$GLOBALS['ZDBPassword']="aaa";	
	$GLOBALS['ZDBSelect']="peshawar_pjobs";		
}else{		
	$GLOBALS['ZDBUser']="peshawar_jobs";
	$GLOBALS['ZDBPassword']="aaa";
	$GLOBALS['ZDBSelect']="peshawar_pjobs";		
}
//$GLOBALS['ZDBHost']="mysql6.brinkster.com";
$db_connection = mysql_connect( $GLOBALS['ZDBHost'] , $GLOBALS['ZDBUser'], $GLOBALS['ZDBPassword']) or trigger_error("Unable To connect using $GLOBALS[ZDBHost]",E_USER_ERROR);
mysql_select_db ( $GLOBALS['ZDBSelect'] ,$db_connection ) or trigger_error("Unable To Select DB $GLOBALS[ZDBSelect]",E_USER_ERROR);
if (!$db_connection){
    echo "unable to connect to database";
    die;
}
if (!mysql_select_db ( $GLOBALS['ZDBSelect'] ,$db_connection )){
    echo "<br/> unable to connect to db <br/>";
    die;
}

?>