<?php

/**
 * Rah_section_titles plugin for Textpattern CMS
 *
 * @author Jukka Svahn
 * @date 2008-
 * @license GNU GPLv2
 * @link http://rahforum.biz/plugins/rah_section_titles
 *
 * Copyright (C) 2012 Jukka Svahn <http://rahforum.biz>
 * Licensed under GNU Genral Public License version 2
 * http://www.gnu.org/licenses/gpl-2.0.html
 */

	if(@txpinterface == 'admin')
		register_callback('rah_section_titles', 'admin_side', 'head_end');

	function rah_section_titles() {
		
		global $event;
		
		if($event != 'article')
			return;
		
		$rs = 
			safe_rows(
				'title,name',
				'txp_section',
				"name != 'default' ORDER BY title ASC"
			);
		
		if(!$rs)
			return;
		
		foreach($rs as $a)
			$out[] = 
				'	$("select[name=Section] option[value=\''.escape_js($a['name']).'\']").text("'.
					escape_js($a['title']).'");'.n;
		
		echo 
			script_js(
				'$(document).ready(function(){'.n.
					implode('',$out).
				'});'
			);
	}
?>