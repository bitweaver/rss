<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/rss_read_cache.php,v 1.4 2005/08/24 20:57:29 squareing Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: rss_read_cache.php,v 1.4 2005/08/24 20:57:29 squareing Exp $
 * @package rss
 * @subpackage functions
 */

// get default rss feed version from database or set to 1.0 if none in there
$rss_version = $gBitSystem->getPreference("rssfeed_default_version",1);

// override version if set as request parameter
if (isset($_REQUEST["ver"])) {
	if (substr($_REQUEST["ver"],0,1) == '2') {
		$rss_version = 2;
	} else {
		$rss_version = 1;
	}
}

$feed = substr( md5( $_SERVER['REQUEST_URI'] ), 0, 30 );

$query = "select * from `".BIT_DB_PREFIX."tiki_rss_feeds` where `name`=? and `rss_ver`=?";
$bindvars=array($feed, $rss_version);
$result = $gBitSystem->mDb->query($query, $bindvars);

$changes = "";
$output = "EMPTY";

if (!$result->numRows())
{
  // nothing found, then insert row for this feed+rss_ver
  $now = date("U");
  $query = "insert into `".BIT_DB_PREFIX."tiki_rss_feeds`(`name`,`rss_ver`,`refresh`,`last_updated`,`cache`) values(?,?,?,?,?)";

  // default value for cache timeout is 300 (5 minutes)
  $bindvars=array($feed,(int) $rss_version,(int) 300 ,(int) $now, $output);
  $result = $gBitSystem->mDb->query($query, $bindvars);
}
else
{
  // entry found in db:
  $res = $result->fetchRow();
  $output = $res["cache"];
  $refresh = $res["refresh"];
  $last_updated = $res["last_updated"];
  // up to date? if not, then set trigger to reload data:
  if ( TRUE || $last_updated + $refresh < $now) { $output="EMPTY"; } // TODO: make timeout configurable (is 7 minutes now)
}

?>