<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/index.php,v 1.7 2008/06/25 22:21:22 spiderr Exp $
 *
 * Copyright ( c ) 2004 bitweaver.org
 * Copyright ( c ) 2003 tikwiki.org
 * Copyright ( c ) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: index.php,v 1.7 2008/06/25 22:21:22 spiderr Exp $
 * @package pigeonholes
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );

$gBitSystem->verifyPackage( 'rss' );

foreach( $gBitSystem->mPackages as $pkg => $pkgInfo ) {
	// Install may be chmod 000 if user followed directions
	if( $pkg != 'install' && is_file( $pkgInfo['path'].$pkg.'_rss.php' ) && $gBitSystem->isFeatureActive( $pkg."_rss" ) ) {
		$pkgs[$pkg] = ( $gBitSystem->isFeatureActive( $pkg."_rss_title" ) ? $gBitSystem->getConfig( $pkg."_rss_title" ) : $pkg );
	}
}
$gBitSmarty->assign( "pkgs", $pkgs );

$feedFormat = array(
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
$gBitSmarty->assign( "feedFormat", $feedFormat );

if( !empty( $_REQUEST['get_feed'] ) ) {
	$feedlink['url'] = constant( strtoupper( $_REQUEST['pkg'] ).'_PKG_URL' ).$_REQUEST['pkg'].'_rss.php?version='.$_REQUEST['format'];
	$feedlink['title'] = $_REQUEST['pkg'].' - '.$feedFormat[$_REQUEST['format']];
	$feedlink['pkg'] = $_REQUEST['pkg'];
	$feedlink['format'] = $_REQUEST['format'];
} else {
	$feedlink['format'] = $gBitSystem->getConfig( 'rssfeed_default_version' );
}
$gBitSmarty->assign( 'feedlink', $feedlink );

$gBitSystem->display( 'bitpackage:rss/rss.tpl', tra( 'Select Feed' ) , array( 'display_mode' => 'display' ));
?>
