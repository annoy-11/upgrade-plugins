<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesytube") && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesytube.pluginactivated')) {

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

  $results = Engine_Api::_()->getDbtable('banners', 'sesytube')->getBanner(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
  }
}
$moduleEnable = Engine_Api::_()->sesytube()->getModulesEnable();
$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
return array(
    array(
        'title' => 'SES - UTube Clone Theme - Banner Slideshow',
        'description' => 'Displays banner slideshows as configured by you in the admin panel of this theme. Edit this widget to choose the slideshow to be shown and configure various settings.',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesytube.banner-slideshow',
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
        'title' => 'SES - UTube Clone Theme - Login',
        'description' => 'This widget displays login form in a transparent block with an image in background of the page.',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.login',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Home Slider',
        'description' => 'This widget displays a banner in which the text will come in a very attractive floating way. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.home-slider',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Member Cloud',
        'description' => "Displays members of your site in an attractive widget with a color affect on mouse-over on member's profile picture. You can configure various settings of this widget by clicking on 'edit'.",
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'autoEdit' => false,
        'name' => 'sesytube.member-cloud',
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Header',
        'description' => '',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.header',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Text Content',
        'description' => '',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.text-block',
        'autoEdit' => false,
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Home Videos',
        'description' => '',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.videos',
        'autoEdit' => false,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Enter Category Limit',
                    ),
                    'value' => 10,
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Popular Videos',
        'description' => '',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.popular-videos',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
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
                    'limit',
                    array(
                        'label' => 'Enter Limit.',
                    ),
                    'value' => 3,
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - UTube Clone Theme - Home Photos',
        'description' => '',
        'category' => 'SES - UTube Clone Theme',
        'type' => 'widget',
        'name' => 'sesytube.photos',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popularitycriteria',
                    array(
                        'label' => 'Choose the popularity criteria in this widget.',
                        'multiOptions' => array(
                            'creation_date' => 'Recently Created',
                            'view_count' => 'Most Viewed',
                            'like_count' => 'Most Liked',
                            'comment_count' => 'Most Commented',
                        ),
                    ),
                ),
                array(
                    'MultiCheckbox',
                    'show_criteria',
                    array(
                        'label' => "Choose from below the details that you want to show in this widget.",
                        'multiOptions' => array(
                            'like' => 'Likes Count',
                            'comment' => 'Comments Count',
                            'view' => 'Views Count',
                            'by' => 'Owner\'s Name',
                            'favouriteCount' => 'Favourites Count',
                        ),
                        'escape' => false,
                    )
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Enter Limit.',
                    ),
                    'value' => 12,
                ),
            ),
        ),
    ),
);
