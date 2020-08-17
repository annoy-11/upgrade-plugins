<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    array(
        'title' => 'SES - Weather - Weather with Background Image',
        'description' => 'This widget displays the weather with the image in background. You can choose the image by editing this widget. This widget should only be placed in the middle or extended columns of your website.',
        'category' => 'SES - Weather',
        'type' => 'widget',
        'name' => 'sesweather.weather-dark-bg',
        'autoEdit' => true,
        'adminForm' => 'Sesweather_Form_Admin_Location',
    ),
    array(
        'title' => 'SES - Weather - Sidebar Weather',
        'description' => 'This widget displays weekly weather. This widget should only be placed in the left / right sidebar columns of your website.',
        'category' => 'SES - Weather',
        'type' => 'widget',
        'name' => 'sesweather.weather-sidebar',
        'autoEdit' => true,
        'adminForm' => 'Sesweather_Form_Admin_AdminLocation',
    ),
    array(
        'title' => 'SES - Weather - Weather with Info Graphics',
        'description' => 'This widget displays the weather with the info graphics. This widget should only be placed in the middle or extended columns of your website.',
        'category' => 'SES - Weather',
        'type' => 'widget',
        'name' => 'sesweather.weather-main',
        'autoEdit' => true,
        'adminForm' => 'Sesweather_Form_Admin_Location',
    ),
    array(
        'title' => 'SES - Weather - User Location Detector',
        'description' => 'This widget open a popup to get location sharing permission from users of your website. If users will share their location, then their location will come pre-filled in widgets of this plugin.',
        'category' => 'SES - Weather',
        'type' => 'widget',
        'name' => 'sesweather.location-detect',
        'autoEdit' => true,
    ),
);
