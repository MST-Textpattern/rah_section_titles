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

	if(@txpinterface == 'admin') {
		register_callback('rah_section_titles', 'article_ui', 'section');
	}

/**
 * Replaces the section list
 * @param string $event
 * @param string $step
 * @param string $default
 * @param array $data
 * @return HTML
 */

	function rah_section_titles($event, $step, $default, $data) {
		
		$rs = safe_rows('name, title', 'txp_section', "name != 'default' ORDER BY title ASC");
		
		if(!$rs) {
			return;
		}
		
		$out = array();
		
		foreach($rs as $a) {
			$out[$a['name']] = $a['title'];
		}
		
		return 
			preg_replace(
				'/<select[^>]*?>[\s\S]*?<\/select>/',
				selectInput('Section', $out, $data['Section'], '', '', 'section'),
				$default
			);
	}
?>