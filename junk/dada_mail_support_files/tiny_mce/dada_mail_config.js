 
	function openKCFinder(field_name, url, type, win) {
	    tinyMCE.activeEditor.windowManager.open({
	        file           : 'http://atlcurling.info/dada_mail_support_files/kcfinder/browse.php?opener=tinymce&type=' + type,
	        title          : 'KCFinder',
	        width          : 700,
	        height         : 500,
	        resizable      : "yes",
	        inline         : true,
	        close_previous : "no",
	        popup_css      : false
	    }, {
	        window : win,
	        input  : field_name
	    });
	    return false;
	}
 

tinyMCE.init({
	 
		file_browser_callback           : "openKCFinder",
	

	mode                            : "specific_textareas",
	editor_selector                 : "html_message_body",

	plugins : "inlinepopups,paste,searchreplace,style",
    dialog_type : "modal",

	theme_advanced_buttons1_add : "styleprops",
    theme_advanced_buttons3_add : "pastetext,pasteword,selectall,search,replace",
    paste_auto_cleanup_on_paste : true,

	verify_html                     : false, 
	theme                           : "advanced",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align    : "left",
    relative_urls                   : false,
    remove_script_host              : false, 

    document_base_url               : "http://atlcurling.info/dada_mail_support_files/"
});
