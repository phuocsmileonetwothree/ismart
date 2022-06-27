/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// config.filebrowserBrowseUrl =
	// 	'public/js/plugins/ckfinder/ckfinder.html';
	// config.filebrowserUploadUrl =
	// 	'public/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';

	config.extraPlugins = 'image2';

	config.filebrowserBrowseUrl =
		'public/js/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl =
		'public/js/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserUploadUrl =
		'public/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl =
		'public/js/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
};
