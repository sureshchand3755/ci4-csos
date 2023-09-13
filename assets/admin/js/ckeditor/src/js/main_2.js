/**
 * Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

/* exported initSample */

if ( CKEDITOR.env.ie && CKEDITOR.env.version < 9 )
	CKEDITOR.tools.enableHtml5Elements( document );

// The trick to keep the editor in the sample quite small
// unless user specified own height.
CKEDITOR.config.width = 'auto';
CKEDITOR.config.toolbar = [
   ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo','SelectAll', '-','Bold','Italic','Underline', 'Strike', 'NumberedList','BulletedList', '-', 'Outdent', 'Indent', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','BidiLtr', 'BidiRtl', 'Styles', 'Format', 'Font','FontSize','TextColor','BGColor','lineheight','Maximize'],
] ;

CKEDITOR.config.extraPlugins = 'lineheight,autogrow';
CKEDITOR.config.line_height = "1em;1.5em;2em;2.5em;3em;3.5em;4em;4.5em;5em;5.5em;6em;6.5em;7em;7.5em";

CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_P;
CKEDITOR.config.autoParagraph = false;
CKEDITOR.dtd.$removeEmpty['span'] = false;
CKEDITOR.config.extraAllowedContent = 'span(*)';
CKEDITOR.config.autoGrow_minHeight = 220;
CKEDITOR.config.autoGrow_maxHeight = 400;

