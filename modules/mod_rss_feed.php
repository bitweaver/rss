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

	$_template->tpl_vars['modRSSItems'] = new Smarty_variable( $items );	

	//if we want short descriptions get them
	$shortdescs = Array();	
	if ( !empty($module_params['desc_length']) && is_numeric($module_params['desc_length']) && !empty($items)){
		$shortdescs = $rsslib->get_short_descs( $items, $module_params['desc_length'] );
	}

	$_template->tpl_vars['short_desc'] = new Smarty_variable( $shortdescs );	
	
	//if desc is set and no desc_length is given then we present the full description/content of each item
	$hideDesc = TRUE;
	if (!empty($module_params['desc']) && empty($module_params['desc_length']) ){
		$hideDesc = FALSE;
	}
	
	$_template->tpl_vars['hideDesc'] = new Smarty_variable( $hideDesc );
	
	$max = !empty( $module_params['max'] ) ? $module_params['max'] : 10;
	$_template->tpl_vars['max'] = new Smarty_variable( $max );
}
?>
