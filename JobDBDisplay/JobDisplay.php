<?php
require_once dirname(__FILE__) . "/../modules/zincludethis.php";
require_once dirname(__FILE__) . "/../modules/classes/Sub-paging_class.php";

$JobsPerPage = 10;
$PagesToShowAfterCurrentPage = 15;
$paging = new zpaging($JobsPerPage, $PagesToShowAfterCurrentPage);


//echo "<br />  $mainQuery <br />";
include dirname(__FILE__) . "/start.php";
$sql = "select * from tblaccessjobs where ArchieveIT='0' order by AccessID desc";
$rows = GetAllRows($sql);
$paging->query($sql);

$page = $paging->print_info();
//printr($page,"page is ");

while ($SingleRow = $paging->result_assoc()) {
    //printr($SingleRow,"Single Row");
    ?>


    <!-- Start of SingleJob  -->

    <img src="1pixel.gif" width="1" height="40"/>

    <table border="0" width="500">


        <tr bgcolor="#000000">

            <td valign="top" colspan="3" height="19" bgcolor="#FFFFFF">
                <!-- ID=[<?=$SingleRow["AccessID"]?>] -->

                <!--BeforeTitle <?=$SingleRow["ID"]?>  -->
                <?= $SingleRow["TitleLink"] ?>
                <!--AfterTitle <?=$SingleRow["ID"]?> -->
            </td>

        </tr>

        <tr>
            <td valign="top" height="19" bgcolor="#FFFFFF">
			<span class="AnnounceDate">
				Announce: <!--BeforeAnn <?=$SingleRow["ID"]?>--><?=str_replace("Announce:","",$SingleRow["AnnouncedDate"])?><!--AfterAnn <?=$SingleRow["ID"]?> -->
			</span>
            </td>

            <td valign="top" height="19" bgcolor="#FFFFFF">
			<span class="StartDate">
				Starts:<!--BeforeStartDate <?=$SingleRow["ID"]?> --><?=$SingleRow["StartDate"]?><!--AfterStartDate <?=$SingleRow["ID"]?> -->
			</span>
            </td>

            <td valign="top" height="19" bgcolor="#FFFFFF">
			<span class="EndDate">
				<!--AddStart-->Ends: <!--BeforeEnd--><?=$SingleRow["EndDate"]?><!--AfterEnd-->
			</span>
            </td>

        </tr>

        <tr>
            <td valign="top" height="19" colspan="3" bgcolor="#FFFFFF">
			<span class="JobDetails">

				<!--ContentStart--><?=$SingleRow["Content"]?><!--EndOfContent-->
			</span>
            </td>
        </tr>


        <!--BeforeAddStart-->


        <!--AfterAddEnd-->

    </table>

    <!-- End  of Single Job  -->

<?php
}
?>
    <br/>
    <script type="text/javascript"><!--
        google_ad_client = "pub-6616221852665591";
        google_alternate_color = "0000FF";
        google_ad_width = 728;
        google_ad_height = 90;
        google_ad_format = "728x90_as";
        google_ad_type = "text_image";
        //2007-01-03: bottom
        google_ad_channel = "9766385596";
        //--></script>
    <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
    <br/>
<?php


$link = $paging->print_link();
echo $link;
include dirname(__FILE__) . "/end.php";