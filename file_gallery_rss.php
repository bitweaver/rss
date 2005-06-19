<?php
// $Header: /cvsroot/bitweaver/_bit_rss/Attic/file_gallery_rss.php,v 1.1 2005/06/19 05:03:07 bitweaver Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

require_once( '../bit_setup_inc.php' );
require_once( FILEGALS_PKG_PATH.'filegal_lib.php' );

if ($rss_file_gallery != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!$gBitUser->hasPermission( 'bit_p_view_file_gallery' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!isset($_REQUEST["gallery_id"])) {
        $errmsg=tra("No gallery_id specified");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$tmp = $filegallib->get_file_gallery($_REQUEST["gallery_id"]);
$title = "Tiki RSS feed for the file gallery: ".$tmp["name"]; // TODO: make configurable
$desc = $tmp["description"]; // TODO: make configurable
$now = date("U");
$id = "file_id";
$desc_id = "description";
$dateId = "created";
$titleId = "filename";
$readrepl = "tiki-download_file.php?$id=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $filegallib->get_files( 0,10,$dateId.'_desc', '', $_REQUEST["gallery_id"]);
  $output = "";
}

require( RSS_PKG_URL.'rss.php' );

?>
