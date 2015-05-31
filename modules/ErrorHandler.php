<?php
if (function_exists('date_default_timezone_set')) {
	date_default_timezone_set("America/New_York"); 
}else{
}
require_once dirname(__FILE__)."/ErrorHandlerIncludes.php";
require_once dirname(__FILE__)."/returnurl.php";
require_once dirname(__FILE__)."/zincludethis.php";
global $ErrorOccured;
$ErrorOccured=false;
//echo "<br/> setting normal error hander <br/>";
$err_handler = set_error_handler("ErrorHandler");
$ErrorMessage="";

//set_time_limit(300);
global $ErrorStringsToIgnore;
$ErrorStringsToIgnore=array();
$ErrorStringsToIgnore["var: Deprecated. Please use the public/private/protected modifiers"]="This error ussually comes from phpmailer. as it is not our code it is hard to make chages and avoid creating further errors";
$ErrorStringsToIgnore["date() [function.date]: It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function. We selected 'America/New_York' for '-5.0/no DST' instead"]="This error is time zone warning we have used date function exclusively throughout our system its not possible to replace it now ";
$ErrorStringsToIgnore["date() [<a href='function.date'>function.date</a>]: It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function. We selected 'America/New_York' for '-4.0/DST' instead"]="This error is time zone warning we have used date function exclusively throughout our system its not possible to replace it now This is for summer using day time saving";
$ErrorStringsToIgnore["date() [<a href='function.date'>function.date</a>]: It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function. We selected 'America/New_York' for '-5.0/no DST' instead"]="This error is time zone warning we have used date function exclusively throughout our system its not possible to replace it now ";

function ErrorHandler($ErrorNo, $ErrorStr, $ErrorFile, $ErrorLine){
global $ErrorOccured;

	//echo "<br/> setting error handler to dummy <br/>";
	//echo "<br/>  ErrorHandler($ErrorNo, $ErrorStr, $ErrorFile, $ErrorLine)<br/>";
	if (IgnoreErrorHandlerForThisFile){
		return ;
	}
	$Notify = true;
	$Email 	= false; 
	$DBLog 	= false; 
	$Display= false; 
	$ParachinnarPost = true; 
	global $ErrorStringsToIgnore;
	global $ErrorMessage;
	//echo "<br/> error string is [$ErrorStr] <br/>";
	if (isset($ErrorStringsToIgnore[$ErrorStr])){
		//$err_handler = set_error_handler("ErrorHandler");
		//echo "<br/> as set so returning <br/>";
		return;
	}else{
		//echo "<br/> not set so not returning <br/>";
	
	}
	
	$err_handler = set_error_handler("DummyErrorHandler");
	
	$ErrorOccured=true;
	//echo "ErrorStr is [$ErrorStr]";
		//echo "<br/> errorno is '$ErrorNo'  ErrorStr is '$ErrorStr'<br/>";
	$ErrorType=GetErrorType($ErrorNo);
	$ErrorMessage =$ErrorType;
	$ErrorMessage .=" <span style='color:red'>'$ErrorStr'</span><br /> Occured in file <strong><span style='color:red'>\"$ErrorFile\"</span></strong>on line No. <b><span style='color:red'>'$ErrorLine' </span></b><br/> ";
	$ErrorMessage.="at '".date("(j-M-Y) (G:i:s)")."'"; 
	
	if($Notify){
		if($Email){
			SendErrorReportViaEmail($ErrorMessage);
		}
		
		if($ParachinnarPost){
			$ServerName=GetCurrentURL();;	
			PostErrorToParachinnar($ErrorMessage,$ServerName);
		}
		
		if($DBLog){
			
		}
		
		if($Display){
			DisplayError($ErrorMessage);
		}
	}
	
	//$err_handler = set_error_handler("ErrorHandler");
}

function ErrorMessageWithDebug_BackTrace(){
	if (IgnoreErrorHandlerForThisFile){
		return ;
	}
	global $ErrorMessage;
	$Debug_BackTrace=GetDebug_BackTrace();
	$ErrorMessageWithDebug_BackTrace=$ErrorMessage.$Debug_BackTrace;
	return $ErrorMessageWithDebug_BackTrace;
}

function GetErrorMessage(){
	global $ErrorMessage;
	return $ErrorMessage;
}

function GetServerName(){
	$ServerName=$_SERVER['HTTP_HOST'];
	return $ServerName;
}

function GetDebug_BackTrace(){
	//$debug_backtrace = var_export(debug_backtrace(), true);
	$debug_backtrace_array =debug_backtrace();
	$debug_backtrace=BackTraceWithBuffering($debug_backtrace_array);
	//printr($debug_backtrace_array,"debugbacktracearray");
	//$debug_backtrace= BacktraceWithOutGlobal($debug_backtrace_array);
	//$debug_backtrace ="Hello";
	$debug_backtrace = "<br /><br /> <font size='3'>The Debug_BackTrace is\r\n "."<br />".$debug_backtrace."</font>";
	return $debug_backtrace;
}
function BackTraceWithBuffering($backtrace){
	ob_start();
	printr($backtrace,"Back Trace");
	$return= ob_get_clean();
	return $return;
}



function OutPutWithBuffering($arrname){
	ob_start();
	echo "<pre>";
	print_r($arrname);
	
	echo "</pre>";
	
	$return= ob_get_clean();
	return $return;
}
function BacktraceWithOutGlobal($backtrace){
$return="";
	foreach ($backtrace as $key=>$value){
		if ($key=="args"){
			$arguments=GetArguments($value);
			$return.=$arguments;
		}else{
			$return.="$key ->  $value<br/>";
		}
		
	}
	$return.="<br/><br/><hr/>";
	return $return;
}
function GetArguments($arguments){
	$return="";
	foreach ($arguments as $key=>$value){
		$return.="$key -> $value <br/>";
	}
	
	return $return;
}



function GetErrorType($ErrorNo,$halt_script=true){
	switch($ErrorNo) 
	{ 
		case E_USER_NOTICE: 
			$halt_script = false;        
			$type = "Warning (E_USER_NOTICE)"; 
			break; 
		case E_NOTICE: 
			$halt_script = false;         
			$type = "Notice (E_NOTICE)"; 
			break; 
		case E_USER_WARNING: 
			$halt_script = false;        
			$type = "Warning (E_USER_WARNING)"; 
			break; 
		case E_COMPILE_WARNING: 
			$halt_script = false;        
			$type = "Warning (E_COMPILE_WARNING)"; 
			break; 
		case E_CORE_WARNING: 
			$halt_script = false;        
			$type = "Warning (E_CORE_WARNING)"; 
			break; 
		case E_WARNING: 
			$halt_script = false;        
			$type = "Warning (E_WARNING)"; 
			break; 
		case E_USER_ERROR:
			$type = "Fatal Error (E_USER_ERROR)";
				
			break;    
		case E_COMPILE_ERROR: 
			$type = "Fatal Error (E_COMPILE_ERROR)"; 
			break; 
		case E_CORE_ERROR: 
			$type = "Fatal Error (E_CORE_ERROR)"; 
			break; 
		case E_ERROR: 
			$type = "Fatal Error (E_ERROR)"; 
			break; 
		case E_PARSE: 
			$type = "Parse Error (E_PARSE)"; 
			break; 
		case E_STRICT: 
			$type = "Runtime Notice (E_STRICT)"; 
			break;
		case E_RECOVERABLE_ERROR: 
			$type = "Catchable Fatal Error (E_RECOVERABLE_ERROR)"; 
			break;
		default: 
			$type = "Unknown Error (Error type not availible)"; 
			break; 
  } 
	return $type;
}

function DummyErrorHandler($ErrorNo, $ErrorStr, $ErrorFile, $ErrorLine){
//Just to avoid recursive loops
//echo "<br/> dummy ErrorHandler <br/>";
}

 ?>