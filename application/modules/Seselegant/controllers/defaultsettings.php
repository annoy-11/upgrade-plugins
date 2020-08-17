<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();

//Header Default Work
$minimenuContent_id = $this->widgetCheck(array('widget_name' => 'seselegant.menu-mini', 'page_id' => '1'));
$menumainContent_id = $this->widgetCheck(array('widget_name' => 'seselegant.menu-main', 'page_id' => '1'));
$search_id = $this->widgetCheck(array('widget_name' => 'seselegant.search', 'page_id' => '1'));
$customBrowseMenu = $this->widgetCheck(array('widget_name' => 'seselegant.custom-browse-menu', 'page_id' => '1'));

$minimenu = $this->widgetCheck(array('widget_name' => 'core.menu-mini', 'page_id' => '1'));
$mainmenu = $this->widgetCheck(array('widget_name' => 'core.menu-main', 'page_id' => '1'));
$search = $this->widgetCheck(array('widget_name' => 'core.search-mini', 'page_id' => '1'));

$parent_content_id = $db->select()
				->from('engine4_core_content', 'content_id')
				->where('type = ?', 'container')
				->where('page_id = ?', '1')
				->where('name = ?', 'main')
				->limit(1)
				->query()
				->fetchColumn();
if (empty($menumainContent_id)) {
    if($search)
        $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$search.'";');
	if($mainmenu)
		$db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$mainmenu.'";');
	$db->insert('engine4_core_content', array(
			'type' => 'widget',
			'name' => 'seselegant.menu-main',
			'page_id' => 1,
			'parent_content_id' => $parent_content_id,
			'order' => 20,
			'params' => '{"seselegant_main_navigation":"4","show_main_menu":"1","title":"","nomobile":"0","name":"seselegant.menu-main"}',
	));
}
if (empty($search_id)) {
	$db->insert('engine4_core_content', array(
			'type' => 'widget',
			'name' => 'seselegant.search',
			'page_id' => 1,
			'parent_content_id' => $parent_content_id,
			'order' => 21,
	));
}
if (empty($minimenuContent_id)) {
	if($minimenu)
		$db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$minimenu.'";');
	$db->insert('engine4_core_content', array(
			'type' => 'widget',
			'name' => 'seselegant.menu-mini',
			'page_id' => 1,
			'parent_content_id' => $parent_content_id,
			'order' => 22,
	));
}

if (empty($customBrowseMenu)) {
	$db->insert('engine4_core_content', array(
			'type' => 'widget',
			'name' => 'seselegant.custom-browse-menu',
			'page_id' => 1,
			'parent_content_id' => $parent_content_id,
			'order' => 23,
	));
}


//Footer Default Work
$footerContent_id = $this->widgetCheck(array('widget_name' => 'seselegant.menu-footer', 'page_id' => '2'));
$footerMenu = $this->widgetCheck(array('widget_name' => 'core.menu-footer', 'page_id' => '2'));
$parent_content_id = $db->select()
				->from('engine4_core_content', 'content_id')
				->where('type = ?', 'container')
				->where('page_id = ?', '2')
				->where('name = ?', 'main')
				->limit(1)
				->query()
				->fetchColumn();
if (empty($footerContent_id)) {
	if($footerMenu)
		$db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$footerMenu.'";');

	$db->insert('engine4_core_content', array(
			'type' => 'widget',
			'name' => 'seselegant.menu-footer',
			'page_id' => 2,
			'parent_content_id' => $parent_content_id,
			'order' => 10,
	));
}

//Update Mini Menu
// $db->update('engine4_core_menuitems', array('order' => 5), array('name = ?' => 'core_mini_profile'));
// $db->update('engine4_core_menuitems', array('order' => 8), array('name = ?' => 'core_mini_notification'));
// $db->update('engine4_core_menuitems', array('order' => 7), array('name = ?' => 'core_mini_messages'));
// $db->update('engine4_core_menuitems', array('order' => 6), array('name = ?' => 'core_mini_friends'));
// $db->update('engine4_core_menuitems', array('order' => 4), array('name = ?' => 'core_mini_settings'));
// $db->update('engine4_core_menuitems', array('order' => 3), array('name = ?' => 'core_mini_admin'));
// $db->update('engine4_core_menuitems', array('order' => 2), array('name = ?' => 'core_mini_auth'));
// $db->update('engine4_core_menuitems', array('order' => 1), array('name = ?' => ' 	core_mini_signup'));

$db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES ("seselegant_admin_main_minimenu", "seselegant", "Mini Menu", "", \'{"route":"admin_default","module":"seselegant","controller":"menu"}\', "seselegant_admin_main", "", 3);');
