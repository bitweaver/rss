<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_rss/rss_inc.php,v 1.1.2.4 2005/11/04 20:01:47 spiderr Exp $
 * @package rss
 * @subpackage functions
 */

/**
 * Initialization
 */
require_once( RSS_PKG_PATH."feedcreator.class.php" );

// make sure the feeds cache dir is available
if( !is_dir( TEMP_PKG_PATH.'rss' ) ) {
	mkdir_p( TEMP_PKG_PATH.'rss' );
}

// initiate feed creator class
$rss = new UniversalFeedCreator();

$rss->copyright   = $gBitSystem->getPreference( 'rssfeed_copyright' );
$rss->editor      = $gBitSystem->getPreference( 'rssfeed_editor' );
$rss->webmaster   = $gBitSystem->getPreference( 'rssfeed_webmaster' );
$rss->language    = $gBitSystem->getPreference( 'rssfeed_language', 'en-us' );
$rss->descriptionTruncSize = $gBitSystem->getPreference( 'rssfeed_truncate', 500 );
$rss->descriptionHtmlSyndicated = true;

$rss->link = 'http://'.$_SERVER['HTTP_HOST'].BIT_ROOT_URL;
$rss->syndicationURL = 'http://'.$_SERVER['HTTP_HOST'].BIT_ROOT_URL.'/'.$_SERVER['PHP_SELF'];

// feed image
if( !empty( $gBitSystem->mPrefs['rssfeed_image_url'] ) ) {
	$image->descriptionTruncSize = $gBitSystem->getPreference( 'rssfeed_truncate', 500 );
	$image->descriptionHtmlSyndicated = true;

	$image = new FeedImage();
	$image->title = $gBitSystem->mPrefs['siteTitle'];
	$image->url = $gBitSystem->mPrefs['rssfeed_image_url'];
	$image->link = 'http://'.$_SERVER['HTTP_HOST'].BIT_ROOT_URL;
	$image->description = tra( 'Feed provided by' ).': '.$gBitSystem->mPrefs['siteTitle'].' '.tra( 'Click to visit.' );
	$rss->image = $image;
}

// here we work out what type of feed were going to feed
if( empty( $_REQUEST['version'] ) ) {
	// get default rss feed version from database or set to 0.91 if none in there
	$version = $gBitSystem->getPreference( "rssfeed_default_version", "RSS0.91" );
} else {
	$version = $_REQUEST['version'];
}

$rss_version_name = $version;
switch( $version ) {
	case "0":
	case "rss091":
	   $rss_version_name = "RSS0.91";
	   break;
	case "1":
	case "rss10":
	   $rss_version_name = "RSS1.0";
	   break;
	case "2":
	case "rss20":
	   $rss_version_name = "RSS2.0";
	   break;
	case "3":
	case "pie01":
	   $rss_version_name = "PIE0.1";
	   break;
	case "4":
	case "mbox":
	   $rss_version_name = "MBOX";
	   break;
	case "5":
	case "atom":
	   $rss_version_name = "ATOM";
	   break;
	case "6":
	case "atom03":
	   $rss_version_name = "ATOM0.3";
	   break;
	case "7":
	case "opml":
	   $rss_version_name = "OPML";
	   break;
	case "8":
	case "html":
	   $rss_version_name = "HTML";
	   break;
	case "9":
	case "js":
	   $rss_version_name = "JS";
	   break;
}
?>
