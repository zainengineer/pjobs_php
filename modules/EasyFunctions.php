<?php

function GetScriptName(){
	$ScriptName=basename($_SERVER['SCRIPT_NAME']);
	return $ScriptName;
}

function StartSessionIfNot(){
	if(session_id()){
		//nothing to do
	}else{
		session_start();
	}
}

?>