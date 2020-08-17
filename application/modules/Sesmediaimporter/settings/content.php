<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
  array(
    'title' => 'SES - Media Importer - Banner with iOS and Android Apps Buttons',
    'description' => 'This widget displays a banner with attractive color effects and buttons for your iOS and Android app links. If you do not want to show the buttons, then do not add the links. This banner can be used anywhere on the site and any number of times. You can choose this widget to be shown in full width or the container width.',
    'category' => 'SES - Social Photo Media Importer Plugin',
    'type' => 'widget',
    'name' => 'sesmediaimporter.banner',
    'autoEdit' => true,
    'adminForm' => 'Sesmediaimporter_Form_Admin_Banner',
  ),
  array(
    'title' => 'SES - Media Importer - How it Works and Social Services',
    'description' => 'This widget displays the How it Works section and the Social Services to get connected and import the photos.',
    'category' => 'SES - Social Photo Media Importer Plugin',
    'type' => 'widget',
    'name' => 'sesmediaimporter.importer-select',
    'autoEdit' => false
  ),
  array(
    'title' => 'SES - Media Importer - Imported Photos from Social Sites',
    'description' => 'Displays imported photos from the connected Social sites. Users will be able to select photos from the social sites and import them into your website.',
    'category' => 'SES - Social Photo Media Importer Plugin',
    'type' => 'widget',
    'name' => 'sesmediaimporter.importer-service',
    'autoEdit' => false,
  ),
  array(
    'title' => 'SES - Media Importer - Shortcuts for Photo Import',
    'description' => 'This widget displays the social services enabled from the admin panel of this plugin to import the photos on your website. This widget will add shortcuts to the photo media import options.',
    'category' => 'SES - Social Photo Media Importer Plugin',
    'type' => 'widget',
    'name' => 'sesmediaimporter.quick-import',
    'autoEdit' => false
  ),
 );