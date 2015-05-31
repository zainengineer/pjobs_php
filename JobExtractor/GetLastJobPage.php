<?php

require_once dirname(__FILE__)."/ArchieveJobFunctions.php";



function ConfirmPageNumberInDB(){



	$LastPageInDB =  GetLastJobPageNumberFromDB();

	

	if ($LastPageInDB===false){

		$GetContentFromFirstPage=true;

	}else{			// in db Last Page Number is available

		//$GetContentFromFirstPage=true;

		

		$CurrentModifiedStamp = GetFileModifiedStamp();

		$DBModifiedStamp=GetFirstPageModifiedStampFromDB();

		if ($DBModifiedStamp){

			if ($DBModifiedStamp==$CurrentModifiedStamp){

				$GetContentFromFirstPage=false;

			}else{// modified stamp in db is different then that of current file

				$GetContentFromFirstPage=true;

			}

		}else{//in database no entry exists for recentjobs stamp

			PutLastModifiedStampForFirstPage($CurrentModifiedStamp);

			$DBModifiedStamp=$CurrentModifiedStamp;

			$GetContentFromFirstPage=true;

		}

	}

	

	if ($GetContentFromFirstPage){

		$FirstPageContent=GetFirstPageContent();

		$PageNumber = GetLastPageNumberFromContent($FirstPageContent);

		PutLastFileNumber($PageNumber);

		$LastPageInDB=$PageNumber;

	}

	

	return $LastPageInDB;

}

function ModifiedFirstPageAfterPageCount(){

	

}

function GetFileModifiedStamp($FileNumber=""){

	$FileName="recentjobs$FileNumber.htm";

	$FilePath="../$FileName";

	$ModifiedStamp=filemtime($FilePath);

	

	return $ModifiedStamp;

}

function GetFirstPageContent(){

	$FileName="recentjobs.htm";

	$FilePath="../$FileName";

	$content=file_get_contents($FilePath);

	return $content;

}

function GetModifiedFirstPageStampFromDB(){

	

}

printr( "7">=9,"Comparison");





//PutLastFileNumber(33);



function GetFirstPageModifiedStampFromDB(){

	

	$Condition=" Name='FirstPageModifiedStamp'";

	$sql="Select StringValue from tblsettings where $Condition";

	$StringValue=GetQueryDefaultBySingleRow($sql);

	if ($StringValue){		

		return $StringValue;

	}else{

		return false;

	}

}

function PutLastModifiedStampForFirstPage($ModifiedStamp){

	$QueryArray["Name"]="FirstPageModifiedStamp";

	$QueryArray["StringValue"]=$ModifiedStamp;

	

	$Condition=" Name='FirstPageModifiedStamp'";

	$sql="Select StringValue from tblsettings where $Condition";	

	$StringValue=GetQueryDefaultBySingleRow($sql);

	echo "<br/>StringValue [$StringValue] [$sql]<br/>";

	if ($StringValue){		

		$sql=GetUpdateQuery("tblsettings", $QueryArray ,$Condition);

	}else{

		$sql= GetInsertQuery( "tblsettings" ,$QueryArray );		

	}

	echo "<br/> PutLastModifiedStampForFirstPage sql [$sql] <br/>";

	ExecuteQuery($sql);

	//echo "<br/> Executed [$sql] <br/>";

	

	

	

}



function GetLastPageNumberFromContent($GivenContent){

	

	//printr(debug_backtrace(),"debug_backtrace");

	$start="<a href=\"recentjobs";

	$end=".htm\">Next</a>";

	//echo "<br/> Inside GetLastPageNumberFromContent($GivenContent) <br/>";

	//echo "<br/>  GetBetweenString($GivenContent ,$start,$end); <br/>";

	$BetweenGiven= GetBetweenString($GivenContent ,$start,$end);

	//printr($BetweenGiven,"BetweenGiven");

	$BetweenString=$BetweenGiven["String"];

	//echo "<br/> BetweenString [$BetweenString] <br/>";

	

	$start="recentjobs";

	$end=".htm\">--";	

	

	$NextStart=0;

	$LoopNumber=1;

	$ContinueLoop=1;

	$ContinueLoop=true;

	//printr($ContinueLoop,"ContinueLoop");

	//echo "<br/> Before ContinueLoop start <br/>";
	$SegmentString = false;

	while ($ContinueLoop){

//		echo "<br/> Before calling BetweenString <br/>";

		$Segment=GetBetweenString($BetweenString,$start,$end,$NextStart,true);

	//	printr($Segment,"Segment after GetBetweenString($BetweenString,$start,$end,$NextStart,true); ");

		

		if ($Segment===false){

			$ContinueLoop=false;

		}else{

			$SegmentString=$Segment["String"];

			$NextStart=$Segment["NextStart"];			

			$Return[$LoopNumber]=$SegmentString;

			//echo "<br/> SegmentString  is [$SegmentString] <br/>";

			$LoopNumber++;

		}

	}

	

	//$BetweenGiven= GetBetweenString($BetweenString ,$start,$end);

	//printr($BetweenGiven,"BetweenGiven");

	

	//echo "<br/> [$BetweenGiven] <br/>";

	//echo "<br/> Before returning [$SegmentString] <br/>";
	
	if (isset($SegmentString)){
		//Do nothing
	}else{
		$SegmentString=false;
	}
	
	return $SegmentString;

	

}



function PutLastFileNumber($LastFileNumber){

	if (!$LastFileNumber){

		die("LastFileNumber empty");

	}

	$QueryArray["Name"]="LastFileNumber";

	$QueryArray["StringValue"]=$LastFileNumber;

	

	$Condition=" Name='LastFileNumber'";

	$sql="Select Name from tblsettings where $Condition";	

	$StringValue=GetQueryDefaultBySingleRow($sql);

	echo "<br/>StringValue [$StringValue] [$sql]<br/>";

	if ($StringValue){		

		$sql=GetUpdateQuery("tblsettings", $QueryArray ,$Condition);

	}else{//No relevant entry available in tblsettings

		$sql= GetInsertQuery( "tblsettings" ,$QueryArray );		

		echo "<br/> No StringValue [$StringValue] [$LastFileNumber] Found using [$sql] <br/>";

	}

	ExecuteQuery($sql);

	//echo "<br/> Executed [$sql] <br/>";

	

	

	

}

function GetLastJobPageNumberFromDB(){

	

	$Condition=" Name='LastFileNumber'";

	$sql="Select StringValue from tblsettings where $Condition";

	$StringValue=GetQueryDefaultBySingleRow($sql);

	if ($StringValue){		

		return $StringValue;

	}else{

		return false;

	}

}



?>