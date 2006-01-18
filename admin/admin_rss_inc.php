<?php

// $Header: /cvsroot/bitweaver/_bit_rss/admin/admin_rss_inc.php,v 1.1.1.1.2.2 2005/10/19 22:29:59 squareing Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

foreach( $gBitSystem->mPackages as $pkg => $pkgInfo ) {
	if( is_file( $pkgInfo['path'].$pkg.'_rss.php' ) ) {
		$formRSSFeeds['rss_'.$pkg] = array(
			'label' => $pkg,
		);
	}
}
$gBitSmarty->assign( "formRSSFeeds", $formRSSFeeds );

$formRSSSettings = array(
	'rssfeed_language' => array(
		'label' => 'Language',
	),
	'rssfeed_creator' => array(
		'label' => 'Creator',
	),
	'rssfeed_editor' => array(
		'label' => 'Editor',
		'note' => 'Email address for person responsible for editorial content. For RDF 2.0',
	),
	'rssfeed_webmaster' => array(
		'label' => 'Webmaster',
		'note' => 'Email address for person responsible for technical issues relating to channel. For RDF 2.0',
	),
	'rssfeed_image_url' => array(
		'label' => 'Image URL',
		'note' => 'Enter the full URL to an image that you want to associate with your RSS channels',
	),
);
$gBitSmarty->assign( "formRSSSettings",$formRSSSettings );

$feedTypes = array(
	0 => "RSS 0.91",
	1 => "RSS 1.0",
	2 => "RSS 2.0",
	3 => "PIE 0.1",
	4 => "MBOX",
	5 => "ATOM",
	6 => "ATOM 0.3",
	7 => "OPML",
	8 => "HTML",
	9 => "JS",
);
$gBitSmarty->assign( "feedTypes",$feedTypes );

if( !empty( $_REQUEST['feed_settings'] ) ) {
	// save package specific RSS feed settings
	foreach( array_keys( $formRSSFeeds ) as $item ) {
		simple_set_toggle( $item );
		simple_set_int( 'max_'.$item );
		simple_set_value( 'title_'.$item );
		simple_set_value( 'desc_'.$item );
	}
	
	// deal with the RSS settings
	foreach( array_keys( $formRSSSettings ) as $item ) {
		simple_set_value( $item );
	}
	simple_set_value( 'rssfeed_default_version' );
}
?>
