<?php
  require_once( '../bit_setup_inc.php' );
  require_once( KERNEL_PKG_PATH.'BitBase.php' );

if ($rss_forum != 'y') {
        $errmsg=tra("rss feed disabled");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if(!$gBitUser->hasPermission( 'bit_p_admin_forum' ) && !$gBitUser->hasPermission( 'bit_p_forum_read' )) {
        $errmsg=tra("Permission denied you cannot view this section");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

if(!isset($_REQUEST["forum_id"])) {
        $errmsg=tra("No forum_id specified");
        require_once( RSS_PKG_PATH.'rss_error.php' );
}

$tmp = $gBitSystem->get_forum($_REQUEST["forum_id"]);
$title = "Tiki RSS feed for forum: ".$tmp["name"]; // TODO: make configurable
$desc = $tmp["description"]; // TODO: make configurable
$now = date("U");
$id = "forum_id";
$desc_id = "data";
$dateId = "comment_date";
$titleId = "title";
$readrepl = "tiki-view_forum_thread.php";

require( RSS_PKG_PATH.'rss_read_cache.php' );

if ($output == "EMPTY") {
  $changes = $gBitSystem->list_forum_topics($_REQUEST["$id"],0, $max_rss_forum, $dateId.'_desc', '');
  $output = "";
}

require( RSS_PKG_URL.'rss.php' );

?>
