<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: content.php 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

$arrayGallery =$banner_options= array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesadvancedbanner")) {

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
  $results = Engine_Api::_()->getDbtable('banners', 'sesadvancedbanner')->getBanner(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
  }
}
return array(
  array(
    'title' => 'SES - Banner Slideshow',
    'description' => 'This widget displays banner on your website. You can place this widget at any page of your choice.',
    'category' => 'SES - Advance Banner',
    'type' => 'widget',
    'name' => 'sesadvancedbanner.banner-slideshow',
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
                    'inside_outside',
                    array(
                        'label' => 'Do you want to show Banner inside/outside( NOTE: This setting work with Advanced Header Plugin)?',
                        'multiOptions' => array(
                            '0' => 'Outside',
                            '1' => 'Inside'
                        ),
                        'value' => 0,
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
                    'Select',
                    'bgimg_move',
                    array(
                        'label' => 'Do you want to animate banner image?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'nav',
                    array(
                        'label' => 'Do you want to show navigation arrow?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'scrollbottom',
                    array(
                        'label' => 'Do you want to show Scroll Bottom arrow?',
                        'multiOptions' => array(
                            '1' => 'First Design',
                            '2' => 'Second Design',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'duration',
                    array(
                        'label' => 'Slide duration?',
                        'value' => 3000,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
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

);
