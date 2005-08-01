<?php

// $Header: /cvsroot/bitweaver/_bit_rss/admin/admin_rss_inc.php,v 1.2 2005/08/01 18:41:19 squareing Exp $

// Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.

foreach( array_keys( $gBitSystem->mPrefs ) as $rss_feed ) {
	if( preg_match( "/^rss_/",$rss_feed ) ) {
		$rss_name = preg_replace( "/rss_/","",$rss_feed );
		$formRSSFeeds[$rss_feed] = array(
			'label' => $rss_name,
			'note' => '',
		);
	}
}
$gBitSmarty->assign( "formRSSFeeds",$formRSSFeeds );

$formRSSSettings = array(
	'rssfeed_language' => array(
		'label' => 'Language',
	),
	'rssfeed_publisher' => array(
		'label' => 'Publisher',
		'note' => 'RDF 1.0',
	),
	'rssfeed_creator' => array(
		'label' => 'Creator',
		'note' => 'RDF 1.0',
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
		'label' => 'Enter the full URL to an image that you want to associate with your RSS channels',
	),
);
$gBitSmarty->assign( "formRSSSettings",$formRSSSettings );

$processForm = set_tab();

if( $processForm ) {
	

	// save package specific RSS feed settings
	foreach( array_keys( $formRSSFeeds ) as $item ) {
		simple_set_toggle( $item );
		simple_set_int( 'max_'.$item );
		simple_set_value( 'title_'.$item );
		simple_set_value( 'desc_'.$item );
	}
	
	// deal with the RSS settings
	simple_set_toggle( 'rssfeed_css' );
	foreach( array_keys( $formRSSSettings ) as $item ) {
		simple_set_value( $item );
	}
	simple_set_value( 'rssfeed_default_version' );
}

?>
