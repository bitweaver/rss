<?php
	global $gBitSystem, $gBitSmarty;
	$gBitSystem->registerPackage( 'rss', dirname( __FILE__).'/' );

	if( $gBitSystem->isPackageActive( 'rss' ) ) {
		$gBitSystem->registerAppMenu( RSS_PKG_NAME, 'RSS', RSS_PKG_URL.'index.php', 'bitpackage:rss/menu_rss.tpl', 'rss' );
	}
?>
