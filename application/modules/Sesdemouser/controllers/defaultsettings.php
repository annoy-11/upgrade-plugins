<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdemouser
 * @package    Sesdemouser
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'widget')
        ->where('name = ?', 'sesdemouser.demo-users')
        ->limit(1)
        ->query()
        ->fetchColumn();

$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('name = ?', 'main')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (empty($content_id)) {
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sesdemouser.demo-users',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 20,
  ));
}