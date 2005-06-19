<?php

// $Header: /cvsroot/bitweaver/_bit_rss/admin/index.php,v 1.1 2005/06/19 05:03:07 bitweaver Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

// Initialization
require_once( '../../bit_setup_inc.php' );

include_once( RSS_PKG_PATH.'rss_lib.php' );

if (!isset($rsslib)) {
	$rsslib = new RssLib();
}

if (!$gBitUser->isAdmin()) {
	$smarty->assign('msg', tra("You dont have permission to use this feature"));

	$gBitSystem->display( 'error.tpl' );
	die;
}

if (!isset($_REQUEST["rss_id"])) {
	$_REQUEST["rss_id"] = 0;
}

$smarty->assign('rss_id', $_REQUEST["rss_id"]);

$smarty->assign('preview', 'n');

if (isset($_REQUEST["view"])) {
	$smarty->assign('preview', 'y');

	$data = $rsslib->get_rss_module_content($_REQUEST["view"]);
	$items = $rsslib->parse_rss_data($data, $_REQUEST["rss_id"]);

	$smarty->assign_by_ref('items', $items);
}

if ($_REQUEST["rss_id"]) {
	$info = $rsslib->get_rss_module($_REQUEST["rss_id"]);
} else {
	$info = array();

  // default for new rss feed:
	$info["name"] = '';
	$info["description"] = '';
	$info["url"] = '';
	$info["refresh"] = 1;
	$info["show_title"] = 'n';
	$info["show_pub_date"] = 'n';
}

$smarty->assign('name', $info["name"]);
$smarty->assign('description', $info["description"]);
$smarty->assign('url', $info["url"]);
$smarty->assign('refresh', $info["refresh"]);
$smarty->assign('show_title', $info["show_title"]);
$smarty->assign('show_pub_date', $info["show_pub_date"]);

if (isset($_REQUEST["remove"])) {
	
	$rsslib->remove_rss_module($_REQUEST["remove"]);
}

if (isset($_REQUEST["save"])) {
	

	if (isset($_REQUEST['show_title']) == 'on') {
		$smarty->assign('show_title', 'y');
		$info["show_title"] = 'y';
	}
	else
	{
		$smarty->assign('show_title', 'n');
		$info["show_title"] = 'n';
	}
	if (isset($_REQUEST['show_pub_date']) == 'on') {
		$smarty->assign('show_pub_date', 'y');
		$info["show_pub_date"] = 'y';
	}
	else
	{
		$smarty->assign('show_pub_date', 'n');
		$info["show_pub_date"] = 'n';
	}

	$rsslib->replace_rss_module($_REQUEST["rss_id"], $_REQUEST["name"], $_REQUEST["description"], $_REQUEST["url"], $_REQUEST["refresh"], $info["show_title"], $info["show_pub_date"]);

	$smarty->assign('rss_id', 0);
	$smarty->assign('name', '');
	$smarty->assign('description', '');
	$smarty->assign('url', '');
	$smarty->assign('refresh', 900);
	$smarty->assign('show_title', 'n');
	$smarty->assign('show_pub_date', 'n');
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
$smarty->assign_by_ref('offset', $offset);

if (isset($_REQUEST["find"])) {
	$find = $_REQUEST["find"];
} else {
	$find = '';
}

$smarty->assign('find', $find);

$smarty->assign_by_ref('sort_mode', $sort_mode);
$channels = $rsslib->list_rss_modules($offset, $maxRecords, $sort_mode, $find);

$cant_pages = ceil($channels["cant"] / $maxRecords);
$smarty->assign_by_ref('cant_pages', $cant_pages);
$smarty->assign('actual_page', 1 + ($offset / $maxRecords));

if ($channels["cant"] > ($offset + $maxRecords)) {
	$smarty->assign('next_offset', $offset + $maxRecords);
} else {
	$smarty->assign('next_offset', -1);
}

// If offset is > 0 then prev_offset
if ($offset > 0) {
	$smarty->assign('prev_offset', $offset - $maxRecords);
} else {
	$smarty->assign('prev_offset', -1);
}

$smarty->assign_by_ref('channels', $channels["data"]);


// Display the template
$gBitSystem->display( 'bitpackage:rss/admin_rssmodules.tpl');

?>
