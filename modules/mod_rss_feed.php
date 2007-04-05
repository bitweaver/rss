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

// moduleParams contains lots of goodies: extract for easier handling
extract( $moduleParams );

if( @BitBase::verifyId( $module_params['id'] ) ) {
	$max = !empty( $module_params['max'] ) ? $module_params['max'] : 99;

	$rssdata = $rsslib->get_rss_module_content( $module_params['id'] );
	$items = $rsslib->parse_rss_data( $rssdata, $module_params['id'] );
	
	$gBitSmarty->assign( 'modRSSItems', $items );	
	if (!empty($module_params['desc']) && $module_params['desc'] == 'n'){
		$gBitSmarty->assign( 'hideDesc', TRUE );
	}
}else{
	//todo assign this as an error
	//$repl = '<b>rss can not be found, id must be a number</b>';
}
?>
