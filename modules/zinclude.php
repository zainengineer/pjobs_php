<?php
require_once "EasyFunctions.php";

$zSERVERNAME = $_SERVER["SERVER_NAME"];
if ($zSERVERNAME =='localhost') $localrunning=true;else $localrunning=false;
//$localrunning=true;
$special_returnvalues="";
global $special_returnvalues;

global $HandleErrors;

if ((isset($HandleErrors)) && (!$HandleErrors)){
	
}else{
	
	//echo "<br/> setting errorhandler <br/>";
	$IgnoreErrorHanadler=IgnoreErrorHandler();
	if (isset($IgnoreErrorHandlerForThisFile)){
		if ($IgnoreErrorHandlerForThisFile){
			$IgnoreErrorHanadler=true;
		}
	}else{
		$IgnoreErrorHandlerForThisFile=false;
	}
	if ($IgnoreErrorHanadler){
		//echo "<br />  Ignoring error handler <br />";
	}else{
		//echo "<br />  Including ErrorHandler <br />";		
		require_once dirname(__FILE__)."/ErrorHandler.php";
	}
	
}
function GetInsertQueryWithEscape($Table, $array,$ReplaceNow=true,$EscapeString=true){
	
	$comma="";
	$fields="";
	$values="";
	
   foreach ($array as $field=>$value){
	 if ($EscapeString){
		$value=mysql_escape_string($value);
	 }		
		$fields.=$comma."$field";
		$values.=$comma."'$value'";
		$comma=" , ";
	 }
	 
	$sql  = "INSERT INTO $Table ($fields) VALUES ($values) "; 
	 if ($ReplaceNow){
		$sql=str_replace("'now()'","now()",$sql);
	 }
	 
	 
	 return $sql;
	 
}
function GetInsertQuery($Table, $array,$ReplaceNow=true){
 $sql  = "INSERT INTO $Table";

   // implode keys of $array...
   $sql .= " (`".implode("`, `", array_keys($array))."`)";

   // implode values of $array...
   $sql .= " VALUES ('".implode("', '", $array)."') ";
	 if ($ReplaceNow){
		$sql=str_replace("'now()'","now()",$sql);
	 }
	 return $sql;
	 }
	 
function GetUpdateQuery($Table, $array,$where,$ReplaceNow=true, $EscapeString=false){
	$sql  = "UPDATE $Table SET ";
	$comma="";
	foreach ($array as $field=>$value){
	if ($EscapeString){
		$value=mysql_escape_string($value);
	}
	$sql.=$comma."$field='$value'";
	$comma=",";
	}
	 
	 
	 if ($where){
		$where=" WHERE ".$where;
	 }	 
	 if ($ReplaceNow){
		$sql=str_replace("'now()'","now()",$sql);
	 }
	 $sql.=$where;

	 return $sql;
}
function GetUSStatesArray($AddSelect=true){

	if ($AddSelect) $arrstate[""]="Select your state";
    $arrstate["AL"]="ALABAMA";
    $arrstate["AK"]="ALASKA";
    $arrstate["AS"]="AMERICAN SAMOA";
    $arrstate["AZ"]="ARIZONA";
    $arrstate["AR"]="ARKANSAS";
    $arrstate["CA"]="CALIFORNIA";
    $arrstate["CO"]="COLORADO";
    $arrstate["CT"]="CONNECTICUT";
    $arrstate["DE"]="DELAWARE";
    $arrstate["DC"]="Washington DC";
    $arrstate["FM"]="FSM";
    $arrstate["FL"]="FLORIDA";
    $arrstate["GA"]="GEORGIA";
    $arrstate["GU"]="GUAM";
    $arrstate["HI"]="HAWAII";
    $arrstate["ID"]="IDAHO";
    $arrstate["IL"]="ILLINOIS";
    $arrstate["IN"]="INDIANA";
    $arrstate["IA"]="IOWA";
    $arrstate["KS"]="KANSAS";
    $arrstate["KY"]="KENTUCKY";
    $arrstate["LA"]="LOUISIANA";
    $arrstate["ME"]="MAINE";
    $arrstate["MH"]="MARSHALL ISLANDS";
    $arrstate["MD"]="MARYLAND";
    $arrstate["MA"]="MASSACHUSETTS";
    $arrstate["MI"]="MICHIGAN";
    $arrstate["MN"]="MINNESOTA";
    $arrstate["MS"]="MISSISSIPPI";
    $arrstate["MO"]="MISSOURI";
    $arrstate["MT"]="MONTANA";
    $arrstate["NE"]="NEBRASKA";
    $arrstate["NV"]="NEVADA";
    $arrstate["NH"]="NEW HAMPSHIRE";
    $arrstate["NJ"]="NEW JERSEY";
    $arrstate["NM"]="NEW MEXICO";
    $arrstate["NY"]="NEW YORK";
    $arrstate["NC"]="NORTH CAROLINA";
    $arrstate["ND"]="NORTH DAKOTA";
    $arrstate["MP"]="NMI";
    $arrstate["OH"]="OHIO";
    $arrstate["OK"]="OKLAHOMA";
    $arrstate["OR"]="OREGON";
    $arrstate["PW"]="PALAU";
    $arrstate["PA"]="PENNSYLVANIA";
    $arrstate["PR"]="PUERTO RICO";
    $arrstate["RI"]="RHODE ISLAND";
    $arrstate["SC"]="SOUTH CAROLINA";
    $arrstate["SD"]="SOUTH DAKOTA";
    $arrstate["TN"]="TENNESSEE";
    $arrstate["TX"]="TEXAS";
    $arrstate["UT"]="UTAH";
    $arrstate["VT"]="VERMONT";
    $arrstate["VI"]="VIRGIN ISLANDS";
    $arrstate["VA"]="VIRGINIA";
    $arrstate["WA"]="WASHINGTON";
    $arrstate["WV"]="WEST VIRGINIA";
    $arrstate["WI"]="WISCONSIN";
    $arrstate["WY"]="WYOMING";
  
		return $arrstate;
}
function ShowSelect($selectname,$arrOptions,$selected,$id="!UseSameAsName",$UseKeysForBoth=false, $UseValuesForBoth=false){
//echo "<br/> $selectname,$selected <br/>";
if ($id=="!UseSameAsName"){
	$id=$selectname;
}
?>
 <select id="<?=$id?>" name="<?=$selectname?>">
<?php


	foreach ($arrOptions as $selectkey=>$selectvalue){		
	if ($selected==$selectkey) $selectshow=" selected "; else $selectshow="";
		$optionkey=$selectkey;
		$optionvalue=$selectvalue;
		if ($UseKeysForBoth){
			$optionvalue=$selectkey;
		}
		if ($UseValuesForBoth){
			$optionkey=$optionvalue;
		}
	?>
		<option value="<?=$optionkey?>" <?=$selectshow?>><?=$optionvalue?></option>
		<?php


	}
	?>
	</select>
	<?php


}
function ShowStateCombo($name,$selectedcode){
$states=GetUSStatesArray();
ShowSelect($name,$states,$selectedcode);
}

function printrx ( $object , $name = '' ) {

   echo "<hr/>";
	
   if ($name<>'') print ( 'printr of \'' . $name . '\' : ' ) ;
print ( '<pre>' )  ;
   if ( is_array ( $object ) ) {
       
       print_r ( $object ) ;
       
   } else {
       var_dump ( $object ) ;
   }
	 
print ( '</pre>' ) ;
	echo "<hr/>";
}

/**
 * @param $object
 * @param string $name
 */
function printr($object, $name = '')
{
    // echo "<hr/>";

    $bt = debug_backtrace();
    $file=$bt[0]['file'];
//    $file = str_replace(bp(), '', $bt[0]['file']);
    print '<div style="background: #FFFBD6">';
    $nameLine = '';
    if ($name)
        $nameLine = '<b> <span style="font-size:18px;">' . $name . '</span></b> printr:<br/>';
    print '<span style="font-size:12px;">' . $nameLine . ' ' . $file . ' on line ' . $bt[0]['line'] . '</span>';
    print '<div style="border:1px solid #000;">';
    // if ($name)
    // print ( 'printr of \'' . $name . '\' : ' ) ;
    print ('<pre>');
    if (is_array($object)) {
        print_r($object);
    }
    else {
        var_dump($object);
    }
    print ('</pre>');


    echo "</div></div><hr/>";
}



/**
 * The letter l (lowercase L) and the number 1
 * have been removed, as they can be mistaken
 * for each other.
 */

function createRandomPassword() {

    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;

    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }

    return $pass;

}
function ShowMonthSelect($selectname,$selected=""){
  
	for ($i=1;$i<=12;$i++){
		$SelectList[$i]=$i;
	}
	ShowSelect($selectname,$SelectList,$selected);
}

function ShowYearSelect($selectname,$selected="",$StartYear=2005,$EndYear=2012){
  
	for ($i=$StartYear;$i<=$EndYear;$i++){
		$SelectList[$i]=$i;
		//echo "<br/> inside showyear $i,$EndYear,$StartYear<br/>";
		
		
	}
	
	ShowSelect($selectname,$SelectList,$selected);
}

function GetQuerySS($url){
//Get QueryString Seperator
	$result= strpos($url,"?");
	if (($result===false) and (!$result)){
		return "?";
}else{
	return "&";
}	
}

function ValidEmail($email) {
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}
function QueryError($sql){
global $localrunning;
	if ($localrunning){
		$msg="Error Running Query <br/>'".$sql."'<br/> Error was <br/>". mysql_error() ;
	}else{
		$msg="Error in Query please contact webmaster";
	}
	echo "<br/> $msg <br/>";
	
}
function GetFormGet($VarName){
	if (isset($_GET[$VarName])){
		return $_GET[$VarName];
	}else{
		return false;
	}
}

function GetFileFromBuffer($filename){
//echo "<br/> getting buffer for '$filename' <br/>";
	ob_start();	
	include $filename;
	$buffer=ob_get_contents();
	ob_clean();
	//echo "<br/> buffer is '$buffer' <br/>";
	return $buffer;
}
function CreateURLParams($List,$FirstSeperatedChar=""){
	$return="";
	foreach ($List as $key=>$value){
		$encodedkey=urlencode($key);
		$encodedvalue=urlencode($value);
		
		$return.= $FirstSeperatedChar.$encodedkey . "=" . $encodedvalue;
		$FirstSeperatedChar="&";
	}
	
	return $return;
}

function IgnoreErrorHandler(){
	$dirname=dirname(__FILE__);
	
	$filename = $dirname.'/DetectServer/AddErrorHandler.txt';
	if (file_exists($filename)) {
        return false;
	}else{
        return true;
	}
}
?>