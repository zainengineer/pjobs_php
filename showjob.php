<?php
include dirname(__FILE__)."/JobDBDisplay/ShowTitle.php";
include dirname(__FILE__)."/jobdetails/ShowJob.php";
include "start.php";
?>
		<form>
<input type="button" name="Back" value="Go Back" onClick="history.back();">

</form>
<h1 ><?=$JobTitle?></h1>
<table >
  <tr>

    <td >

		<!-- Top Add--><script type="text/javascript"><!--
google_ad_client = "pub-6616221852665591";
google_alternate_color = "0000FF";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
//2007-01-03: scantop
google_ad_channel = "8346575197";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

</td>
  </tr>
  <tr>
    <td ><!-- Image-->
		
	
<!-- AddThis Button BEGIN -->
<script type="text/javascript">var addthis_pub="zainengineer";</script>
<a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
<!-- AddThis Button END -->


<br/>
<br/>
	
 <?php 
	
 if (isset($_GET['imagefile']))
	{
		$filename=$_GET['imagefile'];
		$filename="jobimg/$filename";
		$FileExists=file_exists($filename);
        if (!$FileExists){
            $filename = 'job_archive_img/' . $_GET['imagefile'];
            $FileExists = file_exists($filename);
        }
		$DescriptiveAdd = ( strpos($JobContent , $_GET['imagefile']) === false);
		if ($JobContent==""){
			$DescriptiveAdd=false;
		}
		//echo "<br/> DescriptiveAdd [$DescriptiveAdd] <br/>";
		//echo "<br/> JobContent is [" .  htmlentities($JobContent) . "] <br/>";
		if ($FileExists){
			//echo "<br/> [$filename] exists <br/>";
		
		
?><p align="center">
	<img border="3"  alt="Loading Job Scan ...." style="border-color: blue" src="<?php echo $filename; ?>?3">
	</p>
 <?php 		
		}else{ //File Does not Exist
		//echo "<br/> FileExists [$FileExists] [$filename] <br/>";
		}
		
		if ($DescriptiveAdd){
			echo "<br/> $JobContent <br/>";
		}
		
	}
 else {
	echo 'Error: imagefile variable not set';
 }
 
 ?>
		
		</td>
  </tr>
  <tr>
    <td >
		&nbsp; </td>
  </tr>
</table>

<?php
if (!isset($DescriptiveAdd)){
	$DescriptiveAdd=false;
}
if (!$DescriptiveAdd){
			
		

?>
<p align="center">PeshawarJobs.com helps you find jobs in Peshawar, NWFP and all over Pakistan. PeshawarJobs.com is platform for JobSeekers to find jobs while sitting in their homes and offices. You don't need to check newspapers of Peshawar, NWFP or Pakistan to search for jobs. All you have to do is to go to <a href="http://www.PeshawarJobs.com" >PeshawarJobs.com</a> . Choose the Job which suits you. See details of jobs. And apply for Jobs. Keep visiting PeshawarJobs.com for Job Opportunities. Don't miss your career opportunities. Wish you best of Luck. </p>
<?php
}

?>

<br/>
<br/>
<!-- AddThis Button BEGIN -->
<script type="text/javascript">var addthis_pub="zainengineer";</script>
<a href="http://www.addthis.com/bookmark.php?v=20" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()"><img src="http://s7.addthis.com/static/btn/lg-addthis-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/200/addthis_widget.js"></script>
<!-- AddThis Button END -->

<br/>
<script type="text/javascript"><!--
google_ad_client = "pub-6616221852665591";
google_alternate_color = "0000FF";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
//2007-01-03: scanBottom
google_ad_channel = "6109796123";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

<form>
<input type="button" name="Back" value="Go Back" onClick="javascript:history.back();">

</form>

<?php
include "end.php";
?>