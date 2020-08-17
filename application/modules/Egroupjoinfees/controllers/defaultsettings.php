<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Egroupjoinfees
 * @package    Egroupjoinfees
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2017-12-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
//My Order Page
// Check if it's already been placed
$select = new Zend_Db_Select($db);
$hasWidget = $select
        ->from('engine4_core_pages', new Zend_Db_Expr('TRUE'))
        ->where('name = ?', 'egroupjoinfees_index_view')
        ->limit(1)
        ->query()
        ->fetchColumn();
        
// Add it
if (empty($hasWidget)) {
  // Insert page
  $db->insert('engine4_core_pages', array(
      'name' => 'egroupjoinfees_index_view',
      'displayname' => 'SES - Advanced Groups - My Orders',
      'title' => 'SES - Advanced Groups',
      'description' => 'This page is my order.',
      'custom' => 0,
  ));
  $page_id = $db->lastInsertId();
  // Insert top
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'top',
      'page_id' => $page_id,
      'order' => 1,
  ));
  $top_id = $db->lastInsertId();
  // Insert main
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'main',
      'page_id' => $page_id,
      'order' => 2,
  ));
  $main_id = $db->lastInsertId();
  // Insert top-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $top_id,
  ));
  $top_middle_id = $db->lastInsertId();
  // Insert main-middle
  $db->insert('engine4_core_content', array(
      'type' => 'container',
      'name' => 'middle',
      'page_id' => $page_id,
      'parent_content_id' => $main_id,
      'order' => 2,
  ));
  $main_middle_id = $db->lastInsertId();
  // Insert menu
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesgroup.browse-menu',
      'page_id' => $page_id,
      'parent_content_id' => $top_middle_id,
      'order' => 1,
  ));
  // Insert content
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'egroupjoinfees.browse-order',
      'page_id' => $page_id,
      'parent_content_id' => $main_middle_id,
      'order' => 2,
  ));
}
$db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
("egroupjoinfees_order", "egroupjoinfees", \'{item:$subject} has paid you for group {item:$object}.\', 0, "");');
$db->query("ALTER TABLE `engine4_egroupjoinfees_usergateways` ADD `gateway_type` VARCHAR(64) NULL DEFAULT 'paypal' AFTER `test_mode`;");
// $db->query('INSERT IGNORE INTO `engine4_activity_notificationtypes` (`type`, `module`, `body`, `is_request`, `handler`) VALUES
// ("egroupjoinfees_paymentrequest", "egroupjoinfees", \'{item:$subject} request payment {var:$requestAmount} for group {item:$object}.\', 0, ""),
// ("egroupjoinfees_adminpaymentcancel", "egroupjoinfees", \'{item:$subject} cancel your payment request for group {item:$object}.\', 0, ""),
// ("egroupjoinfees_adminpaymentapprove", "egroupjoinfees", \'{item:$subject} apporved your payment request for group {item:$object}.\', 0, "");');
$db->query("ALTER TABLE `engine4_egroupjoinfees_orders` ADD `credit_point` INT(11) NOT NULL DEFAULT '0', ADD `credit_value` FLOAT NOT NULL DEFAULT '0';");
$db->query("ALTER TABLE `engine4_egroupjoinfees_orders` ADD `ordercoupon_id` INT NULL DEFAULT '0';");
