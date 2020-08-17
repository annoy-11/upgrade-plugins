<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Api_Core extends Core_Api_Abstract {

  public function setPhoto($photo, $menuId = null) {

    //GET PHOTO DETAILS
    $mainName = dirname($photo['tmp_name']) . '/' . $photo['name'];

    //Params
    $photo_params = array(
        'parent_id' => $menuId,
        'parent_type' => "sesprofilelock_slideshow_image",
    );

    //RESIZE IMAGE WORK
    $image = Engine_Image::factory();
    $image->open($photo['tmp_name']);
    $image->open($photo['tmp_name'])
            ->resample(0, 0, $image->width, $image->height, $image->width, $image->height)
            ->write($mainName)
            ->destroy();

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

  public function getUsers() {

    $table = Engine_Api::_()->getDbtable('users', 'user');
    $select = $table->select()
            ->from($table->info('name'), array('user_id', 'view_count', 'member_count'))
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            ->order('view_count DESC');
    return Zend_Paginator::factory($select);
  }

  public function getUserData($params = array()) {

    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $userTableName = $userTable->info('name');
    $select = $userTable->select()
            ->from($userTableName, array('user_id', 'salt'))
            ->where($userTableName . '.email = ?', $params['email']);
    return $userTable->fetchRow($select);
  }

}
