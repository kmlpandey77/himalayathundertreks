/**
 * @license Copyright (c) 2003-2018, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.toolbarGroups = [{
			name: 'document',
			groups: ['mode', 'document', 'doctools']
		},
		{
			name: 'clipboard',
			groups: ['clipboard', 'undo']
		},
		{
			name: 'styles',
			groups: ['styles']
		},
		'/',
		{
			name: 'editing',
			groups: ['find', 'selection', 'spellchecker', 'editing']
		},
		{
			name: 'forms',
			groups: ['forms']
		},
		{
			name: 'basicstyles',
			groups: ['basicstyles', 'cleanup']
		},
		{
			name: 'paragraph',
			groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
		},
		{
			name: 'links',
			groups: ['links']
		},
		{
			name: 'insert',
			groups: ['insert']
		},
		{
			name: 'colors',
			groups: ['colors']
		},
		{
			name: 'tools',
			groups: ['tools']
		},
		{
			name: 'others',
			groups: ['others']
		},
		{
			name: 'about',
			groups: ['about']
		}
	];

	config.removeButtons = 'Cut,Copy,Paste,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Checkbox,CopyFormatting,RemoveFormat,BidiLtr,BidiRtl,Language,Flash,SpecialChar,PageBreak,Iframe,Maximize,About,ShowBlocks,Anchor';

};