<?php
require_once "zcookie.php";
function GetReturnURL(){
	//echo "<br/> inside get return <br/>";
	if (array_key_exists("ret_page",$_GET)){
		//echo "<br/> array exists <br/>";
		if ($_GET["ret_page"]=="") {
			$ret="";}else{
			$ret="&ret_page=".$_GET["ret_page"];
			//echo ("<br/> return is $ret <br/>");
		}
	}else{
		if (array_key_exists("ret_page",$_POST)){
			$ret=$_POST["ret_page"];			
		}
	}
	if (!isset($ret)) $ret="";
	return $ret;
	
}
function GetHiddenReturnField($echoit=false){
	$ReturnURL=GetReturnURL();
	$hidden="<input type=\"hidden\" name=\"ret_page\" value=\"$ReturnURL\">\n";
	if ($echoit){
		echo $hidden;
	}
	return $hidden;
}
function GoToReturnURL($defaulturl=""){
	$ReturnURL=GetReturnURL();
	$itsheader=str_replace("&ret_page=","",$ReturnURL);
	if ($itsheader=="") $itsheader=$defaulturl;
	//echo "<br/> will go to '$itsheader' <br/>";
	//exit;
	
	//exit;
	header("Location: $itsheader");
}

function GetCurrentURL($IncludeQueryString=true)
{
  $schema = $_SERVER['SERVER_PORT'] == '443' ? 'https' : 'http';
  $host = strlen($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
	$querystring=$_SERVER['QUERY_STRING'];
	if ($querystring){
		$querystring="?".$querystring;
	}
	if (!$IncludeQueryString){
		$querystring="";
	}
  
  return $schema."://".$host.$_SERVER["PHP_SELF"].$querystring;  
}

function GoToLogin($LoginPage){
	$CurrentURL=GetCurrentURL();
	//echo "<br/> will go to '$CurrentURL' <br/>";
	//exit;
	if (substr_count($LoginPage,"?")>0){ //LoginPage has ? in start
		$seperator="&";
	}else{
		$seperator="?";
	}
	header ("Location: $LoginPage".$seperator."ret_page=" . urlencode($CurrentURL));
	exit();
}

function GoTohttps(){
	$urlc=GetCurrentURL();
	$schema=substr($urlc,0,5);	
	$local=substr($urlc,7,9);
//	echo "<br/> local is '$local' <br/>";
	
	if ($local=="sulemani:"){
		$local="localhost";
	}
//	return;
	//exit;
	
	if ($local=="localhost"){
		return;
		//echo "<br/> I will return <br/>";
		//exit;		
	}else{
		//echo "<br/> I will not return <br/>";
		//exit;
	}
	$host=$_SERVER['HTTP_HOST'];
	//echo "<br/> Host is '$host' <br/>";
	if (($host!='laptopservice.com') && ($host!='www.laptopservice.com')){
		return;
	}
	
	
	if ($schema=="http:"){
		$redirecturl=str_replace("http:","https:",$urlc);
		$redirecturlwww=substr($redirecturl,8,3);
		//echo "<br/> '$redirecturl' <br/>";
		//echo "<br/> '$redirecturlwww' <br/>";
		if ($redirecturlwww!='www'){
			$redirecturlwithwww=str_replace("https://","https://www.",$redirecturl);
		}else{
			$redirecturlwithwww=$redirecturl;
		}
		header ("Location: $redirecturlwithwww");
	}
}
function GoToWWW(){
	$urlc=GetCurrentURL();
	$schema = $_SERVER['SERVER_PORT'] == '443' ? 'https' : 'http';
	$https= $_SERVER['SERVER_PORT'] == '443' ? true : false;
	$urlstartlen= $_SERVER['SERVER_PORT'] == '443' ? 12 : 11;
	
	
	$urlstart=substr($urlc,0,$urlstartlen);	
	$local=substr($urlc,7,9);
//	echo "<br/> local is '$local' <br/>";
//echo "<br/> sceme is $schema <br/>";	
//exit;
	if ($local=="sulemani:"){
		$local="localhost";
	}
//	return;
	//exit;
	
	if ($local=="localhost"){
		return;
		//echo "<br/> I will return <br/>";
		//exit;		
	}else{
		//echo "<br/> I will not return <br/>";
		//exit;
	}
	
	$port=$_SERVER['SERVER_PORT'];
	if ($port!=80){
		return;
	}

	
	if ($https){
		if ($urlstart!="https://www.") {
			$redirecturlwithwww=str_replace("https://","https://www.",$urlc);
			header ("Location: $redirecturlwithwww");
		}
	}else{
		if ($urlstart!="http://www.") {
			$redirecturlwithwww=str_replace("http://","http://www.",$urlc);
			header ("Location: $redirecturlwithwww");
		}
	}
	//echo "<br/> schema is '$schema' <br/>";	
	
	
}

function GoTohttp(){
	$urlc=GetCurrentURL();
	$schema=substr($urlc,0,5);	

	
	$host=$_SERVER['HTTP_HOST'];
	//echo "<br/> Host is '$host' <br/>";
	//echo "<br/> schema is '$schema' <br/>";
	//echo "<br/> urlc is '$urlc' <br/>";
	
	if ($schema=="https"){
		$redirecturl=str_replace("https:","http:",$urlc);
		//echo "<br/> redirecturl is '$redirecturl' <br/>";
		header ("Location: $redirecturl");
	}
}

function SessionStartWithCookie(){
	if (!session_id()){
		session_start();
	}
	$domain=getDomain();
	setcookie("PHPSESSID",session_id(),0,"/",$domain);

}
function RemoveSessionCookie(){
		$domain=getDomain();
		setcookie("PHPSESSID","",0,"/",$domain);
		setcookie("PHPSESSID","",0,"/","www".$domain);
		setcookie("PHPSESSID","",0,"/");
}
?>