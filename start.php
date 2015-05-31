2<?php
//date_default_timezone_set("Asia/Karachi");

if (!isset($linklevel)) {
    $linklevel = "";
}
$StaticPageTitle = "PeshawarJobs for Jobs in Pakistan specially Khyber Pakhtunkhwa / NWFP , Peshawar";

if (!isset($PageTitleStart)) {
    $PageTitleStart = "";
}
else {
    $ThisPageTitle = $PageTitleStart . " - " . $StaticPageTitle;
}

if (!isset($ThisPageTitle)) {
    $ThisPageTitle = $StaticPageTitle;
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
    <title><?= $ThisPageTitle ?></title>
    <META HTTP-EQUIV="Keywords" CONTENT="Peshawar, Jobs, NWFP, Pakistan, Employment">
    <META name="verify-v1" content="cKnD7O7TTVgdacV9dBDOeaqEXfZihp3QqiadEIq8oao="/>
    <meta name="description" content="PeshawarJobs.com is a platform for you to get jobs not only in NWFP but all around Pakistan. Best thing about it is that all Jobs opportunities are free for any body to view.">
    <?php
    if (isset($GLOBALS['nocache'])) {
        if ($GLOBALS['nocache']) {
            ?>
            <META http-equiv=Cache-Control content=no-cache>
            <META http-equiv=Pragma content=no-cache>
            <META name="Expires" content="Fri, 01 Jan 1990 00:00:00 GMT">
        <?php
        }
    }

    ?>
    <link href="<?= $linklevel ?>css/pjobscss.css?1" rel="stylesheet" type="text/css"/>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body bgcolor="#FFFFFF">
<table align="center" border="0">
    <tr>
        <td align="center">
            <img src="<?= $linklevel ?>ztop.jpg?1" align="center"/>
        </td>
    </tr>
    <tr>
        <td>

            <font style="font-size: 14pt; font-family: Arial">

                <a href="<?= $linklevel ?>.">Home</a>&nbsp; -
                <a href="<?= $linklevel ?>Advertise-Jobs.php">Advertise Jobs</a>&nbsp; -
                <a href="<?= $linklevel ?>recentjobs.php">Recent Jobs</a>&nbsp; -
                <a href="<?= $linklevel ?>JobDBDisplayArchieve.php">Old Jobs</a>&nbsp; -
                <!--<a  href="<?=$linklevel?>forum/">Forum</a>&nbsp; - -->
                <a href="<?= $linklevel ?>community.php">Community</a>&nbsp;
                <a href="<?= $linklevel ?>webhosting.php">Web Hosting </a>&nbsp;-
                <a href="<?= $linklevel ?>nimaz.php">Nimaz Timings</a>&nbsp;-&nbsp;
                <a href="<?= $linklevel ?>sitemap.php">Site Map</a> -
                <a href="<?= $linklevel ?>links.php">Links</a> -
                <a href="<?= $linklevel ?>contactus.php">Contact us</a>
        </td>
    </tr>

    <tr>
        <td align="center">
            <br/>
            <?php
            //include "newslinks.php";
            ?>
        </td>
    </tr>
</table>
<br/><br/>