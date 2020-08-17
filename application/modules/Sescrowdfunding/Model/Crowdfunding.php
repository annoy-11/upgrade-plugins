<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Crowdfunding.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Model_Crowdfunding extends Core_Model_Item_Abstract {

    protected $_type = 'crowdfunding';
  public function getPhotoUrl($type = NULL) {

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
    $defaultPhoto = 'application/modules/Sescrowdfunding/externals/images/nophoto_sescf_thumb_profile.png';
    return $defaultPhoto;
  }

  public function getRichContent($view = false, $params = array()) {

    $crowdfundingContent = '';
    if (!$view) {
      $desc = strip_tags($this->description);
      $desc = "<div class='sesmusic_feed_desc'>" . (Engine_String::strlen($desc) > 255 ? Engine_String::substr($desc, 0, 255) . '...' : $desc) . "</div>";
      $view = Zend_Registry::get('Zend_View');
      $view->crowdfunding = $this;
      //$view->songs = $this->getSongs();
      //$view->short_player = true;
      $view->hideStats = true;
      $crowdfundingContent = $view->render('application/modules/Sescrowdfunding/views/scripts/_Crowdfunding.tpl');
    }
    return $crowdfundingContent;
  }

    public function getMediaType() {
        return "crowdfunding";
    }


    public function getShortType($inflect=false) {
        if ($inflect)
            return 'Crowdfunding';
        return 'crowdfunding';
    }

	public function getTitle(){
		return $this->title;
	}

  public function getDescription() {
    return $this->short_description;
  }
  /**
   * Gets an absolute URL to the page to view this item
   *
   * @return string
   */
  public function getHref($params = array()) {

    $slug = $this->getSlug();
    $params = array_merge(array(
      'route' => 'sescrowdfunding_entry_view',
      'reset' => true,
      'crowdfunding_id' => $this->custom_url,
    ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    return Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
  }

  public function setBackgroundPhoto($photo) {

    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $name = $photo->getFileName();
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $name = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $name = $photo;
    } else {
      throw new Sescrowdfunding_Model_Exception('invalid argument passed to setPhoto');
    }
    $name = basename($name);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_id' => $this->getIdentity(),
        'parent_type' => 'crowdfunding'
    );

    // Save
    $storage = Engine_Api::_()->storage();
    // Resize image (main)
    copy($file, $path . '/m_' . $name);
    // Store
    $iMain = $storage->create($path . '/m_' . $name, $params);
    // Remove temp files
    @unlink($path . '/m_' . $name);
    // Update row
    $this->background_photo_id = $iMain->file_id;
    $this->save();

    return $this;
  }

  public function setPhoto($photo, $direct = '') {

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
      throw new Sescrowdfunding_Model_Exception('invalid argument passed to setPhoto');
    }

    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_id' => $this->getIdentity(),
        'parent_type' => 'sescrowdfunding'
    );

    // Save
    $storage = Engine_Api::_()->storage();
    // Resize image (main)
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(1200, 1200)
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

		if($direct == '') {

			//Add to album
			$viewer = Engine_Api::_()->user()->getViewer();
			$photoTable = Engine_Api::_()->getItemTable('sescrowdfunding_photo');
			$crowdfundingAlbum = $this->getSingletonAlbum();
			$crowdfundingAlbum->title = Zend_Registry::get('Zend_Translate')->_('Untitled');
			$crowdfundingAlbum->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
			$crowdfundingAlbum->save();
			$photoItem = $photoTable->createRow();
			$photoItem->setFromArray(array(
					'crowdfunding_id' => $this->getIdentity(),
					'album_id' => $crowdfundingAlbum->getIdentity(),
					'user_id' => $viewer->getIdentity(),
					'file_id' => $iMain->getIdentity(),
					'collection_id' => $crowdfundingAlbum->getIdentity(),
					'user_id' => $viewer->getIdentity(),
			));
			$photoItem->save();
		}
    return $this;
  }

  public function getSingletonAlbum() {

    $table = Engine_Api::_()->getItemTable('sescrowdfunding_album');
    $select = $table->select()
            ->where('crowdfunding_id = ?', $this->getIdentity())
            ->order('album_id ASC')
            ->limit(1);

    $album = $table->fetchRow($select);

    if (null === $album) {
      $album = $table->createRow();
      $album->setFromArray(array(
          'crowdfunding_id' => $this->getIdentity()
      ));
      $album->save();
    }

    return $album;
  }

  protected function _delete() {
    if ($this->_disableHooks)
      return;
    parent::_delete();
  }

  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('tags', 'core'));
  }

  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('comments', 'core'));
  }

  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbtable('likes', 'core'));
  }
}
