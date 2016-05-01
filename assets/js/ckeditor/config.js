/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    // Define changes to default configuration here. For example:
    config.language = 'th';
    config.height = 200;
    config.width = 600;
    config.enterMode = CKEDITOR.ENTER_DIV;
    config.fontSize_style = '10px';

//    config.filebrowserBrowseUrl = base_url + 'assets/js/kcfinder/browse.php?type=files';
//    config.filebrowserImageBrowseUrl = base_url + 'assets/js/kcfinder/browse.php?type=images';
//    config.filebrowserFlashBrowseUrl = base_url + 'assets/js/kcfinder/browse.php?type=flash';
//    config.filebrowserUploadUrl = base_url + 'assets/js/kcfinder/upload.php?type=files';
//    config.filebrowserImageUploadUrl = base_url + 'assets/js/kcfinder/upload.php?type=images';
//    config.filebrowserFlashUploadUrl = base_url + 'assets/js/kcfinder/upload.php?type=flash';
    
    // config.uiColor = '#AADC6E';
    config.toolbar =
    [
        ['Source','-','NewPage','Preview'],
        ['Cut','Copy','Paste','PasteText','PasteFromWord'],
        ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
        '/',
        ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
        ['NumberedList','BulletedList','-','Outdent','Indent'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link','Unlink','Anchor'],
        '/',
        ['Image','Flash'],
        ['TextColor','BGColor'],
        ['Format'],
    ];
};
