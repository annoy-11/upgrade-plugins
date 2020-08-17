<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesteam_index_team')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesteam_index_team',
      'displayname' => 'Team Showcase - Site Team Members Home Page',
      'title' => 'Site Team Members Home',
      'description' => 'This is the site team members home page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.team-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteam_teampage_description":"Team Showcase & Multi-Use Team Plugin helps you to create team members with their short descriptions, social profiles link with smooth hover effects and many more. You can add and manage their image, social profile’s links, short description, detailed description or testimonial along with their name and position in your company.","sesteam_type":"teammember","sesteam_template":"2","designation_id":"0","popularity":"","sesteam_contentshow":["featured","sponsored","displayname","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"viewMoreText":"View Details","sesteam_social_border":"1","title":"Meet Team","nomobile":"0","name":"sesteam.team-page"}',
  ));

  //Insert gutter menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteamType":"teammember","viewType":"horizontal","title":"","nomobile":"0","name":"sesteam.search"}',
  ));
}

//Non Site Team Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesteam_index_nonsiteteam')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesteam_index_nonsiteteam',
      'displayname' => 'Team Showcase - Non-Site Team Members Home Page',
      'title' => 'Non-Site Team Members Home Page',
      'description' => 'This is the browse non-site team members home page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.team-page',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Meet Team","sesteam_type":"nonsitemember","sesteam_template":"1","designation_id":"0","popularity":"","sesteam_contentshow":["featured","sponsored","displayname","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"viewMoreText":"View Details","sesteam_social_border":"1","title":"","nomobile":"0","name":"sesteam.team-page"}',
  ));

  //Insert gutter menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteamType":"nonsitemember","viewType":"horizontal","title":"","nomobile":"0","name":"sesteam.search"}',
  ));
}


//Non Site Team Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesteam_index_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesteam_index_view',
      'displayname' => 'Team Showcase - Non-Site Team Member Profile Page',
      'title' => 'Non-Site Team Member Profile',
      'description' => 'This is the non site team member profile page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();


  //Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.profile-nonsiteteam',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"infoshow":["featured","sponsored","profilePhoto","displayname","designation","description","detaildescription","email","phone","location","website","facebook","linkdin","twitter","googleplus"],"title":"","nomobile":"0","name":"sesteam.profile-nonsiteteam"}',
  ));
}

//Browse Team Member
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesteam_index_browse')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesteam_index_browse',
      'displayname' => 'Team Showcase - Browse Site Team Members Page',
      'title' => 'Browse Site Team Members',
      'description' => 'This is the browse site team members page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.browse-team',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteam_type":"teammember","sesteam_template":"2","designation_id":"0","popularity":"","sesteam_contentshow":["featured","sponsored","displayname","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"viewMoreText":"View Details","sesteam_social_border":"1","title":"Meet Team","nomobile":"0","name":"sesteam.team-page"}',
  ));

  //Insert gutter menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteamType":"teammember","viewType":"horizontal","title":"","nomobile":"0","name":"sesteam.search"}',
  ));
}


//Browse Non Site Team Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesteam_index_browsenonsiteteam')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesteam_index_browsenonsiteteam',
      'displayname' => 'Team Showcase - Browse Non-Site Team Members Page',
      'title' => 'Browse Non-Site Team Members Page',
      'description' => 'This is the browse non-site team members page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();

  //Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();

  //Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();

  //Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();

  //Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 1,
  ));
  $main_right_id = $db->lastInsertId();

  //Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.browse-team',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteam_type":"nonsitemember","sesteam_template":"1","designation_id":"0","popularity":"","sesteam_contentshow":["featured","sponsored","displayname","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"viewMoreText":"View Details","sesteam_social_border":"1","title":"","nomobile":"0","name":"sesteam.team-page"}',
  ));

  //Insert gutter menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesteam.search',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"sesteamType":"nonsitemember","viewType":"horizontal","title":"","nomobile":"0","name":"sesteam.search"}',
  ));
}


$select = new Zend_Db_Select($db);
$level_id = array('1', '2');
$select->from('engine4_users', array('user_id', 'displayname', 'email'))
        ->where('user_id IN (?)', (array) $level_id);
$users = $select->query()->fetchAll();
foreach ($users as $user) {
  $db->query('INSERT IGNORE INTO `engine4_sesteam_teams` (`user_id`, `name`, `designation_id`, `designation`, `description`, `detail_description`, `email`, `location`, `phone`, `website`, `skype`, `facebook`, `twitter`, `linkdin`, `googleplus`, `enabled`, `featured`, `sponsored`, `offtheday`, `starttime`, `endtime`, `type`, `photo_id`, `order`) VALUES ("' . $user['user_id'] . '", "' . $user['displayname'] . '", 0, NULL, "", "", "' . $user['email'] . '", "", "9999999999", "example.com", NULL, "facebook.com", "twitter.com", "linkedin.com", "", 1, 0, 0, 0, "", "", "teammember", 0, 1);');
}
