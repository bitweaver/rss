<?php

global $gBitSystem, $gUpgradeFrom, $gUpgradeTo;

$upgrades = array(

'BONNIE' => array( 
	'CLYDE' => array(
// STEP 1
array( 'DATADICT' => array( 
array( 'RENAMECOLUMN' => array( 
	'tiki_rss_modules' => array(	'`rssId`' => '`rss_id` I4 AUTO',
								'`lastUpdated`' => '`last_updated` I8',
								'`showPubDate`' => '`show_pub_date` I8',
								'`showTitle`' => '`show_title` C(1)' ),
	'tiki_rss_feeds' => array(	'`rssVer`' => '`rss_ver` C(1)',
							'`lastUpdated`' => '`last_updated` I8'),
)),
))

	)
)

);

if( isset( $upgrades[$gUpgradeFrom][$gUpgradeTo] ) ) {
	$gBitSystem->registerUpgrade( RSS_PKG_NAME, $upgrades[$gUpgradeFrom][$gUpgradeTo] );
}


?>
