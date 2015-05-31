
<table>
<tr>
<td valign="top">
<!-- Begin RevenuePILOT.com JavaScript Include Code -->
<script language="javascript1.2" type="text/javascript" src="http://search.revenuepilot.com/servlet/search?mode=js&id=22410&tid=0&perpage=5&filter=off&skip=0&by=off&keyword=online jobs, jobs"></script>
<!-- Copyright by Revenue Pilot, Inc. -->
</td>
<td valign="top">

 <p align="center">
 <?php 
	
 if (isset($_GET['imagefile']))
	{
?>
	<img border="3"  style="border-color: blue" src="jobimg/
	<?php 	
	echo $_GET['imagefile']; 
?>">
	</p>
 <?php 		
	}
 else {
	echo 'Error: imagefile variable not set';
 }
 
 ?>
 
 

</td>
</tr>
</table>

</body></html>