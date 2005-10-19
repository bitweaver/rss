<?php

// $Header: /cvsroot/bitweaver/_bit_rss/admin/admin_rssmodules.php,v 1.1.2.1 2005/10/19 22:29:59 squareing Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../../bit_setup_inc.php' );
include_once( RSS_PKG_PATH.'rss_lib.php' );

if( !isset( $rsslib ) ) {
	$rsslib = new RssLib();
}

$gBitSystem->verifyPermission( 'bit_p_admin' );

if( !isset( $_REQUEST["rss_id"] ) ) {
	$_REQUEST["rss_id"] = 0;
}

$gBitSmarty->assign( 'rss_id', $_REQUEST["rss_id"] );

if( isset( $_REQUEST["view"] ) ) {
	$data = $rsslib->get_rss_module_content( $_REQUEST["view"] );
	$items = $rsslib->parse_rss_data( $data, $_REQUEST["rss_id"] );

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
	$offset = ($page - 1) * $maxRecords;
}
$gBitSmarty->assign_by_ref('offset', $offset);

if (isset($_REQUEST["find"])) {
	$find = $_REQUEST["find"];
} else {
	$find = '';
}

$gBitSmarty->assign('find', $find);

$gBitSmarty->assign_by_ref('sort_mode', $sort_mode);
$channels = $rsslib->list_rss_modules($offset, $maxRecords, $sort_mode, $find);

$cant_pages = ceil($channels["cant"] / $maxRecords);
$gBitSmarty->assign_by_ref('cant_pages', $cant_pages);
$gBitSmarty->assign('actual_page', 1 + ($offset / $maxRecords));

if ($channels["cant"] > ($offset + $maxRecords)) {
	$gBitSmarty->assign('next_offset', $offset + $maxRecords);
} else {
	$gBitSmarty->assign('next_offset', -1);
}

// If offset is > 0 then prev_offset
if ($offset > 0) {
	$gBitSmarty->assign('prev_offset', $offset - $maxRecords);
} else {
	$gBitSmarty->assign('prev_offset', -1);
}

$gBitSmarty->assign_by_ref('channels', $channels["data"]);


// Display the template
$gBitSystem->display( 'bitpackage:rss/admin_rssmodules.tpl');

?>

