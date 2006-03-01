<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_rss/rss_error.php,v 1.8 2006/03/01 20:16:24 spiderr Exp $
 * @package rss
 * @subpackage functions
 *
 * display an error message when there's something wrong.
 * default $message is:
 * "You don't have permission to view this syndication feed."
 */

// check permission to view the feed
$rss->title = $gBitSystem->getConfig( 'title_rss_wiki', $gBitSystem->getConfig( 'site_title' ) );
$rss->description = $gBitSystem->getConfig( 'desc_rss_wiki', $gBitSystem->getConfig( 'site_title' ).' - '.tra( 'RSS Feed' ) );

$item = new FeedItem();
$item->title = tra( 'Syndication Problem' );
$item->link = 'http://'.$_SERVER['HTTP_HOST'].BIT_ROOT_URL;
$item->description = !empty( $message ) ? $message : tra( "You don't have permission to view this syndication feed." );

$item->source = 'http://'.$_SERVER['HTTP_HOST'].BIT_ROOT_URL;
$item->author = $gBitUser->getPreference( 'site_title' );

$item->descriptionTruncSize = $gBitSystem->getConfig( 'rssfeed_truncate', 500 );
$item->descriptionHtmlSyndicated = FALSE;

// pass the item on to the rss feed creator
$rss->addItem( $item );

// display the error msg
echo $rss->saveFeed( $rss_version_name, TEMP_PKG_PATH.'rss/error.xml' );
die;
?>
