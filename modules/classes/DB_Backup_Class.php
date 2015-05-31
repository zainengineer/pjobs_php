<?php 
require_once("classes/createZipFile.php");
class DB_Backup{

//
var $NewTables=array();
var $tableArray=array();
var $allTables=array();
var $dbName;

	function DB_Backup($dbName){
		//$dbName=$GLOBALS['ZDBSelect'];
		$sql="show tables from $dbName";
		$this->dbName=$dbName;
		$this->allTables=GetAllRows($sql);
	}
	function ProcessArray($allTables){
		for($cnt=0;$cnt<count($allTables);$cnt++){
			$allNewTables[$cnt]=$allTables[$cnt]['Tables_in_'.$this->dbName];
		}
		return $allNewTables;
	}
	function GetBackup($backupType,$TableSelectMethod,$include,$exclude){
	 	global $tableArray;
		$NewTables=array();
		$allNewTables=$this->ProcessArray($this->allTables);
		//
		if($TableSelectMethod==1)
			$NewTables=$include;
		else
			if($TableSelectMethod==2)
				$NewTables=array_diff($allNewTables,$exclude);
			else
				if($TableSelectMethod==3)
					$NewTables=$allNewTables;	
		//printr($exclude);			
		$strSql="";
		//$fullText="";
		$tableArray =array();
		$dbName="DbBackup-". date("d-M-Y");
		$dbName=dirname(__FILE__)."/../DB/".$dbName;
		if(file_exists($dbName))
		{
		echo "Directory [$dbName] is already created";
		}else{
			mkdir($dbName);
			echo "Directory [$dbName] is created";
			}
		foreach($NewTables as $tKey=>$value){
		//	$sql="SHOW COLUMNS from ". $value['Tables_in_'.$dbName];
			$TableName=$value;
			$sql="SHOW COLUMNS from ". $TableName;
			$res=GetAllRows($sql);
			$strSql.="\n DROP TABLE IF EXISTS ". $TableName .";";
			for($cnt=0;$cnt<count($res);$cnt++){
				if($res[$cnt]['Null']=='YES')
					$isNull="";
				else
					$isNull="NOT NULL";
				if($res[$cnt]['Default']!=''){
					$default=" default '".$res[$cnt]['Default']."'" ;
					$defVal=$res[$cnt]['Default'];
				}else{
					$default=" default NULL";
					$defVal="";
					}
				if($isNull=="NOT NULL" and $default==" default NULL")
					$default=" default ''";
				if($isNull=="" and $default==" default NULL")
					$defVal="Null";
				$tableArray[$TableName][$res[$cnt]['Field']]=$defVal;
			}
			$sql="show create table ".$TableName;	
			$Mvar=GetSingleRow($sql);
			//$strSql.= "\n ".$Mvar['Create Table'].";";
			$tableWise="\n ".$Mvar['Create Table'].";";
			if($backupType==2){
				//$strSql.="\n ". $this->create_backup_sql($TableName);
				$tableWise.="\n ". $this->create_backup_sql($TableName);
			}
		// to store backup by table
		$filename="$dbName/DbBackup-$TableName-". date("d-M-Y") .".txt";
		echo "<br> $filename";
		//$fileWithoutExt="DB/DbBackup-$TableName-". date("d-M-Y") ;
		//$fileNameWithoutPath="DbBackup-". date("d-M-Y").".txt";
		$this->CreateBackupFile($filename,$tableWise);
		//$this->CrateZipFile($fileWithoutExt,$fileNameWithoutPath,$tableWise);
		$tableWise="";			
		//---- End File Creation
		}
		//printr($tableArray,"new array");
		return $strSql;
	}
function CreateBackupFile($filename,$fileStr){
	$file = fopen($filename,"w");
	$out=fwrite($file, $fileStr);
	fclose($file);	
}
function CrateZipFile($filename,$fileWithoutPath,$fileStr){
//echo "<br><br><br>".$fileStr;
	$createZip = new createZip;  
	$createZip -> addDirectory("");
	//$fileContents = file_get_contents($filename.".txt");  
	$createZip -> addFile($fileStr,$fileWithoutPath);  
	//
	$fileName = $filename .".zip";
	$fd = fopen ($fileName, "w");
	$out = fwrite ($fd, $createZip -> getZippedfile());
	fclose($fd);

}	
function create_backup_sql($table_name){
	  global $tableArray;
      $sql_string = NULL;
      $table_query = mysqlquery_z("SELECT * FROM `$table_name`");
      $num_fields = mysql_num_fields($table_query);
	  $sql="SHOW COLUMNS from $table_name";
	  $table_fields=GetAllRows($sql);
	//
      while($fetch_row = mysql_fetch_array($table_query)){
        $sql_string .= "\n INSERT INTO $table_name VALUES(";
        $first = TRUE;
        for ($field_count=1;$field_count<=$num_fields;$field_count++){
			$valB4Escap=$fetch_row[($field_count - 1)];
		  	$val=mysql_real_escape_string($fetch_row[($field_count - 1)]);
			if(is_null($valB4Escap) && ($tableArray[$table_name][$table_fields[($field_count - 1)]['Field']])==0){
				$val='NULL';
			}
          if (TRUE == $first){
		  		if ($val =='NULL')
					$sql_string .= "$val";	
				else
			  		$sql_string .= "'$val'";
	          	$first = FALSE; 
          }else{
		  	if ($val =='NULL')
	            $sql_string .= ", $val";
			else
				$sql_string .= ", '$val'";
          }
        }
        $sql_string .= ");";
      }
	  return $sql_string;
    }
}
?>