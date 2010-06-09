<?php

// $Header$

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See below for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details.

// Initialization
require_once( '../../kernel/setup_inc.php' );
include_once( RSS_PKG_PATH.'rss_lib.php' );

if( !isset( $rsslib ) ) {
	$rsslib = new RssLib();
}

$gBitSystem->verifyPermission( 'p_admin' );

if( !isset( $_REQUEST["rss_id"] ) ) {
	$_REQUEST["rss_id"] = 0;
}

$gBitSmarty->assign( 'rss_id', $_REQUEST["rss_id"] );

if( isset( $_REQUEST["view"] ) ) {
	$feedHash = $rsslib->get_rss_module( $_REQUEST["view"] );
	$url = $feedHash['url'];

	//load up SimplePie
	require_once( UTIL_PKG_PATH.'simplepie/simplepie.inc' );
	$feed = new SimplePie();
	$feed->set_feed_url( $url );
	$feed->enable_cache( FALSE ); //we don't cache these previews since in theory we want to confirm that we are getting the feed ok
	$feed->init();
	$feed->handle_content_type();

	$items = $feed->get_items();
	$gBitSmarty->assign_by_ref( 'items', $items );
}

if( $_REQUEST["rss_id"] ) {
	$info = $rsslib->get_rss_module( $_REQUEST["rss_id"] );
} else {
	$info = array();

	$info["name"] = '';
	$info["description"] = '';
	$info["url"] = '';
	$info["refresh"] = 900;
	$info["show_title"] = 'n';
	$info["show_pub_date"] = 'n';
}

$gBitSmarty->assign('name', $info["name"]);
$gBitSmarty->assign('description', $info["description"]);
$gBitSmarty->assign('url', $info["url"]);
$gBitSmarty->assign('refresh', $info["refresh"]);
$gBitSmarty->assign('show_title', $info["show_title"]);
$gBitSmarty->assign('show_pub_date', $info["show_pub_date"]);

if (isset($_REQUEST["remove"])) {
	
	$rsslib->remove_rss_module($_REQUEST["remove"]);
}

if (isset($_REQUEST["save"])) {
	

	if (isset($_REQUEST['show_title']) == 'on') {
		$gBitSmarty->assign('show_title', 'y');
		$info["show_title"] = 'y';
	}
	else
	{
		$gBitSmarty->assign('show_title', 'n');
		$info["show_title"] = 'n';
	}
	if (isset($_REQUEST['show_pub_date']) == 'on') {
		$gBitSmarty->assign('show_pub_date', 'y');
		$info["show_pub_date"] = 'y';
	}
	else
	{
		$gBitSmarty->assign('show_pub_date', 'n');
		$info["show_pub_date"] = 'n';
	}

	$rsslib->replace_rss_module($_REQUEST["rss_id"], $_REQUEST["name"], $_REQUEST["description"], $_REQUEST["url"], $_REQUEST["refresh"], $info["show_title"], $info["show_pub_date"]);

	$gBitSmarty->assign('rss_id', 0);
	$gBitSmarty->assign('name', '');
	$gBitSmarty->assign('description', '');
	$gBitSmarty->assign('url', '');
	$gBitSmarty->assign('refresh', 900);
	$gBitSmarty->assign('show_title', 'n');
	$gBitSmarty->assign('show_pub_date', 'n');
}

if ( empty( $_REQUEST["sort_mode"] ) ) {
	$sort_mode = 'name_desc';
} else {
	$sort_mode = $_REQUEST["sort_mode"];
}

if (!isset($_REQUEST["offset"])) {
	$offset = 0;
} else {
	$offset = $_REQUEST["offset"];
}
if (isset($_REQUEST['page'])) {
	$page = &$_REQUEST['page'];
	$offset = ($page - 1) * $max_records;
}
$gBitSmarty->assign_by_ref('offset', $offset);

if (isset($_REQUEST["find"])) {
	$find = $_REQUEST["find"];
} else {
	$find = '';
}

$gBitSmarty->assign('find', $find);

$gBitSmarty->assign_by_ref('sort_mode', $sort_mode);
$channels = $rsslib->list_rss_modules($offset, $max_records, $sort_mode, $find);

$cant_pages = ceil($channels["cant"] / $max_records);
$gBitSmarty->assign_by_ref('cant_pages', $cant_pages);
$gBitSmarty->assign('actual_page', 1 + ($offset / $max_records));

if ($channels["cant"] > ($offset + $max_records)) {
	$gBitSmarty->assign('next_offset', $offset + $max_records);
} else {
	$gBitSmarty->assign('next_offset', -1);
}

// If offset is > 0 then prev_offset
if ($offset > 0) {
	$gBitSmarty->assign('prev_offset', $offset - $max_records);
} else {
	$gBitSmarty->assign('prev_offset', -1);
}

$gBitSmarty->assign_by_ref('channels', $channels["data"]);


// Display the template
$gBitSystem->display( 'bitpackage:rss/admin_rssmodules.tpl', NULL, array( 'display_mode' => 'admin' ));

?>

