/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.toolbarGroups = [
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
                { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' }
	];
 
	// removeButtons: remove alguns botões da barra de ferramentas
	config.removeButtons = 'Image';
 
	// format_tags: permite um conjunto limitado de formatos de texto
	config.format_tags = 'p;h1;h2;h3;pre';
 
        // removeDialogTabs: remove as caixas de diálogo 
	config.removeDialogTabs = 'image:advanced;link:advanced';
 
        // extraPlugins: ativa plugins adicionais
        config.extraPlugins = 'justify';
};
