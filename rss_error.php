<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/rss_error.php,v 1.1.1.1.2.2 2005/08/25 21:31:44 lsces Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: rss_error.php,v 1.1.1.1.2.2 2005/08/25 21:31:44 lsces Exp $
 * @package rss
 * @subpackage functions
 */

$feed = "Error Message";
$title = "Tiki RSS Error Message"; // TODO: make configurable
$desc = $errmsg; // TODO: make configurable
$dateId = "last_modified";
$titleId = "name";
$desc_id = "description";
$id = "errorMessage";
$home ="";
$output="";
$now = $gBitSystem->getUTCTime();
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
/**
 * jump to rss main page
 */
require( RSS_PKG_URL.'rss.php' );
die;
?>
