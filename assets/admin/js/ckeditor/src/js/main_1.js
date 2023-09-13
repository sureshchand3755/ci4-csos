/**
 * Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/* exported initSample */

if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
	CKEDITOR.tools.enableHtml5Elements( document );

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.height = 150;
CKEDITOR.config.width = 'auto';
CKEDITOR.config.toolbar = [
   ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo','SelectAll', '-', 'Scayt','Bold','Italic','Underline', 'Strike', 'Subscript', 'Superscript','NumberedList','BulletedList', '-', 'Outdent', 'Indent', 'Blockquote','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','BidiLtr', 'BidiRtl','Table', 'HorizontalRule', 'Smiley', 'Styles', 'Format', 'Font','FontSize','TextColor','BGColor','Maximize','lineheight'],
] ;

CKEDITOR.config.extraAllowedContent = 'h3{clear};h2{line-height};h2 h3{margin-left,margin-top}';
CKEDITOR.config.extraPlugins = 'print,format,font,colorbutton,justify,uploadimage';
CKEDITOR.config.uploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json';
CKEDITOR.config.filebrowserBrowseUrl = '/ckfinder/ckfinder.html';
CKEDITOR.config.filebrowserImageBrowseUrl = '/ckfinder/ckfinder.html?type=Images';
CKEDITOR.config.filebrowserUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
CKEDITOR.config.filebrowserImageUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
CKEDITOR.config.removeDialogTabs = 'image:advanced;link:advanced';

var initSample = ( function() {
	var wysiwygareaAvailable = isWysiwygareaAvailable(),
		isBBCodeBuiltIn = !!CKEDITOR.plugins.get( 'bbcode' );

	return function() {
		var editorElement = CKEDITOR.document.getById( 'editor_1' );
		// :(((
		
		if ( isBBCodeBuiltIn ) {
			editorElement.setHtml(
				'Hello world!\n\n' +
				'I\'m an instance of [url=http://ckeditor.com]CKEditor[/url].'
			);
		}

		// Depending on the wysiwygare plugin availability initialize classic or inline editor.
		if ( wysiwygareaAvailable ) {
			CKEDITOR.replace( 'editor_1' );
		} else {
			editorElement.setAttribute( 'contenteditable', 'true' );
			CKEDITOR.inline( 'editor_1' );

			// TODO we can consider displaying some info box that
			// without wysiwygarea the classic editor may not work.
		}
	};

	function isWysiwygareaAvailable() {
		// If in development mode, then the wysiwygarea must be available.
		// Split REV into two strings so builder does not replace it :D.
		if ( CKEDITOR.revision == ( '%RE' + 'V%' ) ) {
			return true;
		}

		return !!CKEDITOR.plugins.get( 'wysiwygarea' );
	}
} )();

