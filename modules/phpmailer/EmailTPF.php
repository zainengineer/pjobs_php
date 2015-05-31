<?php 
require_once "zincludethis.php";

function GetTemplateContents($name,$html=true){
		$EmailTemplateStart=GetTemplateCoreContents("StartOfEmailTemplate",$html);
		$EmailTemplateEnd=GetTemplateCoreContents("EndOfEmailTemplate",$html);
		$EmailTemplateCore=GetTemplateCoreContents($name,$html);
		
		$result=$EmailTemplateStart . $EmailTemplateCore . $EmailTemplateEnd;
		//echo "<br/> $result=$EmailTemplateStart . $EmailTemplateCore . $EmailTemplateEnd; <br/>";
		return $result;
}
function GetTemplateCoreContents($name,$html=true){
	if ($html) $field="etcontents"; else $field="ettcontents";
	
	$sql="SELECT $field from tblemailtemplate WHERE etname='$name'";
	//echo "<br/> Running query $sql <br/>";
	$result=GetQueryDefault($sql);
	return $result;
	
}
function GetParseList($ticket,$customarr=false){
	/*
	ticket, userid, 
	
	txtFirstName, txtLastName, txtEmail, txtPassword 	
	*/
	$sql="SELECT id, userid , ticket from laptoprepairs WHERE ticket='$ticket'";
	$SingleRow=GetSingleRow($sql);
	//printr($SingleRow,"Single Row1");
	$repairid=$SingleRow['id'];
	$userid=$SingleRow['userid'];
	$ticket=$SingleRow['ticket'];
	
	
	$sql="SELECT txtFirstName,txtLastName,txtEmail, txtPassword FROM corporateuser WHERE id='$userid' ";
	$SingleRow=GetSingleRow($sql);
	//printr($SingleRow,"Single Row2");
	$FirstName=$SingleRow['txtFirstName'];
	$LastName=$SingleRow['txtLastName'];
	$Email=$SingleRow['txtEmail'];
	$Password=$SingleRow['txtPassword'];
	
	$ParserList['%FirstName%']=$FirstName;
	$ParserList['%LastName%']=$LastName;
	$ParserList['%Email%']=$Email;
	$ParserList['%ticket%']=$ticket;
	$ParserList['%userid%']=$userid;
	$ParserList['%repairid%']=$repairid;
	$ParserList['%Password%']=$Password;
	if ($customarr){
		$ParserList=$ParserList+$customarr;
	}
	return $ParserList;
}


function GetUserParseList($userid,$customarr=false){
	
	
	
	$sql="SELECT txtFirstName,txtLastName,txtEmail, txtPassword FROM corporateuser WHERE id='$userid' ";
	$SingleRow=GetSingleRow($sql);
	//printr($SingleRow,"Single Row2");
	$FirstName=$SingleRow['txtFirstName'];
	$LastName=$SingleRow['txtLastName'];
	$Email=$SingleRow['txtEmail'];
	$Password=$SingleRow['txtPassword'];
	
	$ParserList['%FirstName%']=$FirstName;
	$ParserList['%LastName%']=$LastName;
	$ParserList['%Email%']=$Email;
	$ParserList['%userid%']=$userid;
	$ParserList['%Password%']=$Password;
	if ($customarr){
		$ParserList=$ParserList+$customarr;
	}
	return $ParserList;
}

function TranslateTemplate($template,$parselist){
	$keys=array_keys($parselist);
	$values=array_values($parselist);
	$replaced=str_replace($keys,$values,$template);
	return $replaced;
}
function HTMLEmails($userid){

	$sql="select textmail from corporateuser where id='$userid'";
	$text=GetQueryDefault($sql);
	$HTML=!$text;
	return $HTML;
	
}
function IsBrinksterServer(){
	$dirname=dirname(__FILE__);
	
	$filename = $dirname.'/DetectServer/BrinksterServer.txt'; 
	if (file_exists($filename)) {
		return true;		
	}else{
		return false;
	}
}

function SendTemplateEmail($mailfrom,$mailfromname,$mailto,$mailtoname,$subject,$mailbody,$htmlemail=true){
	if ($htmlemail){
		//$bodyentities=htmlentities($mailbody);
		$bodyentities=$mailbody;
	}else{
		$bodyentities="<pre>$mailbody</pre>";
	}
	$bodyentities="<hr/>".$bodyentities."<hr/>";
	
	//echo "<br/> parameters are ($mailfrom,$mailfromname,$mailto,$mailtoname,$subject, $bodyentities ,$htmlemail) <br/>";
	//echo "<br/> parameters are ($mailfrom,$mailfromname,$mailto,$mailtoname,$subject, \$bodyentities ,$htmlemail) <br/>";
	
	$BrinksterServer=IsBrinksterServer();
	
	/*
	if ($BrinksterServer){
		require_once("C:/php/includes/class.phpmailer.php");
	//	$mailfrom=strre/////////////////////////////////////////////////////////////////////////////////////////////////////
	}else{
		require_once("phpmailer/class.phpmailer.php");
	}
	*/
	require_once("phpmailer/class.phpmailer.php");
	require_once("phpmailer/language/phpmailer.lang-en.php");
	

	$mail = new PHPMailer();

	$mail->From = $mailfrom;
	$mail->FromName = $mailfromname;
	$mail->AddAddress($mailto, $mailtoname);
	$mail->Subject = $subject;
	$mail->Body    = $mailbody;

	
	if ($htmlemail){
		$mail->IsHTML(true);
	}
	
	if ($BrinksterServer) {
	
		$mail->IsSMTP();
		$mail->Host = "mail.notebookrepair.com";
		$mail->SMTPAuth = true;
		
		$mail->Username = "info@notebookrepair.com";
		$mail->Password = "3edc4rfv";
		
		$errormsg="using brinkster server host '$mail->Host' username '$mail->Username' from '$mail->From'";
	}else{
		//Norrmal phpmailer
		$errormsg="Sending from mail function";
	}

		if(!$mail->Send())
			{
				trigger_error("There was an error sending the message From ,$mailfromname to $mailto. phpmailer error info is [$mail->ErrorInfo]",E_USER_WARNING);
				//echo "There was an error sending the message From ,$mailfromname to $mailto/$mailtoname $errormsg";
				//printr($mail,"this is mail printr");
				//exit;
				return false;
			}
		
	
return true;
}

?>