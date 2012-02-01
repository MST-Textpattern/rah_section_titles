<?php	##################
	#
	#	rah_section_titles-plugin for Textpattern
	#	version 0.2
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	###################

	if (@txpinterface == 'admin')
		register_callback('rah_section_titles','admin_side','head_end');

	function rah_section_titles() {
		
		global $event;
		
		if($event != 'article')
			return;
		
		$rs = 
			safe_rows(
				'title,name',
				'txp_section',
				"name != 'default' order by title ASC"
			);
		
		if(!$rs)
			return;
		
		foreach($rs as $a)
			$out[] = 
				'		$("select[name=Section] option[value='.$a['name'].']").html("'.
					str_replace('"','\"',$a['title']).
				'");'.n;
		
		echo 
			n.
			'<script language="javascript" type="text/javascript">'.n.
			'	$(document).ready(function() {'.n.
					implode('',$out).
			'	});'.n.
			'</script>'.n;
	}?>