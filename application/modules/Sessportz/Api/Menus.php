<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Api_Menus extends Core_Api_Abstract
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

    $coreMenuItemsTable = Engine_Api::_()->getDbTable('menuitems', 'core');
    $coreMenuItemsTableName = $coreMenuItemsTable->info('name');
    return $coreMenuItemsTable->select()
                    ->from($coreMenuItemsTableName, 'file_id')
                    ->where('name =?', $menuName)
                    ->query()
                    ->fetchColumn();
  }

}
