<?php
	global $gBitSystem, $smarty;
	$gBitSystem->registerPackage( 'rss', dirname( __FILE__).'/' );

	if( $gBitSystem->isPackageActive( 'rss' ) ) {
		$gBitSystem->registerAppMenu( 'rss', 'RSS', RSS_PKG_URL.'index.php', '', 'rss' );

		// **********  RSS  ************
		$smarty->assign("rssfeed_default_version", $gBitSystem->getPreference("rssfeed_default_version", "2"));
		$smarty->assign("rssfeed_language", $gBitSystem->getPreference("rssfeed_language", "en-us"));
		$smarty->assign("rssfeed_editor", $gBitSystem->getPreference("rssfeed_editor", ""));
		$smarty->assign("rssfeed_publisher", $gBitSystem->getPreference("rssfeed_publisher", ""));
		$smarty->assign("rssfeed_webmaster", $gBitSystem->getPreference("rssfeed_webmaster", ""));
		$smarty->assign("rssfeed_creator", $gBitSystem->getPreference("rssfeed_creator", ""));

		$smarty->assign('rss_articles', 'y');
		$smarty->assign('rss_forum', 'y');
		$smarty->assign('rss_forums', 'y');
		$smarty->assign('rss_blogs', 'y');
		$smarty->assign('rss_image_galleries', 'n');
		$smarty->assign('rss_file_galleries', 'n');
		$smarty->assign('rss_wiki', 'y');
		$smarty->assign('rss_image_gallery', 'y');
		$smarty->assign('rss_file_gallery', 'y');
		$smarty->assign('rss_blog', 'n');

		$smarty->assign('max_rss_articles', 10);
		$smarty->assign('max_rss_blogs', 10);
		$smarty->assign('max_rss_image_galleries', 10);
		$smarty->assign('max_rss_file_galleries', 10);
		$smarty->assign('max_rss_wiki', 10);
		$smarty->assign('max_rss_image_gallery', 10);
		$smarty->assign('max_rss_file_gallery', 10);
		$smarty->assign('max_rss_blog', 10);

		$smarty->assign("rssfeed_cssparam", "&amp;css=y");
		if ($gBitSystem->getPreference("rssfeed_css", "y") <> "y")
		{
			$smarty->assign("rssfeed_cssparam", "");
		}
	}
?>
