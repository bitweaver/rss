<?php
// $Header: /cvsroot/bitweaver/_bit_rss/Attic/blogs_rss.php,v 1.1 2005/06/19 05:03:07 bitweaver Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

require_once( '../bit_setup_inc.php' );
require_once( KERNEL_PKG_PATH.'BitBase.php' );
include_once( BLOGS_PKG_PATH.'BitBlog.php' );

if ($rss_blog != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!$gBitUser->hasPermission( 'bit_p_read_blog' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!isset($_REQUEST["blog_id"])) {
        $errmsg=tra("No blog_id specified");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$id = "blog_id";
$tmp = $gBitSystem -> get_blog($_REQUEST["$id"]);
$title = "Tiki RSS feed for blog ".$tmp["title"]; // TODO: make configurable
$desc = $tmp["description"]; // TODO: make configurable
$now = date("U");
$desc_id = "data";
$dateId = "created";
$titleId = "created";
$readrepl = BLOGS_PKG_URL."view_post.php?$id=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $gBlog -> list_blog_posts($_REQUEST["$id"], 0, $max_rss_blog, $dateId.'_desc', '', $now);
  $output = "";
}

require ( RSS_PKG_URL.'rss.php' );

?>
