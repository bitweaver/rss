<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/articles_rss.php,v 1.3 2005/08/30 22:30:11 squareing Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: articles_rss.php,v 1.3 2005/08/30 22:30:11 squareing Exp $
 * @author  Luis Argerich (lrargerich@yahoo.com)
 * @package rss
 */

/**
 * required setup
 */
 require_once( '../bit_setup_inc.php' );
require_once( KERNEL_PKG_PATH.'BitBase.php' );

if ($rss_articles != 'y') {
	$errmsg=tra("rss feed disabled");
	require_once( RSS_PKG_PATH.'rss_error.php' );
}

if (!$gBitUser->hasPermission( 'bit_p_read_article' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$title = "Tiki RSS feed for articles"; // TODO: make configurable
$desc = "Last articles."; // TODO: make configurable
$now = $gBitSystem->getUTCTime();
$id = "article_id";
$titleId = "title";
$desc_id = "heading";
$dateId = "publish_date";
$readrepl = ARTICLES_PKG_PATH."read.php?$id=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $gBitSystem -> list_articles(0, $max_rss_articles, $dateId.'_desc', '', $now, $user);
  $output = "";
}

require( RSS_PKG_URL.'rss.php' );

?>
