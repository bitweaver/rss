<?php
/**
 * @version $Header: /cvsroot/bitweaver/_bit_rss/rss_inc.php,v 1.12 2007/07/08 07:56:40 squareing Exp $
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

$rss->copyright                 = $gBitSystem->getConfig( 'rssfeed_copyright' );
$rss->editor                    = $gBitSystem->getConfig( 'rssfeed_editor' );
$rss->webmaster                 = $gBitSystem->getConfig( 'rssfeed_webmaster' );
$rss->language                  = $gBitSystem->getConfig( 'rssfeed_language', 'en-us' );
$rss->cssStyleSheet             = $gBitSystem->getConfig( 'rssfeed_css_url' );
$rss->descriptionTruncSize      = $gBitSystem->getConfig( 'rssfeed_truncate', 500 );
$rss->descriptionHtmlSyndicated = TRUE;

$rss->link = BIT_BASE_URI.BIT_ROOT_URL;
$rss->syndicationURL = BIT_BASE_URI.BIT_ROOT_URL.'/'.$_SERVER['PHP_SELF'];

// feed image
if( $gBitSystem->isFeatureActive( 'rssfeed_image_url' ) ) {
	$image->descriptionTruncSize = $gBitSystem->getConfig( 'rssfeed_truncate', 5000 );
	$image->descriptionHtmlSyndicated = true;

	$image = new FeedImage();
	$image->title = $gBitSystem->getConfig( 'site_title' );
	$image->url = $gBitSystem->getConfig( 'rssfeed_image_url' );
	$image->link = BIT_BASE_URI.BIT_ROOT_URL;
	$image->description = tra( 'Feed provided by' ).': '.$gBitSystem->getConfig( 'site_title' ).' '.tra( 'Click to visit.' );
	$rss->image = $image;
}

// here we work out what type of feed were going to feed
if( empty( $_REQUEST['version'] ) ) {
	// get default rss feed version from database or set to 0.91 if none in there
	$version = $gBitSystem->getConfig( "rssfeed_default_version", "RSS0.91" );
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

ksort( $gBitUser->mGroups );
$cacheFileTail = 'p'.implode( array_keys( $gBitUser->mGroups ), '.' ).'_'.$rss_version_name.'.xml';
?>
