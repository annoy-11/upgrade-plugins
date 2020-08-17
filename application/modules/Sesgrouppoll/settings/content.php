<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  array(
    'title' => 'SES - Group Polls Extension - Group Profile Polls',
    'description' => 'Displays a group\'s Polls on group profile page. The recommended page for this widget is "Group Profile Page".',
    'category' => 'SES - Group Polls Extension',
    'type' => 'widget',
    'name' => 'sesgrouppoll.profile-polls',
    'autoEdit' => true,
    'adminForm' => 'Sesgrouppoll_Form_Admin_Settings_Profilepolls',
  ),
 array(
    'title' => 'SES - Group Polls Extension - Browse Polls',
    'description' => 'Displays all polls on "SES - Group Polls Extension - Browse Polls Page" page.',
    'category' => 'SES - Group Polls Extension',
    'type' => 'widget',
    'name' => 'sesgrouppoll.browse-polls',
    'autoEdit' => true,
    'adminForm' => 'Sesgrouppoll_Form_Admin_Settings_Browsepolls',
  ),
array(
        'title' => 'SES - Group Polls Extension - Poll Profile - Breadcrumb for Poll View Page',
        'description' => 'Displays Breadcrumb for the Polls. This widget should be placed on "SES - Group Polls Extension - Poll View Page".',
        'category' => 'SES - Group Polls Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesgrouppoll.breadcrumb',
    ),
	array(
		'title' => 'SES - Group Polls Extension - Poll Profile - Poll Details & Information',
        'description' => 'Displays details and information about the poll on the "SES - Group Polls Extension - Poll View Page".',
        'category' => 'SES - Group Polls Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesgrouppoll.view-poll',
		'adminForm' => 'Sesgrouppoll_Form_Admin_Settings_Viewpage',
	),

  array(
    
    'title' => 'SES - Group Polls Extension - Popular Polls',
    'description' => 'Displays popular polls based on chosen popularity criteria. Edit this widget to configure the criteria and other settings.',
    'category' => 'SES - Group Polls Extension',
    'type' => 'widget',
    'name' => 'sesgrouppoll.list-popular-polls',
    'adminForm' => 'Sesgrouppoll_Form_Admin_Settings_Popularpolls',
		'autoEdit' => true,
  ),
  array(
		'title' => 'SES - Group Polls Extension - Tabbed widget for Popular Group Polls',
        'description' => 'Displays a tabbed widget for popular polls on your website based on various popularity criterias. Edit this widget to configure various settings. This widget can be placed anywhere on your website.',
        'category' => 'SES - Group Polls Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesgrouppoll.tabbed-widget-poll',
        'adminForm' => 'Sesgrouppoll_Form_Admin_Settings_TabbedWidget',
    ),
  array(
    
    'title' => 'SES - Group Polls Extension - Poll Browse Search',
    'description' => 'Displays a search form in the poll browse page.',
      'category' => 'SES - Group Polls Extension',
    'type' => 'widget',
    'name' => 'sesgrouppoll.browse-search',
    'requirements' => array(
      'no-subject',
    ),
  ),
array(
	'title' => 'SES - Group Polls Extension - Browse Polls Page Button',
    'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Group Polls Extension - Browse polls Page".',
    'category' => 'SES - Group Polls Extension',
    'type' => 'widget',
    'name' => 'sesgrouppoll.browse-poll-button',
    'requirements' => array(
      'no-subject',
    ),
  ),
) ?>