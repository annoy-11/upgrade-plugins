<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupteam
 * @package    Sesgroupteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//profile page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesgroup_profile_index_1')
            ->limit(1)
            ->query()
            ->fetchColumn();
$tab_id =  $db->select()
            ->where('type = ?', 'widget')
            ->from('engine4_core_content', 'content_id')
            ->where('name = ?', 'core.container-tabs')
            ->where('page_id = ?', $page_id)
            ->limit(1)
            ->query()
            ->fetchColumn();
// insert if it doesn't exist yet
if ($page_id) {
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesgroupteam.team',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => 35,
    'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sesgroupteam.team"}',
    ));
}

// profile page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesgroup_profile_index_2')
            ->limit(1)
            ->query()
            ->fetchColumn();
$tab_id =  $db->select()
                ->where('type = ?', 'widget')
                ->from('engine4_core_content', 'content_id')
                ->where('name = ?', 'core.container-tabs')
                ->where('page_id = ?', $page_id)
                ->limit(1)
                ->query()
                ->fetchColumn();
// insert if it doesn't exist yet
if ($page_id){
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesgroupteam.team',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => 35,
    'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sesgroupteam.team"}',
    ));
}
// profile page
$page_id = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'sesgroup_profile_index_3')
            ->limit(1)
            ->query()
            ->fetchColumn();
$tab_id =  $db->select()
                ->where('type = ?', 'widget')
                ->from('engine4_core_content', 'content_id')
                ->where('name = ?', 'core.container-tabs')
                ->where('page_id = ?', $page_id)
                ->limit(1)
                ->query()
                ->fetchColumn();
if ($page_id){
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesgroupteam.team',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => 35,
    'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sesgroupteam.team"}',
    ));
}

// profile page
$page_id = $db->select()
                ->from('engine4_core_pages', 'page_id')
                ->where('name = ?', 'sesgroup_profile_index_4')
                ->limit(1)
                ->query()
                ->fetchColumn();
$tab_id =  $db->select()
            ->where('type = ?', 'widget')
            ->from('engine4_core_content', 'content_id')
            ->where('name = ?', 'core.container-tabs')
            ->where('page_id = ?', $page_id)
            ->limit(1)
            ->query()
            ->fetchColumn();
if ($page_id){
    $db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesgroupteam.team',
    'page_id' => $page_id,
    'parent_content_id' => $tab_id,
    'order' => 35,
    'params' => '{"sesteam_template":"1","sesteam_contentshow":["displayname","photo","designation","description","email","phone","location","website","facebook","linkdin","twitter","googleplus","viewMore"],"deslimit":"100","viewMoreText":"View Details","height":"200","width":"200","center_block":"1","center_description":"1","title":"Teams","nomobile":"0","name":"sesgroupteam.team"}',
    ));
}

//Group Team View Group
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sesgroupteam_index_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sesgroupteam_index_view',
      'displayname' => 'SES - Group Team Showcase Extension - Group Team Profile Group',
      'title' => 'Group Team View Group',
      'description' => 'This is the page team profile page.',
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
    'name' => 'sesgroupteam.viewgroup-team',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"infoshow":["featured","sponsored","profilePhoto","displayname","designation","description","detaildescription","email","phone","location","website","facebook","linkdin","twitter","googleplus"],"title":"","nomobile":"0","name":"sesgroupteam.viewgroup-team"}',
  ));
}
