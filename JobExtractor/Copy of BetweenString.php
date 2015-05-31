<?php
require_once "../functions.php";
require_once "../modules/zinclude.php";

function get_string_between($string, $start, $end){
        $string = " ".$string;
        $ini = strpos($string,$start);
        if ($ini == 0) return "";
        $ini += strlen($start);   
        $len = strpos($string,$end,$ini) - $ini;
        return substr($string,$ini,$len);
}
function GetBetweenString($GivenString,$start,$end,$OffSet=0){
	$StartPos=strpos($GivenString,$start,$OffSet);
	if ($StartPos===false){
		return false;
	}
	$EndPos=strpos($GivenString,$end,$StartPos);
	//$LengthOfStart=strlen($StartPos);
	if ($EndPos===false){
		return false;
	}
	$LengthOfEnd=strlen($end);
	
	$result=substr($GivenString,$StartPos,$EndPos-$StartPos+$LengthOfEnd);
	//echo "<br/> StartPos [$StartPos] [$EndPos] [$result]<br/>";
	$Return["String"]=$result;
	$Return["NextStart"]=$EndPos+$LengthOfEnd;
	
	return $Return;
}

function GetJobSegments($content){
	$ContinueLoop=true;
	$Return=array();
	$StartOfPattern="<!-- Start of SingleJob  -->";
	$EndOfPattern="<!-- End  of Single Job  -->";
	$NextStart=0;
	$LoopNumber=1;
	while ($ContinueLoop){
		
		$Segment=GetBetweenString($content,$StartOfPattern,$EndOfPattern,$NextStart);
		if ($Segment===false){
			$ContinueLoop=false;
		}else{
			$SegmentString=$Segment["String"];
			$NextStart=$Segment["NextStart"];			
			$Return[$LoopNumber]=$SegmentString;
			$LoopNumber++;
		}
	}
	return $Return;
	
}
$content=file_get_contents("../recentjobs.htm");
$StartOfPattern="<!-- Start of SingleJob  -->";
$EndOfPattern="<!-- End  of Single Job  -->";
/*
$Return=GetBetweenString($content,$StartOfPattern,$EndOfPattern);
$FirstJob=$Return['String'];

echo "<br/> [$FirstJob] <br/>";
$Return=GetBetweenString($content,$StartOfPattern,$EndOfPattern,$Return['NextStart']);
$SecondJob=$Return['String'];
echo "<br/> [$SecondJob] <br/>";
*/
$JobSegments=GetJobSegments($content);
printr($JobSegments,"JobSegments");

?>