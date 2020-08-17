<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesspectromedia_Api_Menus extends Core_Api_Abstract {

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