<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: content.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
$data = array('' => '');
$galleryTable = Engine_Api::_()->getDbtable('galleries', 'sesdbslide');
$select = $galleryTable->select();
$gallery = $galleryTable->fetchAll($select);

foreach ($gallery as $galleries) {
    $data[$galleries->getIdentity()] = $galleries->getTitle();
}
    //default logos
    $default_photos_main = array();
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
      $default_photos_main['public/admin/' . $base_name] = $base_name;
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
return array(
    array(
        'title' => 'SES - Double Banner Slideshow',
        'description' => 'This widget displays the Banner Slideshow as created by you from the admin panel of this plugin. Edit the widget to configure various setting and choose the slideshow to be displayed in this widget.',
        'category' => 'SES - Double Banner Slideshow',
        'type' => 'widget',
		'autoEdit' => true,
        'name' => 'sesdbslide.slideshow',
        'adminForm' => array(
            'elements' => array(
                array('text', 'title',
                    array(
                        'label' => 'Title',
                    )
                ),
                array(
                    'Select', 'gallery_id',
                    array(
                        'label' => 'Choose SlideShow which you want to dispaly in this widget.',
                        'multiOptions' => $data,
                    )
                ),
              array(
                'Radio', 'header_insight_out',
                array(
                  'label' => 'Choose the location of Header to be shown in this widget. If you choose Header Inside, then the Supported header will show over the banner displayed in this widget.',
                  'multiOptions' => array(
                    '0' => 'Header outside ',
                    '1' => 'Header Inside (for supported headers)',
                    '2' => 'Header Inside (in-built header of this plugin)'
                  ),
                  'value' => '0',
                )
              ),
              array(
                'Select',
                'main_navigation',
                array(
                  'label' => 'Do you want to show Main Navigation Menu in this widget? (If you choose "No" below then we recommend you too choose "No" for Mini Navigation Menu and Site logo.)',
                  'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                  ),
                  'value' => 0,
                )
              ),
              array(
                'Select',
                'mini_navigation',
                array(
                  'label' => 'Do you want to show Mini Navigation Menu on this widget?',
                  'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                  ),
                  'value' => 0,
                )
              ),
              array(
                'text',
                'max_menus',
                array(
                  'label' => 'how many menus wants to outside "More" tab ,This setting will work if you have chosen to show " header inside (in-built header of this plugin)" the slideshow.) ?',
                  'value' => 6,
                )
              ),
              array(
                'Select',
                'logo',
                array(
                  'label' => 'Do you want to show logo in this widget? This setting will work if you have chosen to show " header inside (in-built header of this plugin)" the slideshow.',
                  'multiOptions' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                  ),
                  'value' => 1,
                )
              ),
              array(
                'Select', 'logo_url',
                array(
                  'label' => 'Upload Logo (This setting will work if you have chosen to show " header inside (in-built header of this plugin)" the slideshow.)',
                  'multiOptions' => $default_photos_main,
                )
              ),

              array('text', 'banner_height',
                array(
                  'label' => 'Enter the height of Banner Slideshow to be displayed in this widget.',
									'allowEmpty' => false,
									'required' => true,
                  'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
                  )
                )
              ),

              array(
                'Radio', 'enable_navigation',
                array(
                  'label' => 'Do you want to display right/left navigations in this widget?',
                  'multiOptions' => array(
                    '1' => 'yes',
                    '0' => 'no',
                  ),
                  'value' => '0',
                )
              ),
                array(
                    'Radio', 'banner_full_width',
                    array(
                        'label' => 'Do you want to show this Banner in Full Width?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No',
                        ),
                        'value' => '1',
                    )
                ),
                array('text', 'transition_delay',
                    array(
                        'label' => 'Enter the Transition Delay Time for the slides to be displayed in this slideshow.',
                        'value' => '5000',
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
                array(
                    'Radio', 'slide_order',
                    array(
                        'label' => 'Choose the Order for the Slides to be displayed in this widget.',
                        'multiOptions' => array(
                            '1' => 'Admin Selected Order',
                            '0' => 'Random Order',
                        ),
                        'value' => '1',
                    )
                ),
                array('text', 'count_number_shows',
                    array(
                        'label' => 'Count (number of slides to show.Put 0 for all slides)',
                        'validators' => array(
                            array('Int', true),
                        )
                    )
                ),
            )
        ),
    ),
        )
?>