<?php
require_once dirname(__FILE__). "/Connection.php";
require_once dirname(__FILE__). "/zinclude.php";
//echo "<br/> localrunning is '$localrunning' <br/>";
//$localrunning=true;
function GetSingleRow($sql){
global $db_connection;	
//	echo "<br/> sql inside is $sql <br/>";
	$check=ExecuteQuery($sql);	
	$numrows= mysql_num_rows($check);
	if ($numrows=0){
		return array();					
	}
					

	$row=mysql_fetch_assoc($check);
	return $row;

}
function GetAllRows($sql){
global $db_connection;
	$check=ExecuteQuery($sql);	
	$return=array();
	$i=0;
	while ($row = mysql_fetch_assoc($check)) {
		$return[$i]=$row;
		//echo "<br/> Addinng row <br/>";
		$i++;
	}
	return $return;


}
function GetColumnPairRows($sql,$keyfield,$valuefield){
global $db_connection;
	$check=mysql_query($sql,$db_connection);	
	$return=array();
	$i=0;
	//echo "<br/> Running sql $sql <br/>";
	while ($row = mysql_fetch_assoc($check)) {
		$key=$row[$keyfield];
		$value=$row[$valuefield];
		//printr($row,"row at $i ");
		//echo "<br/> $key,$value, $keyfield,$valuefield <br/>";
		$return[$key]=$value;
		//echo "<br/> Addinng row <br/>";
		$i++;
	}
	if (!$check){
		QueryError($sql);
	}
	return $return;


}
function mysqlquery_z($sql){
global $db_connection;
$result=mysql_query($sql,$db_connection);
$errordescription=mysql_error();
	if (!$result){
		//echo "<br/> will trigger error <br/>";
		trigger_error("Error [$errordescription] running query [$sql]",E_USER_ERROR);
	}
	
	return $result;
}
function ExecuteQuery($sql){
global $db_connection;global $localrunning;
//$localrunning=true;
$result=mysql_query($sql,$db_connection);
	if (!$result){		
		//echo "<br/> Error running query <br/>";
		$ErrorDescription=mysql_error();
		trigger_error("Error [$ErrorDescription] running query  [$sql] ",E_USER_ERROR);
		
		if ($localrunning){
			$error=mysql_error();			
		  //echo "<br/> error is '$error'<br/>\n while running the query $sql <br/>";
			
			}			
		
	}else{
		//echo "<br/> Successfulling run $sql <br/>";
	}
	if (strtolower(substr($sql,0,6))=="insert"){
		$lastid=mysql_insert_id($db_connection);
		return $lastid;
	}
	return $result;
}
function GetQueryDefault($sql,$row=0,$col=0){
	global $localrunning;
	$result=ExecuteQuery($sql);
	//echo "<br/> Getting default for $sql <br/>";
	$result=mysql_result($result,$row,$col);
	//echo "<br/> result is '$result' <br/>";
	if ($result===false){
			$error=mysql_error();
			trigger_error("GetDefaultQuery Error [$error] [$sql] ",E_USER_WARNING);
	}
	return $result;
}



function GetQueryDefaultBySingleRow($sql){
	
	$SingleRow=GetSingleRow($sql);
	if (!$SingleRow){
		return false;
	}else{
		//printr($SingleRow,"Single Row");
		$Keys=array_keys($SingleRow);
		$FirstKey=$Keys[0];
		return $SingleRow[$FirstKey];
	}
}

///////////////////////// Added by Bhatti
function GetEnumArray($tblName,$fldName){
$newMatch = array();
$cnt=0;
	$result="SHOW COLUMNS FROM $tblName LIKE '$fldName'";
	$row=GetSingleRow($result);
	preg_match_all("/'(.*?)'/", $row['Type'], $matches);
	for($cnt=0;$cnt<count($matches[1]);$cnt++)
		$newMatch[$cnt+1] =$matches[1][$cnt];
//	print_r($newMatch);
	return $newMatch;
}


function GetAffectedRows(){
global $db_connection;
	$rows=mysql_affected_rows ($db_connection);
	return $rows;
}

?>