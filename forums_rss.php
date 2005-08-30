<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/forums_rss.php,v 1.3 2005/08/30 22:30:11 squareing Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: forums_rss.php,v 1.3 2005/08/30 22:30:11 squareing Exp $
 * @package rss
 * @subpackage functions
 */
 
/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
require_once( KERNEL_PKG_PATH.'BitBase.php' );

if ($rss_forums != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if(!$gBitUser->hasPermission( 'bit_p_admin_forum' ) && !$gBitUser->hasPermission( 'bit_p_forum_read' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$title = "Tiki RSS feed for forums"; // TODO: make configurable
$desc = "Last topics in forums."; // TODO: make configurable
$now = $gBitSystem->getUTCTime();
$id = "forum_id";
$desc_id = "data";
$dateId = "comment_date";
$titleId = "title";
$readrepl = "tiki-view_forum_thread.php";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $gBitSystem -> list_all_forum_topics(0, $max_rss_forums, $dateId.'_desc', '');
  $output = "";
}

require( RSS_PKG_URL.'rss.php' );

?>
