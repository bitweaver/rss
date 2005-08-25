<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/rss.php,v 1.1.1.1.2.9 2005/08/25 21:31:44 lsces Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: rss.php,v 1.1.1.1.2.9 2005/08/25 21:31:44 lsces Exp $
 * @package rss
 * @subpackage functions
 */

$tikiId =	"bitweaver www.bitweaver.org";
$rsslang = $gBitSystem->getPreference("rssfeed_language","en-us");
$rsseditor = $gBitSystem->getPreference("rssfeed_editor","");
$rsspublisher = $gBitSystem->getPreference("rssfeed_publisher","");
$rsswebmaster = $gBitSystem->getPreference("rssfeed_webmaster","");
$rsscreator = $gBitSystem->getPreference("rssfeed_creator","");

$rsscategorydomain = ""; // TODO: make configurable, currently unused
$rsscategory = ""; // TODO: make configurable, currently unused

$rss_use_css = false; // default is: do not use css
if (isset($_REQUEST["css"])) {
	$rss_use_css = true;
}
// date format for RDF 2.0
$datenow = htmlspecialchars(gmdate('D, d M Y H:i:s T', $gBitSystem->getUTCTime()));
if ($rss_version < 2) {
	// date format for RDF 1.0
	$datenow = htmlspecialchars($gBitSystem->iso_8601($gBitSystem->getUTCTime()));
}

$url = $_SERVER["REQUEST_URI"];
$url = substr($url, 0, strpos($url."?", "?")); // strip all parameters from url
$urlarray = parse_url($url);

$pagename = substr($urlarray["path"], strrpos($urlarray["path"], '/') + 1);

$home = htmlspecialchars(httpPrefix().'/'.$gBitSystem->getPreference( 'bitIndex' ) );
$img = htmlspecialchars($gBitSystem->getPreference('rssfeed_image_url',httpPrefix().str_replace($pagename, "img/tiki.jpg", $urlarray["path"])));

$url = htmlspecialchars(httpPrefix().$url);
$title = htmlspecialchars($title);
$desc = htmlspecialchars($desc);
$url = htmlspecialchars($url);
$css = htmlspecialchars(httpPrefix().str_replace($pagename, "rss_style.css", $urlarray["path"]));

// --- output starts here
header("content-type: text/xml");

print '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
print '<!--	RSS generated by bitweaver CMS (bitweaver.org) on '.$datenow.' -->'."\n";

if ($rss_use_css) {
	print '<?xml-stylesheet href="'.$css.'" type="text/css"?>'."\n";
}

if (!isset($output)) {
	$output="";
}

if ($output == "") {
	if ($rss_version > 1) {
		$output .= '<rss version="2.0">'."\n";
		$output .= "<channel>\n";
	} else {
		$output .= '<rdf:RDF xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:h="http://www.w3.org/1999/xhtml" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/">'."\n";
		$output .= '<channel rdf:about="'.$url.'">'."\n";
	}

	$output .= "<title>".$title."</title>\n";
	$output .= "<link>".$home."</link>\n";
	$output .= "<description>".$desc."</description>\n";

	if ($rss_version < 2) {
		$output .= "<dc:language>".$rsslang."</dc:language>\n";
		$output .= "<dc:date>".$datenow."</dc:date>\n";
		if ($rsspublisher <> "") $output .= "<dc:publisher>".$rsspublisher."</dc:publisher>\n";
		if ($rsscreator <> "") $output .= "<dc:creator>".$rsscreator."</dc:creator>\n";
	} else {
		$output .= "<language>".$rsslang."</language>\n";
		$output .= "<docs>http://backend.userland.com/rss</docs>\n";
		$output .= "<pubDate>".$datenow."</pubDate>\n";
		$output .= "<generator>".$tikiId."</generator>\n";
		// $output .= "<category domain=\"".$rsscategorydomain."\">".$rsscategory."</category>\n";
		if ($rsseditor <> "")	$output .= "<managingEditor>".$rsseditor."</managingEditor>\n";
		if ($rsswebmaster <> "")	$output .= "<webMaster>".$rsswebmaster."</webMaster>\n";
	}

	$output .= "\n";

	if ($rss_version < 2) {
		$output .= "<items>\n";
		$output .= "<rdf:Seq>\n";
		// LOOP collecting last changes (index)
		foreach ($changes["data"] as $chg) {
			if ($id == "blog_id") {
			$resource .= "&post_id=".$chg["post_id"];
		} elseif ($id == "forum_id") {
			$resource .= "&comments_parent_id=".$chg["thread_id"];
		} elseif( !empty( $chg['display_url'] ) ) {
			$resource=$read = httpPrefix().$chg['display_url'];
		} else {
			$resource=$read = httpPrefix().$readrepl.$chg["$id"];
		}
			$resource = htmlspecialchars($resource);
			$output .= '				<rdf:li rdf:resource="'.$resource.'" />'."\n";
		}
		$output .= "</rdf:Seq>\n";
		$output .= "</items>\n";
		if ($rss_version < 2) {
			$output .= '<image rdf:resource="'.$img.'" />'."\n";
		}
		$output .= "</channel>\n\n";
	}

	if ($rss_version < 2) {
		$output .= '<image rdf:about="'.$img.'">'."\n";
	} else {
		$output .= '<image>'."\n";
	}
	$output .= "<title>".$title."</title>\n";
	$output .= "<link>".$home."</link>\n";
	$output .= "<url>".$img."</url>\n";
	$output .= "</image>\n\n";

	// LOOP collecting last changes to image galleries
	foreach ($changes["data"] as $chg) {
		$date = htmlspecialchars(gmdate('D, d M Y H:i:s T', $chg["$dateId"]));
		if ($rss_version < 2) {
			$date = htmlspecialchars($gBitSystem->iso_8601($chg["$dateId"]));
		}
		$about = $chg['display_url'];
		// forums have threads, add those to the url:
		if ($id == "forum_id") { $resource .= "&comments_parent_id=".$chg["thread_id"]; }
		$about = htmlspecialchars($about);

		$title = $chg['title'];
		// titles for blogs are dates, so make them readable:
//		if ($titleId == "created") { $title = htmlspecialchars(gmdate('D, d M Y H:i:s T', $title)); }
		$description = htmlspecialchars($chg["$desc_id"]);

		if ($rss_version < 2) {
			$output .= '<item rdf:about="'.$about.'">'."\n";
		} else {
			$output .= "<item>\n";
		}
		$output .= '	<title>'.$title.'</title>'."\n";
		$output .= '	<link>'.$about.'</link>'."\n";

		if ($rss_version < 2) {
			$output .= '	<description>'.$description.'</description>'."\n";
			$output .= "	<dc:date>".$date."</dc:date>\n";
		} else {
			$output .= '<description>'.$description.'</description>'."\n";
			// $output .= "<author>".htmlspecialchars($chg["user"])."</author>\n"; // TODO: email address of author
			$output .= '<guid isPermaLink="true">'.$about.'</guid>'."\n";
			$output .= "<pubDate>".$date."</pubDate>\n";
		}
		$output .= '</item>'."\n\n";
	}

	if ($rss_version < 2) {
		$output .= "</rdf:RDF>\n";
	} else {
		$output .= "</channel>\n";
		$output .= "</rss>\n";
	}

$feed = substr( md5( $_SERVER['REQUEST_URI'] ), 0, 30 );

	// update cache with new generated data
	$now = date("U");
	$query = "update `".BIT_DB_PREFIX."tiki_rss_feeds` set `cache`=?, `last_updated`=? where `name`=? and `rss_ver`=?";
	$bindvars = array( BitDb::db_byte_encode( $output ), (int) $now, $feed, $rss_version);
	$result = $gBitSystem->mDb->query($query,$bindvars);
}

print $output;

?>