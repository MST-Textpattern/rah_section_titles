<?php	##################
	#
	#	rah_section_titles-plugin for Textpattern
	#	version 0.4
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	#	Copyright (C) 2011 Jukka Svahn <http://rahforum.biz>
	#	Licensed under GNU Genral Public License version 2
	#	http://www.gnu.org/licenses/gpl-2.0.html
	#
	##################

	if(@txpinterface == 'admin')
		register_callback('rah_section_titles','admin_side','head_end');

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