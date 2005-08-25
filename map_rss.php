<?php
/**
 * $Header: /cvsroot/bitweaver/_bit_rss/Attic/map_rss.php,v 1.1.1.1.2.2 2005/08/25 21:31:44 lsces Exp $
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See copyright.txt for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details
 *
 * $Id: map_rss.php,v 1.1.1.1.2.2 2005/08/25 21:31:44 lsces Exp $
 * @package rss
 * @subpackage functions
 */

/**
 * required setup
 */
require_once( '../bit_setup_inc.php' );
require_once( KERNEL_PKG_PATH.'BitBase.php' );

if ($rss_mapfiles != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if(!$gBitUser->hasPermission( 'bit_p_map_view' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$title = "Tiki RSS feed for maps"; // TODO: make configurable
$desc = "List of maps available."; // TODO: make configurable
$now = $gBitSystem->getUTCTime();
$id = "name";
$titleId = "name";
$desc_id = "description";
$dateId = "last_modified";
$readrepl = "tiki-map.phtml?mapfile=";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  // Get mapfiles from the mapfiles directory
  $tmp = array();
  $h = opendir($map_path);

  while (($file = readdir($h)) !== false)
  {
  	if (preg_match('/\.map$/i', $file))
  	{
  		$filetlist[$file] = filemtime ($map_path."/".$file);
  	}
  }
  arsort($filetlist, SORT_NUMERIC);

  $aux = array();
  $i=0;
  while (list ($key, $val) = each ($filetlist))
  {
    if ($i >= $max_rss_mapfiles) break;
    $i++;
  	$aux["name"] = $key;
  	$aux["last_modified"] = $val;
  	$aux["description"] = "";
  	$tmp[] = $aux;
  }

  closedir ($h);
  $changes = array();
  $changes["data"] = $tmp;
  $output = "";
}

require( RSS_PKG_URL.'rss.php' );

?>
