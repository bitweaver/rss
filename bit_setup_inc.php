<?php
	global $gBitSystem, $gBitSmarty;
	$gBitSystem->registerPackage( 'rss', dirname( __FILE__).'/' );

	if( $gBitSystem->isPackageActive( 'rss' ) ) {
		$gBitSystem->registerAppMenu( 'rss', 'RSS', RSS_PKG_URL.'index.php', '', 'rss' );

		// **********  RSS  ************
		$gBitSmarty->assign("rssfeed_default_version", $gBitSystem->getPreference("rssfeed_default_version", "2"));
		$gBitSmarty->assign("rssfeed_language", $gBitSystem->getPreference("rssfeed_language", "en-us"));
		$gBitSmarty->assign("rssfeed_editor", $gBitSystem->getPreference("rssfeed_editor", ""));
		$gBitSmarty->assign("rssfeed_publisher", $gBitSystem->getPreference("rssfeed_publisher", ""));
		$gBitSmarty->assign("rssfeed_webmaster", $gBitSystem->getPreference("rssfeed_webmaster", ""));
		$gBitSmarty->assign("rssfeed_creator", $gBitSystem->getPreference("rssfeed_creator", ""));

		$gBitSmarty->assign('rss_articles', 'y');
		$gBitSmarty->assign('rss_forum', 'y');
		$gBitSmarty->assign('rss_forums', 'y');
		$gBitSmarty->assign('rss_blogs', 'y');
		$gBitSmarty->assign('rss_image_galleries', 'n');
		$gBitSmarty->assign('rss_file_galleries', 'n');
		$gBitSmarty->assign('rss_wiki', 'y');
		$gBitSmarty->assign('rss_image_gallery', 'y');
		$gBitSmarty->assign('rss_file_gallery', 'y');
		$gBitSmarty->assign('rss_blog', 'n');

		$gBitSmarty->assign('max_rss_articles', 10);
		$gBitSmarty->assign('max_rss_blogs', 10);
		$gBitSmarty->assign('max_rss_image_galleries', 10);
		$gBitSmarty->assign('max_rss_file_galleries', 10);
		$gBitSmarty->assign('max_rss_wiki', 10);
		$gBitSmarty->assign('max_rss_image_gallery', 10);
		$gBitSmarty->assign('max_rss_file_gallery', 10);
		$gBitSmarty->assign('max_rss_blog', 10);

		$gBitSmarty->assign("rssfeed_cssparam", "&amp;css=y");
		if ($gBitSystem->getPreference("rssfeed_css", "y") <> "y")
		{
			$gBitSmarty->assign("rssfeed_cssparam", "");
		}
	}
?>
