<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$page_table = Engine_Api::_()->getDbtable('pages', 'core');
$page_table_name = $page_table->info('name');

$content_table = Engine_Api::_()->getDbtable('content', 'core');
$content_table_name = $content_table->info('name');

$select = new Zend_Db_Select($db);
$page_id = $select
        ->from('engine4_core_pages', 'page_id')
        ->where('name = ?', 'user_profile_index')
        ->query()
        ->fetchColumn();
if ($page_id) {
  $top_contanier_id = $content_table->select()
          ->from($content_table_name, 'content_id')
          ->where('page_id =?', $page_id)
          ->where('name =?', 'top')
          ->query()
          ->fetchColumn();
  //Check top container id
  if (empty($top_contanier_id)) {
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'parent_content_id' => NULL,
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
    ));
    //get Last insert Id of top container
    $content_id = $db->lastInsertId('engine4_core_content');
    $middle_contanier_id = $content_table->select()
            ->from($content_table_name, 'content_id')
            ->where('page_id =?', $page_id)
            ->where('parent_content_id =?', $content_id)
            ->where('name =?', 'middle')
            ->query()
            ->fetchColumn();
    if (empty($middle_contanier_id)) {
      $db->insert('engine4_core_content', array(
          'type' => 'container',
          'name' => 'middle',
          'page_id' => $page_id,
          'parent_content_id' => $content_id,
          'order' => 2,
      ));
      $content_id = $db->lastInsertId('engine4_core_content');
      if (!empty($content_id)) {
        $usercoverphotowidgetcontent_id = $content_table->select()
                ->from($content_table_name, array('content_id'))
                ->where('page_id =?', $page_id)
                ->where('name =?', 'sesusercoverphoto.sesusercoverphoto-cover')
                ->query()
                ->fetchColumn();
        if (empty($usercoverphotowidgetcontent_id)) {
          $db->insert('engine4_core_content', array(
            'type' => 'widget',
            'name' => 'sesusercoverphoto.sesusercoverphoto-cover',
            'page_id' => $page_id,
            'parent_content_id' => $content_id,
            'order' => 2,
          ));
        }
      }
    }
  }
  $db->query("UPDATE `engine4_core_content` SET  `order` =  '3' WHERE  `engine4_core_content`.`page_id` = $page_id AND `engine4_core_content`.`name` = 'main' LIMIT 1 ;");
}

$db->query('INSERT IGNORE INTO `engine4_authorization_permissions`
  SELECT
    level_id as `level_id`,
    "sesusercover" as `type`,
    "show_ver_tip" as `name`,
    1 as `value`,
    NULL as `params`
  FROM `engine4_authorization_levels` WHERE `type` IN("moderator", "admin");');
