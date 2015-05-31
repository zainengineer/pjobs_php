<?php

require_once dirname(__FILE__)."/modules/zincludethis.php";

require_once dirname(__FILE__)."/modules/classes/Sub-paging_class.php";


$sql  =   "select ID, AccessID from tblaccessjobs  where ArchieveIT='0'";

$Pairs = GetColumnPairRows($sql, "ID", "AccessID");

//printr($Pairs);

header('Content-Type: text/plain');

foreach ($Pairs as  $ID => $AccessID ){
	echo "http://www.peshawarjobs.com/showjob.php?imagefile=$AccessID.jpg\r\n";
}


?>