<?php
global $gBitSystem, $gBitSmarty;

$registerHash = array(
	'package_name' => 'rss',
	'package_path' => dirname( dirname( __FILE__ ) ).'/',
);
$gBitSystem->registerPackage( $registerHash );

if( $gBitSystem->isPackageActive( 'rss' ) ) {
	$menuHash = array(
		'package_name'  => RSS_PKG_NAME,
		'index_url'     => RSS_PKG_URL.'index.php',
		'menu_template' => 'bitpackage:rss/menu_rss.tpl',
	);
	$gBitSystem->registerAppMenu( $menuHash );
}
?>
