<?php
$zSERVERNAME = $_SERVER["SERVER_NAME"];
if ($zSERVERNAME =='localhost') $localrunning=true;else $localrunning=false;
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
	 
function GetUpdateQuery($Table, $array,$where){
 $sql  = "UPDATE $Table SET ";
 $comma="";
   foreach ($array as $field=>$value){
		$sql.=$comma."$field='$value'";
		$comma=",";
	 }
	 
	 
	 if ($where){
		$where=" WHERE ".$where;
	 }
	 $sql.=$where;
	 return $sql;
	 }
function GetUSStatesArray($AddSelect=true){

	if ($AddSelect) $arrstate[""]="Please Select your state";
    $arrstate["AL"]="ALABAMA";
    $arrstate["AK"]="ALASKA";
    $arrstate["AS"]="AMERICAN SAMOA";
    $arrstate["AZ"]="ARIZONA";
    $arrstate["AR"]="ARKANSAS";
    $arrstate["CA"]="CALIFORNIA";
    $arrstate["CO"]="COLORADO";
    $arrstate["CT"]="CONNECTICUT";
    $arrstate["DE"]="DELAWARE";
    $arrstate["DC"]="DISTRICT OF COLUMBIA";
    $arrstate["FM"]="FEDERATED STATES OF MICRONESIA";
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
    $arrstate["MP"]="NORTHERN MARIANA ISLANDS";
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
function ShowSelect($selectname,$arrOptions,$selected){
//echo "<br/> $selectname,$selected <br/>";
?>
 <select name="<?=$selectname?>">
<?php


	foreach ($arrOptions as $selectkey=>$selectvalue){		
	if ($selected==$selectkey) $selectshow=" selected "; else $selectshow="";
	?>
		<option value="<?=$selectkey?>" <?=$selectshow?>><?=$selectvalue?></option>
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

function printrz ( $object , $name = '' ) {

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


?>