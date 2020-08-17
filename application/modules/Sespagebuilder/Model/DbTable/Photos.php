<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Photos.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Model_DbTable_Photos extends Engine_Db_Table {

  public function getPhotos($params = array(),$where) { 
    
    $select = $this->select();
    $select->where('photo_id =?' , $where);
    if(isset($params['column_name']))
      $select->from($this->info('name'), $params['column_name']);
    return $this->fetchAll($select);
  }
	
  public function getSpecificPhoto($content_id = ''){
    if($content_id != ''){
      $select = $this->select();
      $select->where('content_id =?',$content_id);	
      return $this->fetchAll($select);
    }
  }
	
  public function setPhoto($photo, $photo_id) {
    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if ($photo instanceof Storage_Model_File) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id)) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }

    if (!$fileName) {
      $fileName = basename($file);
    }

    $extension = ltrim(strrchr(basename($fileName), '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';

    $params = array(
        'parent_type' => 'sespagebuilder_photo',
        'parent_id' => $photo_id,
        'user_id' => 1,
        'name' => $fileName,
    );

    // Save
    $filesTable = Engine_Api::_()->getItemTable('storage_file');

    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(720, 720)
            ->write($mainPath)
            ->destroy();

    // Resize image (normal)
    $normalPath = $path . DIRECTORY_SEPARATOR . $base . '_in.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(140, 160)
            ->write($normalPath)
            ->destroy();

    // Store
    $iMain = $filesTable->createFile($mainPath, $params);
    $iIconNormal = $filesTable->createFile($normalPath, $params);

    $iMain->bridge($iIconNormal, 'thumb.normal');

    // Remove temp files
    @unlink($mainPath);
    @unlink($normalPath);

    Engine_Api::_()->getDbTable('photos', 'sespagebuilder')->update(array('file_id' => $iMain->file_id,'name'=>$fileName), array('photo_id = ?' => $photo_id));

    return $iMain->file_id;
  }

}