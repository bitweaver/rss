<?php

$tables = array(

'tiki_rss_modules' => "
  rss_id I4 AUTO PRIMARY,
  name C(30) NOTNULL,
  description X,
  url C(255) NOTNULL,
  refresh I4,
  last_updated I8,
  show_title C(1) DEFAULT 'n',
  show_pub_date C(1) DEFAULT 'n',
  content X
",

'tiki_rss_feeds' => "
  name C(30) NOTNULL,
  rss_ver C(1) NOTNULL DEFAULT '1',
  refresh I4 DEFAULT '300',
  last_updated I8,
  cache B
"

);

global $gBitInstaller;

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( RSS_PKG_DIR, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( RSS_PKG_NAME, array(
	'description' => "Resource Description Framework (RDF) Site Summary (RSS) is a lightweight multipurpose extensible metadata description and syndication format. It allows users to read healines from your site with a dedicated RSS reader.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
	'version' => '0.1',
	'state' => 'alpha',
	'dependencies' => '',
) );

// ### Default MenuOptions
$gBitInstaller->registerMenuOptions( RSS_PKG_NAME, array(
	array(42,'o','RSS modules','tiki-admin_rssmodules.php',1100,'','bit_p_admin','')
) );

// ### Default Preferences
$gBitInstaller->registerPreferences( RSS_PKG_NAME, array(
	array( RSS_PKG_NAME, 'rssfeed_css','y'),
	array( RSS_PKG_NAME, 'rssfeed_default_version','2'),
	array( RSS_PKG_NAME, 'rssfeed_language','en-us'),
	array( RSS_PKG_NAME, 'rss_wiki','y'),
	array( RSS_PKG_NAME, 'rss_blogs','y'),
) );

?>
