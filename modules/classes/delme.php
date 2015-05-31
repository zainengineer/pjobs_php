<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<?php
$dbName="DbBackup-". date("d-M-Y");
$dbName=dirname(__FILE__)."/../DB/".$dbName;
echo "db name is= ". dirname(__FILE__)."/../DB/".$dbName;
mkdir($dbName);
?>
</body>
</html>
