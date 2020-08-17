<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
return array(
  array(
	'title' => 'SES - Page Polls Extension - Page Profile Polls',
    'description' => 'Displays a Page\'s Polls on its profile page. The recommended page for this widget is "Page Profile Page".',
    'category' => 'SES - Page Polls Extension',
    'type' => 'widget',
    'name' => 'sespagepoll.profile-polls',
    'autoEdit' => true,
    'adminForm' => 'Sespagepoll_Form_Admin_Settings_Profilepolls',
  ),
 array(
	'title' => 'SES - Page Polls Extension - Browse Polls',
    'description' => 'Displays all polls on "SES - Page Polls Extension - Browse Polls Page" page.',
    'category' => 'SES - Page Polls Extension',
    'type' => 'widget',
    'name' => 'sespagepoll.browse-polls',
    'autoEdit' => true,
    'adminForm' => 'Sespagepoll_Form_Admin_Settings_Browsepolls',
  ),
  array(
		'title' => 'SES - Page Polls Extension - Poll Profile - Breadcrumb for Poll View Page',
        'description' => 'Displays Breadcrumb for the Polls. This widget should be placed on "SES - Page Polls Extension - Poll View Page".',
        'category' => 'SES - Page Polls Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sespagepoll.breadcrumb',
    ),
	array(
		'title' => 'SES - Page Polls Extension - Poll Profile - Poll Details & Information',
        'description' => 'Displays details and information about the poll on the "SES - Page Polls Extension - Poll View Page".',
        'category' => 'SES - Page Polls Extension',
        'autoEdit' => true,
        'type' => 'widget',
        'name' => 'sespagepoll.view-poll',
		'adminForm' => 'Sespagepoll_Form_Admin_Settings_Viewpage',
	),
  array(
	'title' => 'SES - Page Polls Extension - Popular Polls',
    'description' => 'Displays popular polls based on chosen popularity criteria. Edit this widget to configure the criteria and other settings.',
	'category' => 'SES - Page Polls Extension',
    'type' => 'widget',
    'name' => 'sespagepoll.list-popular-polls',
    'adminForm' => 'Sespagepoll_Form_Admin_Settings_Popularpolls',
		'autoEdit' => true,
  ),
  array(
		'title' => 'SES - Page Polls Extension - Tabbed widget for Popular Page Polls',
        'description' => 'Displays a tabbed widget for popular polls on your website based on various popularity criterias. Edit this widget to configure various settings. This widget can be placed anywhere on your website.',
        'category' => 'SES - Page Polls Extension',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagepoll.tabbed-widget-poll',
        'adminForm' => 'Sespagepoll_Form_Admin_Settings_TabbedWidget',
    ),
  array(
	'title' => 'SES - Page Polls Extension - Poll Browse Search',
    'description' => 'Displays a search form in the poll browse page.',
    'category' => 'SES - Page Polls Extension',
    'type' => 'widget',
    'name' => 'sespagepoll.browse-search',
    'requirements' => array(
      'no-subject',
    ),
  ),
  array(
	'title' => 'SES - Page Polls Extension - Browse Polls Page Button',
    'description' => 'This widget displays a button clicking on which users will be redirected to the "SES - Page Polls Extension - Browse Polls Page".',
    'category' => 'SES - Page Polls Extension',
    'type' => 'widget',
    'name' => 'sespagepoll.browse-poll-button',
    'requirements' => array(
      'no-subject',
    ),
  ),
) ?>
