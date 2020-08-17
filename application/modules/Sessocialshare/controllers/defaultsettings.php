<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$content_id = $this->widgetCheck(array('widget_name' => 'sessocialshare.bottom-share-popup', 'page_id' => '1'));
$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('page_id = ?', '1')
        ->where('name = ?', 'main')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (empty($content_id)) {
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sessocialshare.bottom-share-popup',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 25,
      'params' => '{"description":"Share this page with your family and friends.","position":"1","socialshare_enable_plusicon":"1","socialshare_icon_limit":"3","showCount":"0","showminimumnumber":"100","showtotalshare":"1","title":"Share This Page","nomobile":"0","name":"sessocialshare.bottom-share-popup"}',
  ));
}
$content_id = $this->widgetCheck(array('widget_name' => 'sessocialshare.sidebar-social-share', 'page_id' => '2'));
$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('page_id = ?', '2')
        ->where('name = ?', 'main')
        ->limit(1)
        ->query()
        ->fetchColumn();
if (empty($content_id)) {
  $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'sessocialshare.sidebar-social-share',
      'page_id' => 1,
      'parent_content_id' => $parent_content_id,
      'order' => 25,
      'params' => '{"position":"2","socialshare_enable_plusicon":"1","socialshare_icon_limit":"5","showCount":"1","showTitleTip":"1","title":"","nomobile":"0","name":"sessocialshare.sidebar-social-share"}',
  ));
}
$db->query('UPDATE `engine4_core_menuitems` SET `label` = "Sharing of Site Content in Feeds" WHERE `engine4_core_menuitems`.`name` = "sessocialshare_admin_main_managemodule";');