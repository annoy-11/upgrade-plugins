<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  array(
	'title' => 'SES - Business Polls Extension - Business Profile Polls',
    'description' => 'Displays a Business\'s Polls on Business profile page. The recommended page for this widget is "Business Profile Page".',
    'category' => 'SES - Business Polls Extension',
    'type' => 'widget',
    'name' => 'sesbusinesspoll.profile-polls',
    'autoEdit' => true,
    'adminForm' => 'Sesbusinesspoll_Form_Admin_Settings_Profilepolls',
  ),
 array(
	'title' => 'SES - Business Polls Extension - Browse Polls',
    'description' => 'Browse Polls',
    'category' => 'SES - Business Polls',
    'type' => 'widget',
    'name' => 'sesbusinesspoll.browse-polls',
    'autoEdit' => true,
    'adminForm' => 'Sesbusinesspoll_Form_Admin_Settings_Browsepolls',
  ),
array(
		'title' => 'SES - Business Polls Extension - Poll Profile - Breadcrumb for Poll View Page',
        'description' => 'Displays Breadcrumb for the Polls. This widget should be placed on "Page - Poll View Page".',
        'category' => 'SES - Business Polls Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesbusinesspoll.breadcrumb',
    ),
	array(
		'title' => 'SES - Business Polls Extension - Poll View Page',
        'description' => 'Displays Breadcrumb for the Polls. This widget should be placed on "Page - Poll View Page".',
        'category' => 'SES - Business Polls Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sesbusinesspoll.view-poll',
		'adminForm' => 'Sesbusinesspoll_Form_Admin_Settings_Viewpage',
	),

  array(
    
    
	'title' => 'SES - Business Polls Extension - Popular Polls',
    'description' => 'Displays a list of popular polls.',
    'category' => 'SES - Business Polls',
    'type' => 'widget',
    'name' => 'sesbusinesspoll.list-popular-polls',
    'adminForm' => 'Sesbusinesspoll_Form_Admin_Settings_Popularpolls',
		'autoEdit' => true,
  ),
  array(
		'title' => 'SES - Business Polls Extension - Tabbed widget',
        'description' => 'This widget displays polls created, favourite, liked, etc by the member viewing the Home Poll. Edit this widget to configure various settings.',
        'category' => 'SES - Business Polls Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesbusinesspoll.tabbed-widget-poll',
        'adminForm' => 'Sesbusinesspoll_Form_Admin_Settings_TabbedWidget',
    ),
  array(
	'title' => 'SES - Business Polls Extension - Poll Browse Search',
    'description' => 'Displays a search form in the poll browse page.',
    'category' => 'SES - Business Polls Extension',
    'type' => 'widget',
    'name' => 'sesbusinesspoll.browse-search',
    'requirements' => array(
      'no-subject',
    ),
   
  ),
  array(
	'title' => 'SES - Business Polls Extension - Browse Polls Page Button',
    'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Business Polls Extension - Browse poll Page".',
    'category' => 'SES - Business Polls Extension',
    'type' => 'widget',
    'name' => 'sesbusinesspoll.browse-poll-button',
    'requirements' => array(
      'no-subject',
    ),
  ),
) ?>
