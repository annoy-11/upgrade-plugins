<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$moduleEnable = Engine_Api::_()->seslike()->getModulesEnable();

return array(
    array(
        'title' => 'SES - Professional Likes Plugin - My Friend Content Like Widget',
        'description' => 'Displays a viewer friend content liked.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seslike.myfriendcontentlike',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - My Content Like Widget',
        'description' => 'Displays a viewer content liked by another members.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seslike.mycontentlike',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - Who Like Me',
        'description' => 'Displays like user who like viewer profile. This widget is only placed on "Who Like Me Page" only.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => false,
        'name' => 'seslike.wholikeme',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - Like Button for Content Profile Page',
        'description' => 'Displays like button for content profile page. This widget is only placed on "Content Profile Page" only.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => false,
        'name' => 'seslike.like-button',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - Browse Menu',
        'description' => 'Displays a menu in the like page.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'name' => 'seslike.browse-menu',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - Like Sidebar Tabbed Widget',
        'description' => 'Displays a tabbed widget for likes. You can place this widget anywhere on your site.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seslike.sidebar-tabbed-widget',
        'adminForm' => 'Seslike_Form_Admin_SidebarTabbed',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - Tabbed Widget',
        'description' => 'Displays a tabbed widget for contents. You can place this widget anywhere on your site.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seslike.tabbed-widget',
        'adminForm' => 'Seslike_Form_Admin_Tabbed',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - My Likes Page Widget',
        'description' => 'This widget display on My Likes Page.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'seslike.mylikes-widget',
    ),
    array(
        'title' => 'SES - Professional Likes Plugin - Side Widget',
        'description' => 'This widget shows the side widget content for seslike plugin.',
        'category' => 'SES - Professional Likes Plugin',
        'type' => 'widget',
        'name' => 'seslike.side-widget',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'module',
                    array(
                        'label' => 'Choose the Module to be shown in this widget.',
                        'multiOptions' => $moduleEnable,
                    )
                ),
                array(
                    'Text',
                    'limit',
                    array(
                        'label' => 'Enter content limit.',
                    ),
                    'value' => '3',
                ),
            ),
        ),
    ),
);
