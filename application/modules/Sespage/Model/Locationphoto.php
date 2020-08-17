<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Locationphoto.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_Locationphoto extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  public function setPhoto($photo, $isShareContent = false) {
    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
    } elseif (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
       $fileName = $photo['name'];
    } elseif (is_string($photo) && file_exists($photo)) {
      $file = $photo;
    } else {
      throw new Sespage_Model_Exception('Invalid argument passed to setPhoto: ' . print_r($photo, 1));
    }

    $name = basename($fileName);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sespage_locationphoto',
        'parent_id' => $this->getIdentity()
    );

    $core_settings = Engine_Api::_()->getApi('settings', 'core');
    $main_height = $core_settings->getSetting('sespage.mainheight', 1600);
    $main_width = $core_settings->getSetting('sespage.mainwidth', 1600);
    $normal_height = $core_settings->getSetting('sespage.normalheight', 500);
    $normal_width = $core_settings->getSetting('sespage.normalwidth', 500);

    // Save
    $storage = Engine_Api::_()->storage();

    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize($main_width, $main_height)
            ->write($path . '/m_' . $name)
            ->destroy();

    // Resize image (profile)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize($normal_width, $normal_height)
            ->write($path . '/p_' . $name)
            ->destroy();

    // Resize image (normal)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize($normal_width, $normal_height)
            ->write($path . '/in_' . $name)
            ->destroy();

    // Resize image (icon)
    $image = Engine_Image::factory();
    $image->open($file);

    $size = min($image->height, $image->width);
    $x = ($image->width - $size) / 2;
    $y = ($image->height - $size) / 2;

    $image->resample($x, $y, $size, $size, 48, 48)
            ->write($path . '/is_' . $name)
            ->destroy();

    // Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    $iProfile = $storage->create($path . '/p_' . $name, $params);
    $iIconNormal = $storage->create($path . '/in_' . $name, $params);
    $iSquare = $storage->create($path . '/is_' . $name, $params);

    $iMain->bridge($iProfile, 'thumb.profile');
    $iMain->bridge($iIconNormal, 'thumb.normal');
    $iMain->bridge($iSquare, 'thumb.icon');

    // Remove temp files
    @unlink($path . '/p_' . $name);
    @unlink($path . '/m_' . $name);
    @unlink($path . '/in_' . $name);
    @unlink($path . '/is_' . $name);

    // Update row
    $this->modified_date = date('Y-m-d H:i:s');
    if ($isShareContent == false)
      $this->locationphoto_id = $iMain->getIdentity();
    $this->save();

    return $this;
  }

  public function getPhotoUrl($type = NULL) {
    $photo_id = $this->locationphoto_id;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->locationphoto_id, $type);
      if ($file)
        return $file->map();
      else {
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->locationphoto_id, 'thumb.profile');
        if ($file)
          return $file->map();
      }
    }
    $defaultPhoto = 'application/modules/Sespage/externals/images/nophoto_page_thumb_profile.png';
    return $defaultPhoto;
  }

}
