<?
	function generate_editor($editor_name, $cmsImagePath = "", $init_callback = ''){
		$css_path = "";

		if(strpos($editor_name,"_eng_") !== false)
		{
			$css_path = "../css/eng_server.css";
		}
		
		if(strpos($editor_name,"_tchi_") !== false)
		{
			$css_path = "../css/tchi_server.css";
		}

		if(strpos($editor_name,"_schi_") !== false)
		{
			$css_path = "../css/schi_server.css";
		}
?>
	$('#<?= $editor_name ?>').tinymce({
		// Location of TinyMCE script
		script_url : '../js/tiny_mce/tiny_mce.js',
		content_css: '<?= $css_path ?>',
		mode : "exact",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,image,link,unlink,|,styleselect,pasteword,|,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		file_browser_callback : "tinyBrowser",
		width: "700",
		height: "300",
		cmsImagePath: "<?= $cmsImagePath ?>"
		<? if($init_callback != "") { ?>
			,oninit: <?= $init_callback ?>
		<? } ?>
	});
<?
	}

	function generate_editor2($editor_name, $cmsImagePath = "", $init_callback = ''){
		$css_path = "";

		if(strpos($editor_name,"_eng_") !== false)
		{
			$css_path = "../css/eng_server.css";
		}
		
		if(strpos($editor_name,"_tchi_") !== false)
		{
			$css_path = "../css/tchi_server.css";
		}

		if(strpos($editor_name,"_schi_") !== false)
		{
			$css_path = "../css/schi_server.css";
		}
?>
	var css_path = "<?= $css_path ?>";
	$(<?= $editor_name ?>).tinymce({
		// Location of TinyMCE script
		script_url : '../js/tiny_mce/tiny_mce.js',
		content_css: css_path,
		mode : "exact",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,image,link,unlink,|,styleselect,pasteword,|,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		file_browser_callback : "tinyBrowser",
		width: "700",
		height: "300",
		cmsImagePath: "<?= $cmsImagePath ?>"
		<? if($init_callback != "") { ?>
			,oninit: <?= $init_callback ?>
		<? } ?>
	});
<?
	}
	
	function generate_editor_without_image($editor_name, $init_callback = ''){
		$css_path = "";

		if(strpos($editor_name,"_eng_") !== false)
		{
			$css_path = "../css/eng_server.css";
		}
		
		if(strpos($editor_name,"_tchi_") !== false)
		{
			$css_path = "../css/tchi_server.css";
		}

		if(strpos($editor_name,"_schi_") !== false)
		{
			$css_path = "../css/schi_server.css";
		}
?>
	$('#<?= $editor_name ?>').tinymce({
		// Location of TinyMCE script
		script_url : '../js/tiny_mce/tiny_mce.js',
		content_css: '<?= $css_path ?>',
		mode : "exact",
		theme : "advanced",
		plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,bullist,numlist,|,link,unlink,|,styleselect,pasteword,|,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		file_browser_callback : "tinyBrowser",
		width: "700",
		height: "300",
		document_base_url : '/'
		<? if($init_callback != "") { ?>
			,oninit: <?= $init_callback ?>
		<? } ?>
	});
<?
	}
?>