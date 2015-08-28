/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function(config) {
   config.filebrowserBrowseUrl      = 'http://atlcurling.info/dada_mail_support_files/kcfinder/browse.php?type=files';
   config.filebrowserImageBrowseUrl = 'http://atlcurling.info/dada_mail_support_files/kcfinder/browse.php?type=images';
   config.filebrowserFlashBrowseUrl = 'http://atlcurling.info/dada_mail_support_files/kcfinder/browse.php?type=flash';
   config.filebrowserUploadUrl      = 'http://atlcurling.info/dada_mail_support_files/kcfinder/upload.php?type=files';
   config.filebrowserImageUploadUrl = 'http://atlcurling.info/dada_mail_support_files/kcfinder/upload.php?type=images';
   config.filebrowserFlashUploadUrl = 'http://atlcurling.info/dada_mail_support_files/kcfinder/upload.php?type=flash';

	config.toolbar_DadaMail_Admin =
	[
		{ name: 'basicstyles',	items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'styles',		items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors',		items : [ 'TextColor','BGColor' ] },
		'/',
		{ name: 'paragraph',	items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links',		items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert',		items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar' ] },

		'/',
		{ name: 'clipboard',	items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing',		items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'document',		items : [ 'Source','Maximize', 'ShowBlocks'] },
	];
};