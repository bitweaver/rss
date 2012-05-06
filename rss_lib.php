<?php
/**
 * @version $Header$
 * @package rss
 *
 * Copyright (c) 2004 bitweaver.org
 * Copyright (c) 2003 tikwiki.org
 * Copyright (c) 2002-2003, Luis Argerich, Garland Foster, Eduardo Polidor, et. al.
 * All Rights Reserved. See below for details and a complete list of authors.
 * Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See http://www.gnu.org/copyleft/lesser.html for details
 *
 * $Id$
 */

/**
 * @package rss
 */
class RSSLib extends BitBase {

	function list_rss_modules($offset, $max_records, $sort_mode, $find) {

		if ($find) {
			$findesc="%" . $find . "%";
			$mid = " where (`name` like ? or `description` like ?)";
			$bindvars=array($findesc,$findesc);
		} else {
			$mid = "";
			$bindvars=array();
		}

		$query = "select * from `".BIT_DB_PREFIX."rss_modules` $mid order by ".$this->mDb->convertSortmode($sort_mode);
		$query_cant = "select count(*) from `".BIT_DB_PREFIX."rss_modules` $mid";
		$result = $this->mDb->query($query,$bindvars,$max_records,$offset);
		$cant = $this->mDb->getOne($query_cant,$bindvars);
		$ret = array();

		while ($res = $result->fetchRow()) {
			$res["minutes"] = $res["refresh"] / 60;

			$ret[] = $res;
		}

		$retval = array();
		$retval["data"] = $ret;
		$retval["cant"] = $cant;
		return $retval;
	}

	function replace_rss_module($rss_id, $name, $description, $url, $refresh, $show_title, $show_pub_date) {
		$ret = FALSE;
		if( is_numeric( $rss_id ) ) {
			//if($this->rss_module_name_exists($name)) return false; // TODO: Check the name
			$refresh = 60 * $refresh;
	
			if ($rss_id) {
				$query = "update `".BIT_DB_PREFIX."rss_modules` set `name`=?,`description`=?,`refresh`=?,`url`=?,`show_title`=?,`show_pub_date`=? where `rss_id`=?";
				$bindvars=array($name,$description,$refresh,$url,$show_title,$show_pub_date,$rss_id);
			} else {
				// was: replace into, no clue why.
				$query = "insert into `".BIT_DB_PREFIX."rss_modules`(`name`,`description`,`url`,`refresh`,`content`,`last_updated`,`show_title`,`show_pub_date`)
					values(?,?,?,?,?,?,?,?)";
				$bindvars=array($name,$description,$url,$refresh,'',1000000,$show_title,$show_pub_date);
			}
	
			$result = $this->mDb->query($query,$bindvars);
			$ret = true;
		}
		return $ret;
	}

	function remove_rss_module($rss_id) {
		$ret = FALSE;
		if( is_numeric( $rss_id ) ) {
			$query = "delete from `".BIT_DB_PREFIX."rss_modules` where `rss_id`=?";
	
			$result = $this->mDb->query($query,array($rss_id));
			$ret = true;
		}
		return $ret;
	}

	function get_rss_module($rss_id) {
		$ret = FALSE;
		if( is_numeric( $rss_id ) ) {
			$query = "select * from `".BIT_DB_PREFIX."rss_modules` where `rss_id`=?";
	
			$result = $this->mDb->query($query,array($rss_id));
	
			if (!$result->numRows())
				return false;
	
			$ret = $result->fetchRow();
		}
		return $ret;
	}

	function startElementHandler($parser, $name, $attribs) {
		if ($this->flag) {
			$this->buffer .= '<' . $name . '>';
		}

		if ($name == 'item' || $name == 'items') {
			$this->flag = 1;
		}
	}

	function endElementHandler($parser, $name) {
		if ($name == 'item' || $name == 'items') {
			$this->flag = 0;
		}

		if ($this->flag) {
			$this->buffer .= '</' . $name . '>';
		}
	}

	function characterDataHandler($parser, $data) {
		if ($this->flag) {
			$this->buffer .= $data;
		}
	}

	/* DEPRECATED - SLATED FOR REMOVAL
	 * We now get content from SimplePie parser via parse_feeds below
	 * -wjames5
	 */
	/*
	function NewsFeed($data, $rss_id) {
		$news = array();
		if( is_numeric( $rss_id ) ) {
	
			$show_pub_date = $this->get_rss_show_pub_date($rss_id);
	
			$this->buffer = '';
			$this->flag = 0;
			$this->parser = xml_parser_create("UTF-8");
			xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
			xml_set_object($this->parser, $this);
			xml_set_element_handler($this->parser, "startElementHandler", "endElementHandler");
			xml_set_character_data_handler($this->parser, "characterDataHandler");
	
			if (!xml_parse($this->parser, $data, 1)) {
#				print ("<!-- XML Parse error at " . xml_get_current_line_number($this->parser) . ":  "
#				       . xml_error_string(xml_get_error_code($this->parser)) . " -->\n");
				$news[] = array('title'=>
					"XML Parse error at " . xml_get_current_line_number($this->parser) . ":  "
				    . xml_error_string(xml_get_error_code($this->parser)) . "",
				    'link'=>'',
				    'pubdate'=>'',
				    );
				return $news;
			}
	
			xml_parser_free ($this->parser);
			preg_match_all("/<title>(.*?)<\/title>/i", $this->buffer, $titles);
			preg_match_all("/<author>(.*?)<\/author>/i", $this->buffer, $author);
			preg_match_all("/<link>(.*?)<\/link>/i", $this->buffer, $links);
			preg_match_all("/<description>(.*?)<\/description>/i", $this->buffer, $description);
	
			$pubdate = array();
			preg_match_all("/<dc:date>(.*?)<\/dc:date>/i", $this->buffer, $pubdate);
			if (count($pubdate[1])<1)				
			preg_match_all("/<pubDate>(.*?)<\/pubDate>/i", $this->buffer, $pubdate);
	
			for ($i = 0; $i < count($titles[1]); $i++) {
				$anew["title"] = $titles[1][$i];
				
				if (isset($author[1][$i])) {
					$anew["author"] = $author[1][$i];
				} else {
					$anew["author"] = '';
				}
				if (isset($description[1][$i])) {
					$anew["description"] = $description[1][$i];
				}else{
					$anew["description"] = '';
				}
				if (isset($links[1][$i])) {
					$anew["link"] = $links[1][$i];
				} else {
					$anew["link"] = '';
				}
				if ( isset($pubdate[1][$i]) && ($show_pub_date == 'y') )
				{
					$anew["pubdate"] = $pubdate[1][$i];
				} else {
					$anew["pubdate"] = '';
				}
				$news[] = $anew;
			}
		}
		return $news;
	}
	*/
	
	/* DEPRECATED - SLATED FOR REMOVAL
	 * We now get content from SimplePie parser via parse_feeds below
	 * -wjames5
	 */
	/*
	function parse_rss_data($rssdata, $rss_id) {
		return $this->NewsFeed($rssdata, $rss_id);
	}
	*/
	
	function refresh_rss_module($rss_id) {
		$info = $this->get_rss_module($rss_id);

		if ($info) {
			global $gBitSystem;
			$data = $this->rss_iconv( bit_http_request($info['url']));
			$now = $gBitSystem->getUTCTime();
			$query = "update `".BIT_DB_PREFIX."rss_modules` set `content`=?, `last_updated`=? where `rss_id`=?";
			$result = $this->mDb->query($query,array((string)$data,(int) $now, (int) $rss_id));
			return $data;
		} else {
			return false;
		}
	}

	function rss_module_name_exists($name) {
		$query = "select `name` from `".BIT_DB_PREFIX."rss_modules` where `name`=?";

		$result = $this->mDb->query($query,array($name));
		return $result->numRows();
	}

	function get_rss_module_id($name) {
		$query = "select `rss_id` from `".BIT_DB_PREFIX."rss_modules` where `name`=?";

		$id = $this->mDb->getOne($query,array($name));
		return $id;
	}

	function get_rss_show_title($rss_id) {
		$ret = FALSE;
		if( is_numeric( $rss_id ) ) {
			$query = "select `show_title` from `".BIT_DB_PREFIX."rss_modules` where `rss_id`=?";
	
			$ret = $this->mDb->getOne($query,array($rss_id));
		}
		return $ret;
	}

	function get_rss_show_pub_date($rss_id) {
		$ret = FALSE;
		if( is_numeric( $rss_id ) ) {
			$query = "select `show_pub_date` from `".BIT_DB_PREFIX."rss_modules` where `rss_id`=?";
	
			$show_pub_date = $this->mDb->getOne($query,array($rss_id));
			$ret = $show_pub_date;
		}
		return $ret;
	}

	/* DEPRECATED - SLATED FOR REMOVAL
	 * We now get content from SimplePie parser via parse_feeds below
	 * -wjames5
	 */
	/*
	function get_rss_module_content($rss_id) {
		$ret = FALSE;
		if( is_numeric( $rss_id ) ) {

			if( $info = $this->get_rss_module($rss_id) ) {
				global $gBitSystem;
				$now = $gBitSystem->getUTCTime();
		
		//		if ($info["last_updated"] + $info["refresh"] < $now) {
					$data = $this->refresh_rss_module($rss_id);
		//		}
		
				$info = $this->get_rss_module($rss_id);
				$ret = $info["content"];
			}
		}
		return $ret;
	}
	*/
	
	function rss_iconv($xmlstr, $tencod = "UTF-8") {
		if (preg_match("/<\?xml.*encoding=\"(.*)\".*\?>/", $xmlstr, $xml_head)) {
			$sencod = strtoupper($xml_head[1]);

			switch ($sencod) {
			case "ISO-8859-1":
				// Use utf8_encode a more standard function
				$xmlstr = utf8_encode($xmlstr);

				break;

			case "UTF-8":
			case "US-ASCII":
				// UTF-8 and US-ASCII don't need convertion
				break;

			default:
				// Not supported encoding, we must use iconv() or recode()
				if (function_exists('iconv')) {
					// We have iconv use it
					$new_xmlstr = @iconv($sencod, $tencod, $xmlstr);

					if ($new_xmlstr === FALSE) {
						// in_encod -> out_encod not supported, may be misspelled encoding
						$sencod = strtr($sencod, array(
							"-" => "",
							"_" => "",
							" " => ""
						));

						$new_xmlstr = @iconv($sencod, $tencod, $xmlstr);

						if ($new_xmlstr === FALSE) {
							// in_encod -> out_encod not supported, leave it
							$tencod = $sencod;

							break;
						}
					}

					$xmlstr = $new_xmlstr;
					// Fix an iconv bug, a few garbage chars beyound xml...
					$xmlstr = preg_replace("/(.*<\/rdf:RDF>).*/s", "\$1", $xmlstr);
				} elseif (function_exists('recode_string')) {
					// I don't have recode support could somebody test it?
					$xmlstr = @recode_string("$sencod..$tencod", $xmlstr);
				} else {
				// This PHP intallation don't have any EncodConvFunc...
				// somebody could create bit_iconv(...)?
				}
			}

			// Replace header, put the new encoding
			$xmlstr = preg_replace("/(<\?xml.*)encoding=\".*\"(.*\?>)/", "\$1 encoding=\"$tencod\"\$2", $xmlstr);
		}

		return $xmlstr;
	}
	
	function get_short_desc( $text ){
		// first we can remove unwanted stuff like images and lists or whatever - this is rough
		$pattern = array(
			"!<img[^>]*>!is",
			//"!<ul.*?</ul>!is",
		);
		$text = preg_replace( $pattern, "", $text );
		
		$text = substr($text, 0, 1000);		
		
		// now we strip remaining tags and xs whitespace
		$text = trim( preg_replace( "!\s+!s", " ", strip_tags( $text )));
		
		// finally we try to extract sentences as well as we can
		// to add more characters to split sentences by add them after the last \? - you might want to add : or ;
		preg_match_all( "#([\.!\?\s\)]*)(.*?[a-zA-Z]{2}\s*[\.\!\?]+\)?)#s", $text, $matches );
		
		return $matches[2];
	}
	
	function get_short_descs( $items, $length=1 ){
		$shortdescs = Array();
		
		if ( !empty($items) ){
			foreach ($items as $item){
				//we try to trim each story to given number of sentences
				$sentences = $this->get_short_desc( $item->get_description() );
				
				$shortdesc = NULL;
				for ($n = 0; $n < $length; $n++){
					$space = ($n > 0)?" ":NULL;
					$shortdesc .= $space;
					$shortdesc .= ( !empty( $sentences[$n] ) && $sentences[$n] != NULL ) ? $sentences[$n] : NULL;
				}
				
				$shortdescs[] = $shortdesc;
			}
		}
		
		return $shortdescs;
	}

	function parse_feeds( $pParamHash ){
		//set path to rss feed cache
		$cache_path = TEMP_PKG_PATH.'rss/simplepie';
		
		//we do this earlier instead of later because if we can't cache the source we shouldn't be pulling the rss feed.
		if( !is_dir( $cache_path ) && !mkdir_p( $cache_path ) ) {
			bit_log_error( 'Can not create the cache directory: '.$cache_path );
			
			return FALSE;
		}else{
			//load up parser SimplePie
			require_once( UTIL_PKG_PATH.'simplepie/simplepie.inc' );

			if (!is_array($pParamHash['id'])){
				$ids = explode( ",", $pParamHash['id'] );
			}else{
				$ids = $pParamHash['id'];
			}
			
			$urls = Array();
			
			foreach ($ids as $id){
				if( @BitBase::verifyId( $id ) ) {
					$feedHash = $this->get_rss_module( $id );
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
			
			//set cache time
			$cache_time = !empty($pParamHash['cache_time'])?$pParamHash['cache_time']:1;
			$feed->set_cache_duration( $cache_time );
			
			//not sure - we may want to eventually use this
			//$feed->set_stupidly_fast(TRUE);
			 
			// Initialize the feed object
			$feed->init();
			 
			// This will work if all of the feeds accept the same settings.
			$feed->handle_content_type();
			
			$items = $feed->get_items();
			
			return $items;
		}
	}	
}

global $rsslib;
$rsslib = new RSSLib();

?>
