<?php
require_once "HereDoc.php";

function ShowVar($VariableName,$VariableValue){
	$ValueToShow=htmlentities($VariableValue);
	echo "<br/> Value of $VariableName is  <pre>$ValueToShow</pre>   <br/>";
}

ShowVar("AdSenseHTMLLeftTop",$AdSenseHTMLLeftTop);
ShowVar("AdSenseHTMLTop",$AdSenseHTMLTop);
ShowVar("AdSenseHTMLBottom",$AdSenseHTMLBottom);

ShowVar("AdSensePHPLeftTop",$AdSensePHPLeftTop);
ShowVar("AdSensePHPTop",$AdSensePHPTop);
ShowVar("AdSensePHPBottom",$AdSensePHPBottom);


?>