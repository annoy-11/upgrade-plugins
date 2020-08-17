
<?php

//     $modules = Engine_Api::_()->getDbTable('modules','core')->getEnabledModuleNames();
//     $moduleArray = array();
//     if(in_array('album',$modules))
//       $moduleArray['album'] = 'Albums';
//     if(in_array('blog',$modules))
//       $moduleArray['blog'] = 'Blogs';
//     if(in_array('video',$modules))
//       $moduleArray['video'] = 'Videos';
//     if(in_array('classified',$modules))
//       $moduleArray['classified'] = 'Classifieds';
//     if(in_array('group',$modules))
//       $moduleArray['group'] = 'Groups';
//     if(in_array('event',$modules))
//       $moduleArray['event'] = 'Events';
//     if(in_array('music_playlist',$modules))
//       $moduleArray['music'] = 'Music';
//     if(in_array('sesalbum',$modules))
//       $moduleArray['sesalbum_album'] = 'Advanced Photos & Albums Plugin';
//     if(in_array('sesblog',$modules))
//       $moduleArray['sesblog_blog'] = 'Advanced Blog Plugin';
//     if(in_array('sesvideo',$modules))
//       $moduleArray['sesvideo_video'] = 'Advanced Videos & Channels Plugin';
//     if(in_array('sesevent',$modules))
//       $moduleArray['sesevent_event'] = 'SES - Advanced Events Plugin';
//     if(in_array('sesmusic',$modules))
//       $moduleArray['sesmusic_album'] = 'Advanced Music Albums, Songs & Playlists Plugin';
//
// 	$headScript = new Zend_View_Helper_HeadScript();
// 	$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/jscolor/jscolor.js');
// 	$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'externals/ses-scripts/jquery.min.js');

	return array (
  'package' =>
  array (
		'type' => 'widget',
		'name' => 'sescontenthighlights',
		'version' => '4.10.3',
		'path' => 'application/widgets/sescontenthighlights',
		'title' => 'SES - Content Highlights',
		'description' => 'SES - Content Highlights',
		'author' => 'SocialEngineSolutions',
		'actions' =>
		array (
		  0 => 'install',
		  1 => 'upgrade',
		  2 => 'refresh',
		  3 => 'remove',
		),
		'directories' =>
		array (
			'application/widgets/sescontenthighlights',
		),
		'files' =>
        array (
            'externals/ses-scripts/slick.min.js',


        ),
	),
		'title' => 'SES - Content Highlight',
		'description' => 'This widget highlight content from chosen module in any of the 3 different designs available in this widget. Edit this widget to choose the module and design and configure various other settings.',
		'category' => 'SES - Widgets',
		'type' => 'widget',
		'path' => 'application/widgets/sescontenthighlights',
		'name' => 'sescontenthighlights',
		'autoEdit' => true,
		'adminForm' => array(
            'elements' => array(
//                 array(
//                     'Select',
//                     'highlight_module',
//                     array(
//                         'label' => 'Choose the Module to be shown in this widget.',
//                         'multiOptions' => $moduleArray,
//                     )
//                 ),
//                 array(
//                   'Select',
//                   'popularitycriteria',
//                   array(
//                     'label' => 'Choose the popularity criteria in this widget.',
//                     'multiOptions' => array(
//                       'creation_date' => 'Recently Created',
//                       'view_count' => 'View Count',
//                       'like_count' => 'Most Liked',
//                       'comment_count' => 'Most Commented',
//                       'modified_date' => 'Recently Modified'
//                     ),
//                   )
//                 ),
//                 array(
//                   'Text',
//                   'contentbackgroundcolor',
//                   array(
//                     'class' => 'SEScolor',
//                     'label'=>'Choose color of the content background color.',
//                     'value' => '#2fc581',
//                   )
//                 ),
//                 array(
//                     'Select',
//                     'highlight_design',
//                     array(
//                         'label' => 'Select the design',
//                         'value' => 1,
//                         'multiOptions' => array(1=>'Design 1',2=>'Design 2',3=>'Design 3' ),
//                     ),
//                 ),
//                 array(
//                   'Textarea',
//                   'widgetdescription',
//                   array(
//                     'label' => 'Enter the description.',
//                   ),
//                 ),
            ),
		),
);

