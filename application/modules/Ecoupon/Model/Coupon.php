<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Coupon.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Model_Coupon extends Core_Model_Item_Abstract
{
  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_type = 'coupon';
  
  public function getHref($params = array()) {
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'ecoupon_profile',
      'reset' => true,
      'subject'=> $this->getItemType(),
      'coupon_id'=> $this->coupon_id,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()
      ->assemble($params, $route, $reset);
  }
  public function getItemType() {
    if($this->item_type == '' && empty($this->item_type))
      return $this->resource_type;
    else 
      return $this->item_type;
  }
  public function getItemId() {
    if($this->is_package)
      return $this->coupon_id;
    else 
      return $this->resource_id;
  }
  public function getItemTitle($itemType) {
    $table = Engine_Api::_()->getItemTable('ecoupon_type');
    $itemTableName = $table->info('name');
    return $table->select()
                    ->from($itemTableName,array('title'))
                    ->where("(`{$itemTableName}`.`item_type` LIKE ?)", "%{$itemType}%")
                    ->query()
                    ->fetchColumn();
  }
  public function getPhotoUrl($type = null) { 
    $photo_id = $this->photo_id;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, $type);
			if($file)
      	return $file->map();
			else{
				$file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id,'thumb.profile');
				if($file)
					return $file->map();
			}
    }
    $defaultPhoto = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->getItem('user', $this->owner_id), 'ecoupon', 'bsdefaultphoto');
    if(!$defaultPhoto){
      $defaultPhoto = Zend_Registry::get('StaticBaseUrl'). 'application/modules/Ecoupon/externals/images/img.jpg';
    }
    return $defaultPhoto;
  }
}
