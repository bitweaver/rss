<?php
global $gBitSystem, $gBitSmarty;

$registerHash = array(
	'package_name' => 'rss',
	'package_path' => dirname( __FILE__ ).'/',
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'rss' ) ) {
	$gBitSystem->registerAppMenu( RSS_PKG_NAME, 'RSS', RSS_PKG_URL.'index.php', 'bitpackage:rss/menu_rss.tpl', 'rss' );
}
?>
