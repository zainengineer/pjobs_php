<?
// see online: http://kentung.f2o.org/scripts/paging/sample1.php
require("paging_class.php");

$paging=new paging(1,5);
//$paging->db("localhost","chinnar_laptop","service123","chinnar_laptoprepair");
//$paging->db("mysql6.brinkster.com","laptoprepair","runforest","nbrepair");
$paging->db("localhost","root","aaa","laptoprepair");
$paging->query("select * from laptoprepairs");

$page=$paging->print_info();
	//echo "Data $page[start] - $page[end] of $page[total] [Total $page[total_pages] Pages]<hr>\n";

while ($result=$paging->result_assoc()) {
	echo $paging->print_no()." : ";
	echo "$result[id]<br>\n";
}

echo "<hr>".$paging->print_link();
?>