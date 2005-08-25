<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/image_gallery_rss.php,v 1.1.1.1.2.2 2005/08/25 21:31:44 lsces Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: image_gallery_rss.php,v 1.1.1.1.2.2 2005/08/25 21:31:44 lsces Exp $
 * @package rss
 * @subpackage functions
 */
 
/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
require_once( KERNEL_PKG_PATH.'BitBase.php' );
require_once( IMAGEGALS_PKG_PATH.'imagegal_lib.php' );

if ($rss_image_gallery != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!$gBitUser->hasPermission( 'bit_p_view_image_gallery' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!isset($_REQUEST["gallery_id"])) {
        $errmsg=tra("No gallery_id specified");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$tmp = $imagegallib->get_gallery($_REQUEST["gallery_id"]);
$title = "Tiki RSS feed for the image gallery: ".$tmp["name"]; // TODO: make configurable
$now = $gBitSystem->getUTCTime();
$desc = $tmp["description"]; // TODO: make configurable
$id = "image_id";
$titleId = "name";
$desc_id = "description";
$dateId = "created";
$readrepl = "tiki-browse_image.php?image_id=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $imagegallib->get_images( 0,$max_rss_image_gallery,$dateId.'_desc', '', $_REQUEST["gallery_id"]);
  $output = "";
}

require( RSS_PKG_URL.'rss.php' );

?>
