<?php
global $gBitInstaller;

$gBitInstaller->registerPackageInfo( RSS_PKG_NAME, array(
	'description' => "Resource Description Framework (RDF) Site Summary (RSS) is a lightweight multipurpose extensible metadata description and syndication format. It allows users to read healines from your site with a dedicated RSS reader.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
	'version' => '0.1',
	'state' => 'alpha',
	'dependencies' => '',
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( RSS_PKG_NAME, array(
	array( RSS_PKG_NAME, 'rss_wiki', 'y'),
	array( RSS_PKG_NAME, 'rss_blogs', 'y'),
) );
?>
