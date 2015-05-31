<?php
require_once dirname(__FILE__)."/../modules/zincludethis.php";
require_once dirname(__FILE__)."/CheckFileModification.php";
require_once dirname(__FILE__)."/GetLastJobPage.php";

function GetBetweenString($GivenString,$start,$end,$OffSet=0,$IgnoreBrackets=false){
	if ($start==""){
		$StartPos=0;
	}else{//Start Given
		$StartPos=strpos($GivenString,$start,$OffSet);
		if ($StartPos===false){
			return false;
		}
	}
	$LengthOfStart=strlen($start);
	if ($end==""){
		$EndPos=strlen($GivenString);
		$LengthOfEnd=0;
	}else{
		$EndPos=strpos($GivenString,$end,$StartPos);
		//$LengthOfStart=strlen($StartPos);
		if ($EndPos===false){
			return false;
		}
		$LengthOfEnd=strlen($end);
	}
	if ($IgnoreBrackets){
		$StartOffset=$LengthOfStart;
		$EndOffset=$LengthOfEnd + $LengthOfStart;

	}else{
		$StartOffset=0;
		$EndOffset=0;
	}
	
	
	$StringStart=$StartPos+$StartOffset;
	$StringEnd=$EndPos-$StartPos+$LengthOfEnd - $EndOffset;	
	$result=substr($GivenString,$StringStart,$StringEnd);
	
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
function GetCommentElement($GivenString, $StartComment,$EndComment){
	$Start="<!--".$StartComment;
	$End="<!--".$EndComment;
	$FirstPass=GetBetweenString($GivenString,$Start,$End,0,true);
	$FirstPass=$FirstPass["String"];
	
	$Start="-->";
	$End="";
	$SecondPass=GetBetweenString($FirstPass,$Start,$End,0,true);
	$SecondPass=$SecondPass["String"];
	return $SecondPass;
}
function GetJobComponents($SegmentString){
	//echo "<br/> SegmentString is [$SegmentString] <br/>";
	$TitleLink=GetCommentElement($SegmentString,"BeforeTitle","AfterTitle");	
	
	$JobTitle=GetBetweenString($TitleLink , ">" , "</a>" , 0 , true);
	$JobTitle = $JobTitle["String"];
	
	$AnnouncedDate=GetCommentElement($SegmentString,"BeforeAnn","AfterAnn");	
	
	$AccessID=GetBetweenString($SegmentString	, "<!--BeforeAnn " , " -->" , 0 , true);
	$AccessID = $AccessID["String"];
	
	$StartDate=GetCommentElement($SegmentString,"BeforeStartDate","AfterStartDate");	
	$EndDate=GetCommentElement($SegmentString,"BeforeEnd","AfterEnd");	
	$Content=GetCommentElement($SegmentString,"ContentStart","EndOfContent");	
	
	//echo "<br/> TitleLink [$TitleLink] JobTitle [$JobTitle] Announce [$Announce] [StartDate] [$EndDate] [$Content]<br/>";
	$Return["AccessID"]=$AccessID;
	$Return["TitleLink"]=$TitleLink;
	$Return["JobTitle"]=$JobTitle;
	$Return["AnnouncedDate"]=$AnnouncedDate;
	$Return["StartDate"]=$StartDate;
	$Return["EndDate"]=$EndDate;
	$Return["Content"]=$Content;
	
	return $Return;
}

function GetJobContent($FileNumber=""){
	$FileName="recentjobs$FileNumber.htm";
	$FilePath="../$FileName";
	$LastFileNumber=ConfirmPageNumberInDB();	
	//echo "<br/> LastFileNumber [$LastFileNumber]  FileNumber [$FileNumber] <br/>";
	if ($FileNumber > $LastFileNumber){
		return false;
	}
	//exit;
	if (file_exists($FilePath)){
		if (AddUpdateStamp($FilePath)){// return true if file modification is possible so assuming file modified
			if ($FileNumber==""){				
				$LastFileNumber= ConfirmPageNumberInDB();
				//echo "<br/> LastFileNumber [$LastFileNumber] before sending in function<br/>";
				PutLastFileNumber($LastFileNumber);
			}
				
			$content=file_get_contents($FilePath);
		}else{
			$content="";
		}
		//echo "<br/> Returning [$content] <br/>";
		return $content;
	}else{		
		//echo "<br/> Not found [$FilePath] <br/>";
		return false;		
	}
}

$AllJobComponents=array();
global $AllJobComponents;

function AddJobComponents($FileNumber=1){	
	global $AllJobComponents;
	if ($FileNumber==1) {
		$FileNumber="";
	}
	$content=GetJobContent($FileNumber);
	if ($content===false){
		return false;
	}else{
		$JobSegments=GetJobSegments($content);
        printr($JobSegments,'jobSegments for ' .$FileNumber);
		foreach ($JobSegments as $JobKey => $SegmentString){
			$Components= GetJobComponents($SegmentString);
			$AccessID=$Components["AccessID"];
			if (isset($AllJobComponents[$AccessID])){	
				//echo "<br/> Retry of [$AccessID] <br/>";
			}else{
				$AllJobComponents[$AccessID]=$Components;
			}
			
		}
		return true;
	}
}

Function AddAllJobComponents(){
	$ContinueLoop=true;
	$FileNumber=1;

	while ($ContinueLoop){	
		$ContinueLoop= AddJobComponents($FileNumber);
		$FileNumber++;	
	}

}

/*
$SegmentString=$JobSegments[1];
$Components= GetJobComponents($SegmentString);
printr($Components,"Components");
*/

//printr($JobSegments,"JobSegments");
	

?>