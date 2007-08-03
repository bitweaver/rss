<?php
/**
 * @package rss
 * @subpackage modules
 */

/**
 * required setup
 */
global $rsslib;
require_once( RSS_PKG_PATH.'rss_lib.php' );

extract( $moduleParams );

$listHash = Array();
$listHash['id'] = $module_params['id'];
$listHash['cache_time'] = !empty($cache_time)?$cache_time:1;

if ( $items = $rsslib->parse_feeds( $listHash ) ){
	$gBitSmarty->assign( 'modRSSItems', $items );	

	//if we want short descriptions get them
	$shortdescs = Array();	
	if ( !empty($module_params['desc_length']) && is_numeric($module_params['desc_length']) && !empty($items)){
		$shortdescs = $rsslib->get_short_descs( $items, $module_params['desc_length'] );
	}
	
	$gBitSmarty->assign( 'short_desc', $shortdescs );	
	
	//if desc is set and no desc_length is given then we present the full description/content of each item
	$hideDesc = TRUE;
	if (!empty($module_params['desc']) && $module_params['desc'] == 'y' && empty($module_params['desc_length']) ){
		$hideDesc = FALSE;
	}
	
	$gBitSmarty->assign( 'hideDesc', $hideDesc );
	
	$max = !empty( $module_params['max'] ) ? $module_params['max'] : 99;
	$gBitSmarty->assign( 'max', $max );
}
?>
