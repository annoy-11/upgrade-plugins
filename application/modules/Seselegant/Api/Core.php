<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_Api_Core extends Core_Api_Abstract {

  public function getMenuIcon($menuName) {

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
  
  public function setPhoto($photo, $menuId = null) {

    //GET PHOTO DETAILS
    $mainName = dirname($photo['tmp_name']) . '/' . $photo['name'];

    //GET VIEWER ID
    $photo_params = array(
        'parent_id' => $menuId,
        'parent_type' => "seselegant_slideshow_image",
    );
    copy($photo['tmp_name'], $mainName);
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }

    return $photoFile;
  }

}