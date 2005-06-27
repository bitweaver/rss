<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/wiki_rss.php,v 1.1.1.1.2.1 2005/06/27 15:56:41 lsces Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: wiki_rss.php,v 1.1.1.1.2.1 2005/06/27 15:56:41 lsces Exp $
 * @package rss
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

if ($rss_wiki != 'y') {
	$errmsg=tra("rss feed disabled");
	require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!$gBitUser->hasPermission( 'bit_p_view' )) {
	$errmsg=tra("Permission denied you cannot view this section");
	require_once( RSS_PKG_PATH.'rss_error.php' );
}

$title = $gBitSystem->getPreference( 'title_rss_wiki', "Tiki RSS feed for the wiki pages" );
$desc = $gBitSystem->getPreference( 'desc_rss_wiki', "Last modifications to the Wiki." );
$now = date("U");
$id = "title";
$desc_id = "comment";
$dateId = "last_modified";
$readrepl = WIKI_PKG_URL."index.php?page=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
	require_once( WIKI_PKG_PATH.'BitPage.php' );
	$page = new BitPage();
	$changes = $page->getList(0, $gBitSystem->getPreference('max_rss_wiki', 10), $dateId.'_desc');
	$output = "";
}

require( RSS_PKG_PATH.'rss.php' );

?>
