<?php
require_once "HereDoc.php";
global $ContentReplace;
$ContentReplace=array();
//$ContentReplace["\r\r"]="\r\n\r";
$ContentReplace[$AdSenseHTMLLeftTop]=$AdSensePHPLeftTop;
$ContentReplace[$AdSenseHTMLTop]=$AdSensePHPTop;
$ContentReplace[$AdSenseHTMLBottom]=$AdSensePHPBottom;
$ContentReplace[$AdSenseHTMLBottom]=$AdSensePHPBottom;
$ContentReplace[$SearchJobsCaptionHTML]=$SearchJobsCaptionPHP;
$ContentReplace[$JobSeperatorHTML]=$JobSeperatorPHP;
$ContentReplace[$JobTitleFontsHTML]=$JobTitleFontsPHP;
$ContentReplace[$EmptyAdsHTML]=$EmptyAdsPHP;
$ContentReplace[$tdforadsHTML]=$tdforadsPHP;
$ContentReplace[$JobTableStartHTML]=$JobTableStartPHP;
$ContentReplace[$LeftAddTdHTML]=$LeftAddTdPHP;
$ContentReplace[$PJobContentsOffsetHTML]=$PJobContentsOffsetPHP;


$pos=strpos($content, $AdSenseHTMLLeftTop);
	//echo "<br/> Position is [$pos] <br/>";
	
function ReplaceAds($contentGiven){
	global $ContentReplace;
	
	$contentWindowFormat=preg_replace("/(\r\n|\n|\r)/", "\r\n", $contentGiven);
	//$contentWindowFormat=$contentGiven;
	//file_put_contents("content.txt",$contentWindowFormat);
	
	foreach($ContentReplace as $Key=>$Value){
		$count=0;
		//$contentWindowFormat=str_replace($Key,$Value,$contentWindowFormat,$count);
		$contentWindowFormat=str_replace($Key,$Value,$contentWindowFormat);
		
		$KeyToShow=htmlentities($Key);
		$ValueToShow=htmlentities($Value);
		if ($count){
			$counttoshow="[$count] replaced";
		}else{
			$counttoshow="<font color='red'>[".$count."] replaced</font>";
		}
		//echo "<br/> Replace <pre>[$KeyToShow]</pre> with  <pre>[$ValueToShow]</pre> $counttoshow  <br/>";
	}
	$contententity=htmlentities($contentWindowFormat);
	$contententity=nl2br($contententity);
	
	
	//echo "<br/> Conents is [$contententity] <br/>";
	/* 
	echo "Result is <pre>";
	print_r($result);
	echo "</pre>";
	*/
	
	return $contentWindowFormat;
}

?>