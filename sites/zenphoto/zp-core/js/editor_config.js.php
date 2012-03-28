<?php
if (file_exists("plugins/tiny_mce/tiny_mce.js")) {
?> 
<script language="javascript" type="text/javascript" src="plugins/tiny_mce/tiny_mce.js"></script>
	<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "zenphoto",
		language: "en",
	  editor_selector: "texteditor",
	  plugins : "safari,fullscreen",
		theme_zenphoto_toolbar_location : "top",
		theme_zenphoto_toolbar_align : "left",
		theme_zenphoto_statusbar_location : "bottom",
		theme_zenphoto_resizing : true,
		theme_zenphoto_resize_horizontal : false,
		paste_use_dialog : true,
		paste_create_paragraphs : false,
		paste_create_linebreaks : false,
		paste_auto_cleanup_on_paste : true,
		apply_source_formatting : true,
		force_br_newlines : false,
		force_p_newlines : true,	
		relative_urls : false,
		document_base_url : "<?php echo WEBPATH."/"; ?>",
		convert_urls : false
	});
</script>
<?php
}
?>