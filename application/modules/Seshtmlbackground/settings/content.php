<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seshtmlbackground
 * @package    Seshtmlbackground
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-10-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("seshtmlbackground") && Engine_Api::_()->getApi('settings', 'core')->getSetting('seshtmlbackground.pluginactivated')) {
  $results = Engine_Api::_()->getDbtable('galleries', 'seshtmlbackground')->getGallery(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['gallery_id']] = $gallery['gallery_name'];
  }
}
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
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
    $fileLink = $view->baseUrl() . '/admin/files/';
return array(
		array(
        'title' => 'SES - HTML5 Background - HTML5 Videos & Photos Background',
        'description' => 'This widget displays video / image slideshow as chosen by you from the "Manage Slides" section of HTML5 Videos & Photos Background Plugin.',
        'category' => 'SES - HTML5 Videos & Photos Background Plugin',
        'type' => 'widget',
        'name' => 'seshtmlbackground.slideshow',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'gallery_id',
                    array(
                        'label' => 'Choose the HTML5 Background to be shown in this widget.',
                        'multiOptions' => $arrayGallery,
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'templateDesign',
                    array(
                        'label' => 'Choose the Template Design to be shown in this widget. ',
                        'multiOptions' => array(
													0 => "Template - 1",
													1 => "Template - 2",
													2 => "Template - 3",
													3 => "Template - 4",
													4 => "Template - 5",
													5 => "Template - 6",
													6 => "Template - 7",
                          7 => "Template - 8",
												),
                        'value' => 0,
                    )
                ),
                array(
                    'Select',
                    'inside_ouside',
                    array(
                        'label' => 'Do you want to show header inside the slideshow?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'full_width',
                    array(
                        'label' => 'Do you want to show this HTML5 Background in full width?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'full_height',
                    array(
                        'label' => 'Do you want to show this HTML5 Background in full height?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'mute_video',
                    array(
                        'label' => 'Do you want to mute video in this HTML5 Background slideshow?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'logo',
                    array(
                        'label' => 'Do you want to show logo in this HTML5 Background?[Note: This setting will only work in Template 1 & 4]',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'logo_url',
                    array(
                        'label' => 'Do you want to show different logo in this HTML5 Background,this setting only work if you select Yes in above setting and leave blank if you want to show same logo as site logo? [Note: This setting will only work in Template 1 & 4]',
                        'multiOptions' => $banner_options,
                    )
                ),
                array(
                    'Select',
                    'main_navigation',
                    array(
                        'label' => 'Do you want to show Main Navigation Menu in this HTML5 Background? (If you choose "No" below then we recommend you too choose "No" for Mini Navigation Menu and Site logo.)  [Note: This setting will only work in Template 1 & 4]',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'mini_navigation',
                    array(
                        'label' => 'Do you want to show Mini Navigation Menu on this HTML5 Background? [Note: This setting will only work in Template 1 & 4]',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'autoplay',
                    array(
                        'label' => 'Do you want Videos and Photos to autoplay in this HTML5 Background?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'thumbnail',
                    array(
                        'label' => 'How do you want to enable users to navigate between various slides?',
                        'multiOptions' => array(
                            '1' => 'Using Thumbnails',
                            '2' => 'Using Bullets',
                            '3' => 'Using Lines',
                            '0' => ' Do not allow navigation'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'searchEnable',
                    array(
                        'label' => 'Do you want to show AJAX based Global Search in this HTML5 Background? [Note: This setting will only work in Template 1]',
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
                        'label' => 'Enter the height of this HTML5 Background (in pixels).',
                        'value' => 583,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
								array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of photos/videos to show.Put 0 for all videos/photos)',
                        'value' => 0,
                        'validators' => array(
                            array('Int', true),
                        )
                    ),
                ),
								array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose Videos/Photos order in this widget.',
                        'multiOptions' => array('random'=>'Random Order','adminorder'=>'Admin Order'),
                        'value' => 'adminorder',
                    )
                ),
								array(
                    'Text',
                    'autoplaydelay',
                    array(
                        'label' => 'Enter the transition delay time for the photos to be displayed in this HTML background. [This setting will not effect on videos.]',
                        'value' => 5000,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'signupformtopmargin',
                    array(
                        'label' => 'Enter the margin from top of Signup Form to be shown in this HTML5 Background (in pixels).',
                        'value' => 60,
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
        'title' => 'Parallax Effect Widget For Video',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - HTML5 Videos & Photos Background Plugin',
        'type' => 'widget',
				'autoEdit' => true,
        'name' => 'seshtmlbackground.parallax-video',
				'adminForm' => 'Seshtmlbackground_Form_Admin_Paralexvideo',
    ),
/*array(
        'title' => 'SES - HTML5 Background - Slide Image',
        'description' => 'This widget displays video / image slideshow as chosen by you from the "Manage Slides" section of HTML5 Videos & Photos Background Plugin.',
        'category' => 'SES - HTML5 Videos & Photos Background Plugin',
        'type' => 'widget',
        'name' => 'seshtmlbackground.slide-image',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'gallery_id',
                    array(
                        'label' => 'Choose the HTML5 Background to be shown in this widget.',
                        'multiOptions' => $arrayGallery,
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'templateDesign',
                    array(
                        'label' => 'Choose the Template Design to be shown in this widget.',
                        'multiOptions' => array(
												  0 => "Template - 1",
													1 => "Template - 2",
													2 => "Template - 3",
													3 => "Template - 4",
													4 => "Template - 5",
													5 => "Template - 6",
													6 => "Template - 7",
												),
                        'value' => 0,
                    )
                ),
                array(
                    'Select',
                    'full_width',
                    array(
                        'label' => 'Do you want to show this HTML5 Background in full width?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'full_height',
                    array(
                        'label' => 'Do you want to show this HTML5 Background in full height?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'mute_video',
                    array(
                        'label' => 'Do you want to mute video in this HTML5 Background slideshow?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'logo',
                    array(
                        'label' => 'Do you want to show logo in this HTML5 Background?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'logo_url',
                    array(
                        'label' => 'Do you want to show different logo in this HTML5 Background,this setting only work if you select Yes in above setting and leave blank if you want to show same logo as site logo?',
                        'multiOptions' => $banner_options,
                    )
                ),
                array(
                    'Select',
                    'main_navigation',
                    array(
                        'label' => 'Do you want to show Main Navigation Menu in this HTML5 Background? (If you choose "No" below the we recommend you too choose "No" for Mini Navigation Menu and Site logo.)',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'mini_navigation',
                    array(
                        'label' => 'Do you want to show Mini Navigation Menu on this HTML5 Background?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'autoplay',
                    array(
                        'label' => 'Do you want Videos and Photos to autoplay in this HTML5 Background?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'thumbnail',
                    array(
                        'label' => 'How do you want to enable users to navigate between various slides?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
								array(
                    'Select',
                    'searchEnable',
                    array(
                        'label' => 'Do you want to show AJAX based Global Search in this HTML5 Background?',
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
                        'label' => 'Enter the height of this HTML5 Background (in pixels).',
                        'value' => 583,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
								array(
                    'Text',
                    'limit_data',
                    array(
                        'label' => 'Count (number of photos/videos to show.Put 0 for all videos/photos)',
                        'value' => 0,
                        'validators' => array(
                            array('Int', true),
                        )
                    ),
                ),
								array(
                    'Select',
                    'order',
                    array(
                        'label' => 'Choose Videos/Photos order in this widget.',
                        'multiOptions' => array('random'=>'Random Order','adminorder'=>'Admin Order'),
                        'value' => 'adminorder',
                    )
                ),
								array(
                    'Text',
                    'autoplaydelay',
                    array(
                        'label' => 'Enter the transition delay time for the photos to be displayed in this HTML background. [This setting will not effect on videos.]',
                        'value' => 5000,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
                array(
                    'Text',
                    'signupformtopmargin',
                    array(
                        'label' => 'Enter the margin from top of Signup Form to be shown in this HTML5 Background (in pixels).',
                        'value' => 60,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
            ),
        ),
    
		),*/
		 array(
        'title' => 'Parallax Effect Widget For Image',
        'description' => 'You can place this widget anywhere. Image to be chosen in this widget should be first uploaded from the "Layout" >> "File & Media Manager" section. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - HTML5 Videos & Photos Background Plugin',
        'type' => 'widget',
        'name' => 'seshtmlbackground.parallax-image',
				'autoEdit' => true,
        'adminForm' => 'Seshtmlbackground_Form_Admin_Paralex',
    ),
);
?>