<?php 

function PostErrorToParachinnar($ErrorMessage,$ServerName){
	$backtrace=GetDebug_BackTrace();
	require_once dirname(__FILE__)."/Snoopy/Snoopy.class.php";
	$snoopy = new Snoopy;
	//$snoopy->curl_path="C:\curl\bin\curl.exe";
	$submit_url="http://www.connectpk.com/ErrorHandlerMulti/ErrorHandlerPjobs/GetErrorLog.php";
	$ErrorArr['ErrorMessage']=$ErrorMessage;
	$ErrorArr['Debug_BackTrace']=$backtrace;
	$ErrorArr['ServerName']=$ServerName;
	$GlobalsPosted=OutPutWithBuffering($GLOBALS);
	$ErrorArr['GlobalsPosted']=$GlobalsPosted;
	//echo "<br />  before snoopy submission <br />";
	//printr($ErrorArr);
	$snoopy->submit($submit_url,$ErrorArr);
	
}

function SendErrorReportViaEmail($ErrorMessage=""){
	require_once dirname(__FILE__)."/EmailTPF.php";
	$MailFromName="ErrorHandler";
	$MailFrom="ErrorHandler@Laptopservice.com";
	$MailHeaders = 'From: ErrorHandler@LaptopService.com';
	$MailToName      = 'Administrator';
	$ErrorDateTime=date("(j-M-Y) (G:i:s)");
	$MailSubject = 'LaptopService Error At '.$ErrorDateTime;
	$MailBody = "";
	if($_POST){
		$Debug_BackTrace=$_POST['Debug_BackTrace'];
		$Debug_BackTrace=$_POST['Debug_BackTrace'];
		$Debug_BackTrace= stripslashes_deep($Debug_BackTrace);
		//$Debug_BackTrace= str_replace(' DOT ', '.', $Debug_BackTrace); //replace dot by .
		$ErrorMessage=$_POST['ErrorMessage'];
		$ErrorMessage= stripslashes_deep($ErrorMessage);
		$Debug_BackTrace=$Debug_BackTrace;
		$ServerName=$_POST['ServerName'];
		$MailBody.="\r\n <b> At Server ".$ServerName."</b><br /><br />\r\n".$ErrorMessage.$Debug_BackTrace;
		}else{
		$Debug_BackTrace=GetDebug_BackTrace();
		$MailBody.="\r\n At Server".GetServerName()."\r\n".$ErrorMessage.$Debug_BackTrace;
	}
	//	$EmailList=array('support@laptopservice.com','nasir26@gmail.com','nasir@computersonics.com','zainengineer@gmail.com','khadimnaby@gmail.com');
	$EmailList=array('khadimnaby@gmail.com','zainengineer@gmail.com');
	foreach($EmailList as  $Copy){
		$MailTo =$Copy;
		SendTemplateEmail($MailFrom,$MailFromName,$MailTo,$MailToName,$MailSubject,$MailBody,1);
	}
}

function stripslashes_deep($StripSlashGivenArray){
  $StripSlashGivenArray = is_array($StripSlashGivenArray) ? 
    array_map('stripslashes_deep', $StripSlashGivenArray) : stripslashes($StripSlashGivenArray);
  return $StripSlashGivenArray;
}


function GetDBLog(){
	if($_POST){
		$ErrorArr['ErrorMessage']=$_POST['ErrorMessage'];
		$ErrorArr['Debug_BackTrace']=$_POST['Debug_BackTrace'];
		$ErrorArr['ServerName']=$_POST['ServerName'];
		$ErrorArr['LogTime']="now()";
	}else{
		$ErrorArr['ErrorMessage']=GetErrorMessage();
		$ErrorArr['Debug_BackTrace']=GetDebug_BackTrace();
		$ErrorArr['ServerName']=GetServerName();
		$ErrorArr['LogTime']="now()";
	}
	$sql=GetInsertQuery("tbllaptoperrorlog",$ErrorArr);
	ExecuteQuery($sql);
}


function DisplayError($ErrorMessage){
	$Debug_BackTrace=GetDebug_BackTrace();
	$Debug_BackTrace= stripslashes_deep($Debug_BackTrace);
	$ErrorMessage.=$Debug_BackTrace;
	echo "<br/> $ErrorMessage <br/>";
}

?>