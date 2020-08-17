<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmaterial_Api_Menus extends Core_Api_Abstract
{
  public function getMenus($params = array()) {

    $coreMenuItemsTable = Engine_Api::_()->getDbTable('menuitems', 'core');
    $coreMenuItemsTableName = $coreMenuItemsTable->info('name');
    $select = $coreMenuItemsTable->select()
            ->from($coreMenuItemsTableName, array('id', 'file_id', 'label'))
            ->where('enabled = ?', 1)
            ->where('menu = ?', $params['menu'])
            ->order('order ASC');
    return $coreMenuItemsTable->fetchAll($select);
  }

  public function getIconsMenu($menuName) {

    $table = Engine_Api::_()->getDbTable('menuitems', 'core');
    $menuId =  $table->select()
                    ->from($table, 'id')
                    ->where('name =?', $menuName)
                    ->query()
                    ->fetchColumn();
    if($menuId){
      $row = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menuId);
    if($row)
      return $row->icon_id;
    }
   return false;
  }
}
