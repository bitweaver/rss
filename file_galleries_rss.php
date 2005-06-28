<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/file_galleries_rss.php,v 1.2 2005/06/28 07:45:56 spiderr Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: file_galleries_rss.php,v 1.2 2005/06/28 07:45:56 spiderr Exp $
 * @package rss
 * @subpackage functions
 */
 
/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
require_once( FILEGALS_PKG_PATH.'filegal_lib.php' );

if ($rss_file_galleries != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!$gBitUser->hasPermission( 'bit_p_view_file_gallery' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$title = "Tiki RSS feed for file galleries"; // TODO: make configurable
$desc = "Last files uploaded to the file galleries."; // TODO: make configurable
$now = date("U");
$id = "file_id";
$desc_id = "description";
$dateId = "created";
$titleId = "filename";
$readrepl = "tiki-download_file.php?$id=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $filegallib->list_files(0, $max_rss_file_galleries, $dateId.'_desc', '');
  $output="";
}

require( RSS_PKG_URL.'rss.php' );

?>
