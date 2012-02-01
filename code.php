<?php	##################
	#
	#	rah_section_titles-plugin for Textpattern
	#	version 0.1.2
	#	by Jukka Svahn
	#	http://rahforum.biz
	#
	###################

	if (@txpinterface == 'admin') {
		register_callback('rah_section_titles','article');
	}

	function rah_section_titles() {
		global $vars;
		extract(gpsa(array('view','from_view','step','ID')));
		if(!$view || gps('save') || gps('publish')) {
			$view = 'text';
		}
		if (!$step) $step = "create";
		if ($step == "edit" && $view == "text" && !empty($ID) && $from_view != 'preview' && $from_view != 'html') $pull = true;
		else {
			$pull = false;
			if ($from_view=='preview' or $from_view=='html') {
				$store_out = array();
				$store = unserialize(base64_decode(ps('store')));
				foreach($vars as $var) if (isset($store[$var])) $store_out[$var] = $store[$var];
			} else $store_out = gpsa($vars);
			extract($store_out);
		}
		if(!$from_view && !$pull) $Section = getDefaultSection();
		if(is_numeric(gps('ID'))) $Section = fetch('Section','textpattern','ID',gps('ID'));
		if(ps('Section')) $Section = ps('Section');
		$code = rah_section_popup($Section);
		echo 
			'<script language="javascript" type="text/javascript">'.n.
			'	$(document).ready(function() {'.n.
			'		$("#section").remove();'.n.
			'		$("label[for=section]").after(\''.$code.'\');'.n.
			'	});'.n.
			'</script>';
	}

	function rah_section_popup($selected) {
		$rs = safe_rows_start('title, name', 'txp_section',"name != 'default' order by title ASC");
		if ($rs){
			$out[] = '<br /><select id="section" name="Section">';
			while ($a = nextRow($rs)) {
				extract($a);
				$out[] = str_replace("'",'','<option value="'.htmlspecialchars($name).'"'.(($selected == $name) ? ' selected="selected"' : '').'>'.htmlspecialchars($title).'</option>');
			}
			$out[] = '</select>';
			return implode('', $out);
		}
	} ?>