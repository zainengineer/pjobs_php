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

    <div class="row top-buffer">
        <div class="col-xs-9">
            <!-- ID=[<?=$SingleRow["AccessID"]?>] --> <!--BeforeTitle <?=$SingleRow["ID"]?>  -->
            <?= $SingleRow["TitleLink"] ?><!--AfterTitle <?=$SingleRow["ID"]?> -->
        </div>
    </div>
    <div class="row row-dates">
        <div class="col-xs-3 AnnounceDate">
            Announce: <!--BeforeAnn <?=$SingleRow["ID"]?>-->
            <?=str_replace("Announce:","",$SingleRow["AnnouncedDate"])?><!--AfterAnn <?=$SingleRow["ID"]?> -->
        </div>
        <div class="col-xs-3 StartDate">
            Starts:<!--BeforeStartDate <?=$SingleRow["ID"]?> -->
            <?=$SingleRow["StartDate"]?><!--AfterStartDate <?=$SingleRow["ID"]?> -->
        </div>
        <div class="col-xs-3 EndDate">
            <!--AddStart-->Ends: <!--BeforeEnd--><?=$SingleRow["EndDate"]?><!--AfterEnd-->
        </div>
    </div>

    <div class="row">
        <div class="col-xs-9 JobDetails">
            <!--ContentStart--><?=$SingleRow["Content"]?><!--EndOfContent-->
        </div>
    </div>


    <!--BeforeAddStart--><!--AfterAddEnd-->


    <!-- End  of Single Job  -->
<?php
}
?>

    <div class="row">
        <div class="col-xs-9">
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
        </div>
    </div>


<?php
$link = $paging->print_link();
echo "<ul class='pagination'>
$link
</ul>";
include dirname(__FILE__) . "/end.php";