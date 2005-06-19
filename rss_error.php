<?php
$feed = "Error Message";
$title = "Tiki RSS Error Message"; // TODO: make configurable
$desc = $errmsg; // TODO: make configurable
$dateId = "last_modified";
$titleId = "name";
$desc_id = "description";
$id = "errorMessage";
$home ="";
$output="";
$now = date("U");
// get default rss feed version from database or set to 1.0 if none in there
$rss_version = $gBitSystem->getPreference("rssfeed_default_version",1);

// override version if set as request parameter
if (isset($_REQUEST["ver"]))
        if (substr($_REQUEST["ver"],0,1) == '2') {
                $rss_version = 2;
        } else $rss_version = 1;

$readrepl = "";
//$changes=array("data"=>array("name"=>tra("Error"),"description"=>$errmsg,"last_modifiedied"=>$now));
$changes=array("data"=>array());
require( RSS_PKG_URL.'rss.php' );
die;
?>
