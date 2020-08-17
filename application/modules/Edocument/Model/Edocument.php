<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Document.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Model_Edocument extends Core_Model_Item_Abstract {

  //Properties
  protected $_parent_type = 'user';
  protected $_owner_type = 'user';
  protected $_parent_is_owner = true;
  protected $_searchTriggers = array('title', 'body', 'search');
  protected $_type = 'edocument';
  protected $_statusChanged;

  /**
  * Gets an absolute URL to the page to view this item
  *
  * @return string
  */
  public function getHref($params = array()) {
    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'edocument_entry_view',
      'reset' => true,
      'edocument_id' => $this->custom_url,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

  public function setFile($file) {

    if ($file instanceof Zend_Form_Element_File) {
        $file = $file->getFileName();
    } else if (is_array($file) && !empty($file['tmp_name'])) {
        $file = $file['tmp_name'];
    } else if (is_string($file) && file_exists($file)) {
        $file = $file;
    } else {
        throw new Edocument_Model_Exception('invalid argument passed to setFile');
    }
//     $params = array(
//         'parent_type' => 'edocument',
//         'parent_id' => $this->getIdentity()
//     );

    try {
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $storageObject = $storage->createFile($file, array(
          'parent_id' => $this->getIdentity(),
          'parent_type' => 'edocument',
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        // Remove temporary file
        @unlink($file['tmp_name']);

        //$edocument = Engine_Api::_()->storage()->create($file, $params);
    } catch (Exception $e) {
        throw $e;
        return $e->getMessage();
    }

    $this->modified_date = new Zend_Db_Expr('NOW()');
    $this->file_id = $storageObject->file_id;
    $this->file_type = $storageObject->extension;
    $this->save();
    return $storageObject;
  }

  public function setPhoto($photo,$direct = '') {

    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $name = basename($file);
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $name = basename($photo['name']);
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $name = basename($file);
    } else {
      throw new Edocument_Model_Exception('invalid argument passed to setPhoto');
    }

    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_id' => $this->getIdentity(),
        'parent_type' => 'edocument'
    );
    // Save
    $storage = Engine_Api::_()->storage();
    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(720, 720)
            ->write($path . '/m_' . $name)
            ->destroy();
    // Resize image (profile)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(500, 500)
            ->write($path . '/p_' . $name)
            ->destroy();
    // Resize image (normal)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(200, 200)
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
    $this->photo_id = $iMain->file_id;
    $this->save();
    return $this;
  }

  // Active
  public function setActive($flag = true, $deactivateOthers = null) {

    if( (true === $flag && null === $deactivateOthers) ||
        $deactivateOthers === true ) {
      $this->is_approved = 1;
    }
    $this->save();
    return $this;
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
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultPhoto = Zend_Registry::get('StaticBaseUrl').$settings->getSetting('edocument_default_photo', 'application/modules/Edocument/externals/images/nophoto_document_thumb_profile.png');
    return $defaultPhoto;
  }

  public function getDescription($limit = '255') {
     $body = $this->body;
     $stringArray  =  Engine_Api::_()->sesbasic()->get_string_between($this->body);
     foreach ($stringArray as $array){
         if($array){
             $body = str_replace("[".$array."]","",$body);
         }
     }
    // @todo decide how we want to handle multibyte string functions
    $ro = preg_replace('/\s+/', ' ',$body);
    $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));
    return nl2br( Engine_String::strlen($tmpBody) > $limit ? Engine_String::substr($tmpBody, 0, $limit) . '...' : $tmpBody );
  }

  public function fields() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getApi('core', 'fields'));
  }

  public function getKeywords($separator = ' ') {

    $keywords = array();
    foreach( $this->tags()->getTagMaps() as $tagmap ) {
      $tag = $tagmap->getTag();
      if($tag) {
        $keywords[] = $tag->getTitle();
      }
    }

    if( null === $separator ) {
      return $keywords;
    }
    return join($separator, $keywords);
  }


  // Interfaces

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   **/
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }


  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   **/
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }

  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   **/
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }
}
