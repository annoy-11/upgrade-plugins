<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingteam
 * @package    Sescrowdfundingteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Crowdfunding Team View Crowdfunding
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sescrowdfundingteam_index_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  $widgetOrder = 1;
  //Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sescrowdfundingteam_index_view',
      'displayname' => 'SES - Crowdfunding Team Showcase Extension - Crowdfunding Team Profile Page',
      'title' => 'Crowdfunding Team View Page',
      'description' => 'This is the crowdfunding team profile page.',
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
    'name' => 'sescrowdfundingteam.viewcrowdfunding-team',
    'page_id' => $page_id,
    'parent_content_id' => $main_middle_id,
    'order' => $widgetOrder++,
    'params' => '{"infoshow":["featured","sponsored","profilePhoto","displayname","designation","description","detaildescription","email","phone","location","website","facebook","linkdin","twitter","googleplus"],"title":"","nomobile":"0","name":"sescrowdfundingteam.viewcrowdfunding-team"}',
  ));
}
