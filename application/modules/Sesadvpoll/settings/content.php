<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
    array(
        'title' => 'SES - Advanced Polls Plugin - Navigation Menu',
        'description' => 'Displays a navigation menu bar.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Member Profile Polls',
        'description' => 'Displays a Member Polls on its profile page. The recommended page for this widget is "Member Profile Page".',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.profile-polls',
        'autoEdit' => true,
        'adminForm' => 'Sesadvpoll_Form_Admin_Settings_Profilepolls',
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Manage Polls',
        'description' => 'Displays all polls on "SES - Advanced Polls Plugin - Manage Polls Page" page.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.manage-polls',
        'autoEdit' => true,
        'adminForm' => 'Sesadvpoll_Form_Admin_Settings_Managepolls',
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Poll Manage Search',
        'description' => 'Displays a search form in the poll manage page.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.manage-search',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Browse Polls',
        'description' => 'Displays all polls on "SES - Advanced Polls Plugin - Browse Polls Page" page.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-polls',
        'autoEdit' => true,
        'adminForm' => 'Sesadvpoll_Form_Admin_Settings_Browsepolls',
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Poll Profile - Breadcrumb for Poll View Page',
        'description' => 'Displays Breadcrumb for the Polls. This widget should be placed on "SES - Advanced Polls Plugin - Poll View Page".',
        'category' => 'SES - Advanced Polls Plugin',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesadvpoll.breadcrumb',
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Poll Profile - Poll Details & Information',
        'description' => 'Displays details and information about the poll on the "SES - Advanced Polls Plugin - Poll View Page".',
        'category' => 'SES - Advanced Polls Plugin',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesadvpoll.view-poll',
        'adminForm' => 'Sesadvpoll_Form_Admin_Settings_Viewpage',
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Popular Polls',
        'description' => 'Displays popular polls based on chosen popularity criteria. Edit this widget to configure the criteria and other settings.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.list-popular-polls',
        'adminForm' => 'Sesadvpoll_Form_Admin_Settings_Popularpolls',
        'autoEdit' => true,
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Tabbed widget for Popular Page Polls',
        'description' => 'Displays a tabbed widget for popular polls on your website based on various popularity criterias. Edit this widget to configure various settings. This widget can be placed anywhere on your website.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesadvpoll.tabbed-widget-poll',
        'adminForm' => 'Sesadvpoll_Form_Admin_Settings_TabbedWidget',
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Poll Browse Search',
        'description' => 'Displays a search form in the poll browse page.',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-search',
        'requirements' => array(
        'no-subject',
        ),
    ),
    array(
        'title' => 'SES - Advanced Polls Plugin - Browse Polls Page Button',
        'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Advanced Polls Plugin - Browse Polls Page".',
        'category' => 'SES - Advanced Polls Plugin',
        'type' => 'widget',
        'name' => 'sesadvpoll.browse-poll-button',
        'requirements' => array(
        'no-subject',
        ),
    ),
);
