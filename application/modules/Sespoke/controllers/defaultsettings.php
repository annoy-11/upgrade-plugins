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
$widgetOrder = 1;
//Poke Page
$page_id = $db->select()
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'sespoke_index_index')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (!$page_id) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'sespoke_index_index',
      'displayname' => 'SES - Advanced Poke, Wink, Slap, etc & Gifts - Poke Page',
      'title' => 'Poke Page',
      'description' => 'This page is the poke page.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1
  ));
  $top_id = $db->lastInsertId();
  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2
  ));
  $main_id = $db->lastInsertId();
  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 6
  ));
  $main_middle_id = $db->lastInsertId();
  // Insert main-left
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'left',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 4,
  ));
  $main_left_id = $db->lastInsertId();
  // Insert main-right
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'right',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 5,
  ));
  $main_right_id = $db->lastInsertId();

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Top Pokers","showType":"0","action":"Poke","popularity":"top","itemCount":"5","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Top Winker","showType":"0","action":"Wink","popularity":"top","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Top Caller","showType":"1","action":"Call","popularity":"top","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Top Hugger","showType":"0","action":"Hug","popularity":"top","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_left_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Suggested Hugs","action":"Hug","itemCount":"4","nomobile":"0","name":"sespoke.suggestions"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.back-button',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"","showType":"1","viewMore":"1","itemCount":"10","nomobile":"0","name":"sespoke.back-button"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Poke Suggestions","action":"Poke","itemCount":"4","nomobile":"0","name":"sespoke.suggestions"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Suggested Call to Send","action":"Call","itemCount":"4","nomobile":"0","name":"sespoke.suggestions"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Suggested Winks","action":"Wink","itemCount":"4","nomobile":"0","name":"sespoke.suggestions"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Suggested High Fives","action":"High five","itemCount":"4","nomobile":"0","name":"sespoke.suggestions"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Suggested Kisses to Send","action":"Kiss","itemCount":"4","nomobile":"0","name":"sespoke.suggestions"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.suggestions',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Recent Hug Senders","showType":"1","action":"Hug","popularity":"recent","itemCount":"5","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Recent Poker","showType":"0","action":"Poke","popularity":"recent","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Recent Gift Sender","showType":"0","action":"Gift","popularity":"recent","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Recent Caller","showType":"0","action":"Call","popularity":"recent","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Recent Star Senders","showType":"0","action":"Star","popularity":"top","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));

  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sespoke.recent-top',
      'page_id' => $page_id,
      'parent_content_id' => $main_right_id,
      'order' => $widgetOrder++,
      'params' => '{"title":"Top Cake Senders","showType":"0","action":"Cake","popularity":"top","itemCount":"3","nomobile":"0","name":"sespoke.recent-top"}'
  ));
}

$select = new Zend_Db_Select($db);
$select->from('engine4_core_content', 'content_id')
        ->where('name = ?', 'left')
        ->where('page_id = ?', '5');
$infoId = $select->query()->fetchColumn();
if (!empty($infoId)) {
  $db->insert('engine4_core_content', array(
      'name' => 'sespoke.button',
      'page_id' => 5,
      'type' => 'widget',
      'params' => '{"title":"Take Action or Gift","showIconText":"1","nomobile":"0","name":"sespoke.button"}',
      'parent_content_id' => $infoId,
      'order' => 3,
  ));
}

$select = new Zend_Db_Select($db);
$select->from('engine4_core_content', 'content_id')
        ->where('name = ?', 'right')
        ->where('page_id = ?', '4');
$rightId = $select->query()->fetchColumn();
if (!empty($rightId)) {
  $db->insert('engine4_core_content', array(
      'name' => 'sespoke.back-button',
      'page_id' => 4,
      'type' => 'widget',
      'params' => '{"title":"","showType":"0","viewMore":"1","itemCount":"5","nomobile":"0","name":"sespoke.back-button"}',
      'parent_content_id' => $rightId,
      'order' => 1,
  ));
}

//Default Instalation Work For manageactions Tab in admin panel
$PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sespoke' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "action_icons" . DIRECTORY_SEPARATOR;
$tableManageActionsTable = Engine_Api::_()->getDbtable('manageactions', 'sespoke');
$select = $tableManageActionsTable->select()->from($tableManageActionsTable->info('name'), array('manageaction_id', 'icon', 'name'));
$results = $tableManageActionsTable->fetchAll($select);
foreach ($results as $result) {
  if ($result->name == 'High five') {
    $actionGiftIconName = 'high.png';
  } else {
    $actionGiftIconName = lcfirst($result->name) . '.png';
  }
  $catFileId = $this->setPokeIcon($PathFile . $actionGiftIconName, $result->manageaction_id);
  $db->query("UPDATE `engine4_sespoke_manageactions` SET `icon` = '" . $catFileId . "' WHERE manageaction_id = " . $result->manageaction_id);
}


$db->query("ALTER TABLE `engine4_sespoke_manageactions` ADD `image` INT(11) NOT NULL;");

$db->query('UPDATE `engine4_activity_actiontypes` SET `shareable` = "0" WHERE `engine4_activity_actiontypes`.`module` = "sespoke";');