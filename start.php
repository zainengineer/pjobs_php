<?php
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
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootswatch/3.3.4/superhero/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700|Paytone+One' rel='stylesheet' type='text/css'>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= $linklevel ?>.">Peshawar Jobs</a>
        </div>
        <div>
            <ul class="nav navbar-nav">
                <?php
                $aLinks = array(
                    "." => "Home",
                    "recentjobs.php" => "Recent Jobs",
                    "JobDBDisplayArchieve.php" => "Old Jobs",
//                    "community.php" => "Community",
                    "webhosting.php" => "Web Hosting",
                    "nimaz.php" => "Nimaz Timings",
                    "sitemap.php" => "Site Map",
                    "links.php" => "Links",
                    "contactus.php" => "Contact us",
                );
                foreach ($aLinks as $vHref => $vLabel) {
                    $vHref = $linklevel . $vHref;
                    $vLink = "<li><a href='$vHref'>$vLabel</a></li>\n";
                    echo $vLink;
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <div class="row">
        <div class="page-header">
            <h1>Peshawar Jobs <small>Jobs in Pakistan specially in Khyber Pakhtunkhwa</small></h1>
            <?php include dirname(__FILE__) . "/JobSearchCode.php"; ?>
        </div>
    </div>