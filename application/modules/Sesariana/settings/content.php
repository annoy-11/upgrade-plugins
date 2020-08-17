<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesariana") && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesariana.pluginactivated')) {

  $banner_options[] = '';
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
  
  $results = Engine_Api::_()->getDbtable('banners', 'sesariana')->getBanner(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
  }
}
$moduleEnable = Engine_Api::_()->sesariana()->getModulesEnable();
$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
$ariana_theme_widget = array(
		array(
			'title' => 'SES - Responsive Vertical Theme - Custom Navigation Menu',
			'description' => "Displays the plugin name in the menu inside an attractive banner. The menu name is automatically taken from the plugin on which the widget is placed. Edit this widget to configure various settings.",
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'sesariana.custom-navigation-menu',
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
                  'label' => 'Enter the height of this Banner (in pixels).',
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
                      'center' => 'Center',
                      'left' => 'Left'
                  ),
                  'value' => 'center',
              )
          ),
        ),
      ),
    ),
    array(
        'title' => 'SES - Responsive Vertical Theme - Banner Slideshow',
        'description' => 'Displays banner slideshows as configured by you in the admin panel of this theme. Edit this widget to choose the slideshow to be shown and configure various settings.',
        'category' => 'SES - Responsive Vertical Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesariana.banner-slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'banner_id',
                    array(
                        'label' => 'Choose the Banner to be shown in this widget.',
                        'multiOptions' => $arrayGallery,
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'full_width',
                    array(
                        'label' => 'Do you want to show this Banner in full width?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of this Banner (in pixels).',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
            ),
        ),
    ),
    array(
			'title' => 'SES - Responsive Vertical Theme - Footer Menu',
			'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor. You can upload icons for each menu item of Footer Menu from the "Manage Menu Icons" section of Ariana Theme.',
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'name' => 'sesariana.menu-footer',
      'autoEdit' => false,
    ),
    array(
			'title' => 'SES - Responsive Vertical Theme - Login',
			'description' => 'This widget displays login form in a transparent block with an image in background of the page.',
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'name' => 'sesariana.login',
      'autoEdit' => true,
      'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'showlogo',
                    array(
                        'label' => 'Do you want to show logo?.',
                        'multiOptions' => array(
                          '1' => 'Yes',
                          '0' => 'No'
                        
                        ),
                        'value' => 1,
                    )
                ),
            ),
        ),
    ),
    array(
			'title' => 'SES - Responsive Vertical Theme - Home Slider',
			'description' => 'This widget displays a banner in which the text will come in a very attractive floating way. This widget can be placed multiple times on a single or separate pages.',
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'name' => 'sesariana.home-slider',
      'autoEdit' => false,
    ),
    array(
			'title' => 'SES - Responsive Vertical Theme - Content Highlight',
			'description' => 'This widget highlight content from chosen module in any of the 3 different designs available in this widget. Edit this widget to choose the module and design and configure various other settings.',
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'name' => 'sesariana.highlight',
      'autoEdit' => true,
      'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'sesariana_highlight_module',
                    array(
                        'label' => 'Choose the Module to be shown in this widget.',
                        'multiOptions' => $moduleEnable,
                    )
                ),
                array(
                  'Select',
                  'popularitycriteria',
                  array(
                    'label' => 'Choose the popularity criteria in this widget.',
                    'multiOptions' => array(
                      'creation_date' => 'Recently Created',
                      'view_count' => 'View Count',
                      'like_count' => 'Most Liked',
                      'comment_count' => 'Most Commented',
                      'modified_date' => 'Recently Modified'
                    ),
                  )
                ),
                array(
                  'Text',
                  'contentbackgroundcolor',
                  array(
                    'class' => 'SEScolor',
                    'label'=>'Choose color of the content background color.',
                    'value' => '#2fc581',
                  )
                ),
                array(
                    'Select',
                    'sesariana_highlight_design',
                    array(
                        'label' => 'Select the design',
                        'value' => 1,
                        'multiOptions' => array(1=>'Design 1',2=>'Design 2',3=>'Design 3' ),
                    ),
                ),
                array(
                  'Textarea',
                  'widgetdescription',
                  array(
                    'label' => 'Enter the description.',
                  ),
                ),
            ),
        ),
    ),
    array(
			'title' => 'SES - Responsive Vertical Theme - Features',
			'description' => 'This widget displays the features entered in the admin panel of this theme.',
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'name' => 'sesariana.features',
      'autoEdit' => false,
    ),
    array(
			'title' => 'SES - Responsive Vertical Theme - Member Cloud',
			'description' => "Displays members of your site in an attractive widget with a color affect on mouse-over on member's profile picture. You can configure various settings of this widget by clicking on 'edit'.",
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'sesariana.member-cloud',
    ),
			array(
			'title' => 'SES - Responsive Vertical Theme - Header',
			'description' => '',
			'category' => 'SES - Responsive Vertical Theme',
			'type' => 'widget',
			'name' => 'sesariana.header',
			'autoEdit' => false,
		),
  );

return $ariana_theme_widget;