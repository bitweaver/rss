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



/*
//load up SimplePie
require_once( UTIL_PKG_PATH.'simplepie/simplepie.inc' );

//set path to rss feed cache
$cache_path = TEMP_PKG_PATH.'rss/simplepie';

//we do this earlier instead of later because if we can't cache the source we shouldn't be pulling the rss feed.
if( !is_dir( $cache_path ) && !mkdir_p( $cache_path ) ) {
	bit_log_error( 'Can not create the cache directory: '.$cache_path );
}else{
	// moduleParams contains lots of goodies: extract for easier handling
	extract( $moduleParams );
	
	if (!is_array($module_params['id'])){
		$ids = explode( ",", $module_params['id'] );
	}else{
		$ids = $module_params['id'];
	}
	
	$urls = Array();
	
	foreach ($ids as $id){
		if( @BitBase::verifyId( $id ) ) {
			$feedHash = $rsslib->get_rss_module( $id );
			$urls[] = $feedHash['url'];
		}else{
			//todo assign this as an error
			//$repl = '<b>rss can not be found, id must be a number</b>';
		}
	}
	
	$feed = new SimplePie();
	 
	//Instead of only passing in one feed url, we'll pass in an array of multiple feeds
	$feed->set_feed_url( $urls );
	
	$feed->set_cache_location( $cache_path );
	
	//modules may not be cached so for now we relay the cache time to simplepie
	$cache_time = !empty($cache_time)?$cache_time:1;
	$feed->set_cache_duration( $cache_time );
	
	//not sure - we may want to eventually use this
	//$feed->set_stupidly_fast(TRUE);
	 
	// Initialize the feed object
	$feed->init();
	 
	// This will work if all of the feeds accept the same settings.
	$feed->handle_content_type();
	
	$items = $feed->get_items();

	$gBitSmarty->assign( 'modRSSItems', $items );	
	
	$shortdescs = Array();
	
	if ( !empty($module_params['desc_length']) && is_numeric($module_params['desc_length']) && !empty($items)){
		foreach ($items as $item){
			//we try to trim each story to given number of sentences
			$sentences = $rsslib->get_short_desc( $item->get_description() );
			
			$shortdesc = NULL;
			for ($n = 0; $n < $module_params['desc_length']; $n++){
				$space = ($n > 0)?" ":NULL;
				$shortdesc .= $space;
				$shortdesc .= ( !empty( $sentences[$n] ) && $sentences[$n] != NULL ) ? $sentences[$n] : NULL;
			}
			
			$shortdescs[] = $shortdesc;
		}
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
*/
?>
