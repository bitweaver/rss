<?php
global $gBitInstaller;

$tables = array(
	'rss_modules' => "
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

	'rss_feeds' => "
		name C(30) NOTNULL,
		rss_ver C(1) NOTNULL DEFAULT '1',
		refresh I4 DEFAULT '300',
		last_updated I8,
		rss_cache B
	"
);

foreach( array_keys( $tables ) AS $tableName ) {
	$gBitInstaller->registerSchemaTable( RSS_PKG_NAME, $tableName, $tables[$tableName] );
}

$gBitInstaller->registerPackageInfo( RSS_PKG_NAME, array(
	'description' => "Resource Description Framework (RDF) Site Summary (RSS) is a lightweight multipurpose extensible metadata description and syndication format. It allows users to read healines from your site with a dedicated RSS reader.",
	'license' => '<a href="http://www.gnu.org/licenses/licenses.html#LGPL">LGPL</a>',
) );

// ### Default Preferences
// every package inserts it's own rss preference
?>
