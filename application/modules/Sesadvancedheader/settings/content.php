<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

$arrayGallery =$banner_options= array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesadvancedheader")) {

  $banner_options = array();
  $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
  foreach ($path as $file) {
    if ($file->isDot() || !$file->isFile())
      continue;
    $base_name = basename($file->getFilename());
    if (!($pos = strrpos($base_name, '.')))
      continue;
    $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
    if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
      continue;
    $banner_options['public/admin/' . $base_name] = $base_name;
  }
//   $results = Engine_Api::_()->getDbtable('banners', 'sesadvancedheader')->getBanner(array('fetchAll' => true));
//   if (count($results) > 0) {
//     foreach ($results as $gallery)
//       $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
//   }
}


return array(
//   array(
//     'title' => 'SES - Banner Slideshow',
//     'description' => '',
//     'category' => 'SES - Advance Header',
//     'type' => 'widget',
//     'name' => 'sesadvancedheader.banner-slideshow',
//     'adminForm' => array(
//             'elements' => array(
//                 array(
//                     'Select',
//                     'banner_id',
//                     array(
//                         'label' => 'Choose the Banner to be shown in this widget.',
//                         'multiOptions' => $arrayGallery,
//                         'value' => 1,
//                     )
//                 ),
//                 array(
//                   'Text',
//                   'overlaycolor',
//                   array(
//                     'class' => 'SEScolor',
//                     'label'=>'Choose banner overlay colour.',
//                     'value' => '#78c744',
//                   )
//                 ),
//                 array(
//                     'Select',
//                     'inside_outside',
//                     array(
//                         'label' => 'Do you want to show Banner inside/outside?',
//                         'multiOptions' => array(
//                             '0' => 'Outside',
//                             '1' => 'Inside'
//                         ),
//                         'value' => 0,
//                     )
//                 ),
//                 array(
//                     'Select',
//                     'full_width',
//                     array(
//                         'label' => 'Do you want to show this Banner in full width?',
//                         'multiOptions' => array(
//                             '1' => 'Yes',
//                             '0' => 'No'
//                         ),
//                         'value' => 1,
//                     )
//                 ),
//                 array(
//                     'Text',
//                     'height',
//                     array(
//                         'label' => 'Enter the height of this Banner (in pixels).',
//                         'value' => 200,
//                         'validators' => array(
//                             array('Int', true),
//                             array('GreaterThan', true, array(0)),
//                         )
//                     ),
//                 ),
//             ),
//         ),
//   ),
	array(
    'title' => 'SES - Advanced Header',
    'description' => 'This widget will display the header of your website. Place this widget at Header Page.',
    'category' => 'SES - Advanced Header',
    'type' => 'widget',
    'autoEdit' => true,
    'name' => 'sesadvancedheader.header',
  ),

// 	array(
//     'title' => 'SES - View Page Banner',
//     'description' => '',
//     'category' => 'SES - Advance Header',
//     'type' => 'widget',
//     'name' => 'sesadvancedheader.view-page-banner',
//   ),

  array(
    'title' => 'SES - Custom Navigation Menu',
    'description' => "This widget will display the customized navigation menu on your website for which you can configure various settings. Place this widget at Header page.",
    'category' => 'SES - Advanced Header',
    'type' => 'widget',
    'autoEdit' => false,
    'name' => 'sesadvancedheader.custom-navigation-menu',
    'adminForm' => array(
      'elements' => array(
        array(
          'Select',
          'backgroundimage',
          array(
            'label' => 'Choose the Background Image to be shown in this widget.',
            'multiOptions' => $banner_options,
            'value' => '',
          )
        ),
        array(
            'Text',
            'height',
            array(
                'label' => 'Enter the height of this Image (in pixels).',
                'value' => 150,
                'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                )
            ),
        ),
        array(
            'Select',
            'textalignment',
            array(
                'label' => 'Title text alignment.',
                'multiOptions' => array(
                    '_txtcenter' => 'Center',
                    '_txtleft' => 'Left',
                    '_txtright' => 'Right'
                ),
                'value' => '_txtcenter',
            )
        ),
      ),
    ),
  ),
);
