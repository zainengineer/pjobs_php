<?php
require_once "../modules/zincludethis.php";

function GetModifiedStamp($FilePath){
	$modified=filemtime($FilePath);
	return $modified;
}


function AddUpdateStamp($FilePath ){
/*
Returns true if there is a chance that file is modified
Returns false file is there is no modification or no entry found for last modificatoin
if file is not a valid html file execution of script exists by die

*/
	if (isset($GLOBALS["IgnoreStamp"])){
		if ($GLOBALS["IgnoreStamp"]){
		//echo "<br/> Ignoring addupdatestamp [$FilePath]<br/>";
			return true;			
		}
	}else{
		//echo "<br/> Not Ignoring addupdatestamp [$FilePath]<br/>";
	}
	$ModifiedStamp=filemtime($FilePath);

	$InsertArr["File"]=$FilePath;
	$format="Y-m-d H:i:s";
	$modifieddb=GetQueryDefault("SELECT FROM_UNIXTIME($ModifiedStamp)");
	$modified=date($format,$ModifiedStamp);
	//echo "<br/> [$modified] [$modifieddb] [$ModifiedStamp]<br/>";
	$InsertArr["ModifiedOn"]=$modifieddb;
	$InsertArr["EntryOn"]="now()";
	$critaria="File='$FilePath'";
	
	$sql="select ModifiedOn from tblfilemodification where $critaria";
	$LastModified=GetQueryDefaultBySingleRow($sql);
	if ($LastModified){	//Entry Exists
	
		if ($LastModified!=$modified){
			$content=file_get_contents($FilePath);
			$EndTagPos=strpos($content,"</html>");
			if ($EndTagPos===false){
				die("could not find </html> in [$FilePath]");
			}
			$sql=GetUpdateQuery("tblfilemodification",$InsertArr,$critaria);
			//echo "<br/> [$sql] <br/>";
			ExecuteQuery($sql);
			return true;
		}else{// LastModified is equal to CurrentModified
			//echo "<br/> [$FilePath][$LastModified==$modified] <br/>";
			return false;
		}
		
	}else{//Entry Does not exists
		$sql=GetInsertQuery("tblfilemodification",$InsertArr);				
		ExecuteQuery($sql);
		return true;
	}
	
	return false;
	
}

/*
$FilePath="../recentjobs.htm";
$modified = GetModifiedStamp($FilePath);

$result=AddUpdateStamp ($FilePath,$modified);
echo "<br/> [$result] <br/>";

echo "<br/> [$FilePath] [$modified] <br/>";
*/
?>