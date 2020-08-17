<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Business.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Model_Business extends Core_Model_Item_Abstract {

  protected $_type = 'businesses';
  protected $_parent_type = 'user';
  protected $_parent_is_owner = true;
  protected $_owner_type = 'user';
  protected $_statusChanged;

  public function membership() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbTable('membership', 'sesbusiness'));
  }
  public function getKeywords(){
    return $this->seo_keywords ? trim($this->seo_keywords,',') : "";
  }
  public function _postInsert() {
    parent::_postInsert();
    // Create auth stuff
    $context = Engine_Api::_()->authorization()->context;
    $context->setAllowed($this, 'everyone', 'view', true);
    $context->setAllowed($this, 'registered', 'comment', true);
    $viewer = Engine_Api::_()->user()->getViewer();
  }

  public function setPhoto($photo, $isShareContent = false, $phototype = null) {

   $this->photo_id = Engine_Api::_()->sesbasic()->setPhoto($photo, false,false,'sesbusiness','businesses','',$this,true,true, 'watermark_photo');
    $this->save();

    // Add to album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('sesbusiness_photo');
    $businessAlbum = $this->getSingletonAlbum($phototype);
    if ($phototype == 'profile') {
      $businessAlbum->title = Zend_Registry::get('Zend_Translate')->_('Profile Photos');
    }

    $businessAlbum->owner_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $businessAlbum->save();
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
        'business_id' => $this->getIdentity(),
        'album_id' => $businessAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'file_id' => $this->photo_id,
        'collection_id' => $businessAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
    ));
    $photoItem->save();

    $businessAlbum->photo_id = $photoItem->getIdentity();
    $businessAlbum->save();

    return $this;
  }

  public function getSingletonAlbum($type = null) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getItemTable('sesbusiness_album');
    $select = $table->select()
            ->where('business_id = ?', $this->getIdentity())
            ->where('type =?', $type)
            ->order('album_id ASC')
            ->limit(1);

    $album = $table->fetchRow($select);

    if (null === $album) {
      $album = $table->createRow();
      $album->setFromArray(array(
          'title' => $this->getTitle(),
          'business_id' => $this->getIdentity(),
          'owner_id' => $viewer->getIdentity(),
      ));
      $album->type = $type;
      $album->save();
    }

    return $album;
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
      throw new Sesbusiness_Model_Exception('invalid argument passed to setPhoto');
    }
    $name = basename($name);
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_id' => $this->getIdentity(),
        'parent_type' => 'businesses'
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

  public function setCoverPhoto($photo) {

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
      $unlink = false;
    } else {
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');

    if (!$fileName) {
      $fileName = $file;
    }
    $filesTable = Engine_Api::_()->getDbTable('files', 'storage');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => $this->getType(),
        'parent_id' => $this->getIdentity(),
        'user_id' => $this->owner_id,
        'name' => $fileName,
    );
    // Resize image (main)
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_m.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(1400, 1400)
            ->write($mainPath)
            ->destroy();

    $enableWatermark = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusiness.watermark.enable', 0);
    if($enableWatermark == 1){
      $watermarkImage = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->user()->getViewer()->level_id,'businesses', 'watermark_cphoto');
      if(is_file($watermarkImage)){
        $mainFileUploaded =   APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.$name;
        $fileName = current(explode('.',$fileName));
        $fileNew = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary'.DIRECTORY_SEPARATOR.time().'_'.$fileName.".jpg";
        $watemarkImageResult = Engine_Api::_()->sesbasic()->watermark_image($mainPath, $fileNew,$extension,$watermarkImage,'sesbusiness');
        if($watemarkImageResult){
          @unlink($mainPath);
          $image->open($fileNew)
                ->autoRotate()
                ->resize(1400, 1400)
                ->write($mainPath)
                ->destroy();
          @unlink($fileNew);
        }
      }
    }

    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch (Exception $e) {
      @unlink($file);
      // Remove temp files
      @unlink($mainPath);

      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Sesevent_Model_Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    if (!isset($unlink))
      @unlink($file);
    // Remove temp files
    @unlink($mainPath);

    // Update row
    $this->cover = $iMain->file_id;
    $this->save();
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }

    // Add to album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('sesbusiness_photo');
    $businessAlbum = $this->getSingletonAlbum('cover');
    $businessAlbum->title = Zend_Registry::get('Zend_Translate')->_('Cover Photos');

    $businessAlbum->save();
    $photoItem = $photoTable->createRow();
    $photoItem->setFromArray(array(
        'business_id' => $this->getIdentity(),
        'album_id' => $businessAlbum->getIdentity(),
        'user_id' => $viewer->getIdentity(),
        'file_id' => $iMain->getIdentity(),
        'collection_id' => $businessAlbum->getIdentity(),
    ));
    $photoItem->save();
    $businessAlbum->photo_id = $photoItem->getIdentity();
    $businessAlbum->save();


    return $this;
  }

  public function getDescription($length = 255) {
    // @todo decide how we want to handle multibyte string functions
    $ro = preg_replace('/\s+/', ' ',$this->description);
    $tmpBody = preg_replace('/ +/', ' ',html_entity_decode(strip_tags( $ro)));
    return nl2br( Engine_String::strlen($tmpBody) > 255 ? Engine_String::substr($tmpBody, 0, 255) . '...' : $tmpBody );
  }

  public function getTitle() {
    return $this->title;
  }

  /**
   * Gets an absolute URL to the business to view this item
   *
   * @return string
   */
  public function getHref($params = array()) {
    $params = array_merge(array(
        'route' => 'sesbusiness_profile',
        'reset' => true,
        'id' => $this->custom_url,
            ), $params);
    $route = $params['route'];
    $reset = $params['reset'];
    unset($params['route']);
    unset($params['reset']);
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $route = Zend_Controller_Front::getInstance()->getRouter()->assemble($params, $route, $reset);
	if(SESBUSINESSURLENABLED == 1 && $settings->getSetting('sesbusiness.enable.shorturl', 0)) {
      $isShortURL = true;
      if($settings->getSetting('sesbusiness.shorturl.onlike', 0)) {
        if($this->like_count < $settings->getSetting('sesbusiness.countlike', 10))
        $isShortURL = false;
      }
      if($isShortURL)
	  return Zend_Controller_Front::getInstance()->getRequest()->getBaseUrl().'/'.$this->custom_url;
      else
      return $route;
    }
	else
      return $route;
  }

  protected function _delete() {
    if ($this->_disableHooks)
      return;
    $db = Engine_Db_Table::getDefaultAdapter();

    //Start Delete package Related Data
    if (Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinesspackage') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspackage.enable.package', 0)) {
      $orderPackageId = $this->orderspackage_id;
      $db->query("DELETE FROM engine4_sesbusinesspackage_orderspackages WHERE orderspackage_id = $orderPackageId && package_id = " . $this->package_id);
      $db->query("DELETE FROM engine4_sesbusinesspackage_transactions WHERE orderspackage_id = $orderPackageId && package_id = " . $this->package_id);
    }
    $locationPhotoTable = Engine_Api::_()->getItemTable('sesbusiness_locationphoto');
    $Select = $locationPhotoTable->select()->where('business_id = ?', $this->getIdentity());
    foreach ($locationPhotoTable->fetchAll($Select) as $locationphoto) {
      Engine_Api::_()->getItem('storage_file', $locationphoto->file_id)->delete();
      $locationphoto->delete();
    }
    $bannedTable = $db->query('SHOW TABLES LIKE \'engine4_sesbasic_bannedwords\'')->fetch();
    if(!empty($bannedTable) && !Engine_Api::_()->sesbasic()->isWordExist('businesses', $this->business_id, $this->custom_url)) {
      $db->query("DELETE FROM engine4_sesbasic_bannedwords WHERE word = '" . $this->custom_url. "' && resource_type = 'businesses' && resource_id = " . $this->getIdentity());
    }
    $db->query("DELETE FROM engine4_sesbusiness_locations WHERE business_id = " . $this->getIdentity());
    //End Work of Package Related Data
    $db->query("DELETE FROM engine4_sesbusiness_announcements WHERE business_id = " . $this->getIdentity());

    $db->query("DELETE FROM engine4_sesbusiness_callactions WHERE business_id = " . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_crossposts WHERE sender_business_id = " . $this->getIdentity() .' || receiver_business_id = ' . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_managebusinessapps WHERE business_id = " . $this->getIdentity());

    $db->query("DELETE FROM engine4_sesbusiness_notifications WHERE business_id = " . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_openhours WHERE business_id = " . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_businessroles WHERE business_id = " . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_postattributions WHERE business_id = " . $this->getIdentity());

    $db->query("DELETE FROM engine4_sesbusiness_likebusinesses WHERE business_id = " . $this->getIdentity() . " || like_business_id = " . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_favourites WHERE resource_type = 'businesses' && resource_id = " . $this->getIdentity());
    $db->query("DELETE FROM engine4_sesbusiness_followers WHERE resource_type = 'businesses' && resource_id = " . $this->getIdentity());


    $db->query("DELETE FROM engine4_sesbusiness_services WHERE business_id = " . $this->getIdentity());
    $albums = Engine_Api::_()->getDbTable('albums', 'sesbusiness')->getAlbumSelect(array('widget' => 1, 'business_id' => $this->getIdentity(), 'order' => 'creation_date'));
    foreach($albums as $album) {
      $photos = Engine_Api::_()->getDbTable('photos', 'sesbusiness')->getPhotoSelect(array('album_id' => $album->album_id));
      foreach($photos as $photo) {
        $db->query("DELETE FROM engine4_sesbusiness_favourites WHERE resource_type = 'sesbusiness_photo' && resource_id = " . $photo->getIdentity());
        $db->query("DELETE FROM engine4_sesbusiness_recentlyviewitems WHERE resource_type = 'sesbusiness_photo' && resource_id = " . $photo->getIdentity());
        $photo->delete();
      }
      $db->query("DELETE FROM engine4_sesbusiness_recentlyviewitems WHERE resource_type = 'sesbusiness_album' && resource_id = " . $album->getIdentity());
      $db->query("DELETE FROM engine4_sesbusiness_favourites WHERE resource_type = 'sesbusiness_album' && resource_id = " . $album->getIdentity());
      $album->delete();
    }
	//Video Extension Delete
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessvideo')) {
        $videos = Engine_Api::_()->getDbTable('videos', 'sesbusinessvideo')->getVideo(array('page_id' => $this->getIdentity(), 'order' => 'creation_date'));
        foreach($videos as $video) {
            Engine_Api::_()->getApi('core', 'sesbusinessvideo')->deleteVideo($video);
        }
    }
	if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinesspoll') && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.pluginactivated')) {
        $polltable =Engine_Api::_()->getDbTable('polls','sesbusinesspoll');
		$allpollsSelect = $polltable->getPollSelect(array('page_id'=>$this->getIdentity()));
		$allpolls = $polltable->fetchAll($allpollsSelect);
		foreach($allpolls as $polls){
			$polls->delete();
		}
    }


    parent::_delete();
  }

  public function categoryName() {
    $categoryTable = Engine_Api::_()->getDbTable('categories', 'sesbusiness');
    return $categoryTable->select()
                    ->from($categoryTable, 'title')
                    ->where('category_id = ?', $this->category_id)
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }

  /**
   * Gets a proxy object for the tags handler
   *
   * @return Engine_ProxyObject
   * */
  public function tags() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbTable('tags', 'core'));
  }

  /**
   * Gets a proxy object for the comment handler
   *
   * @return Engine_ProxyObject
   * */
  public function comments() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbTable('comments', 'core'));
  }

  /**
   * Gets a proxy object for the like handler
   *
   * @return Engine_ProxyObject
   * */
  public function likes() {
    return new Engine_ProxyObject($this, Engine_Api::_()->getDbTable('likes', 'core'));
  }

  public function getCoverPhotoUrl() {
    $photo_id = $this->cover;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->cover);
      if ($file)
        return $file->map();
    }
    if (SESBUSINESSPACKAGE == 1) {
      $params = Engine_Api::_()->getItem('sesbusinesspackage_package', $this->package_id)->params;
      $params = json_decode($params, true);
      if (isset($params['defaultCphoto']))
        $defaultPhoto = $params['defaultCphoto'];
      else
        $defaultPhoto = '';
    }
    else {
      $defaultPhoto = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->getItem('user', $this->owner_id), 'businesses', 'defaultCphoto');
    }
    if (!$defaultPhoto) {
      $defaultPhoto = 'application/modules/Sesbusiness/externals/images/blank.png';
    }
    return $defaultPhoto;
  }

  public function getPhotoUrl($type = NULL) {
    $photo_id = $this->photo_id;
    if ($photo_id) {
      $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, $type);
      if ($file)
        return $file->map();
      else {
        $file = Engine_Api::_()->getItemTable('storage_file')->getFile($this->photo_id, 'thumb.profile');
        if ($file)
          return $file->map();
      }
    }
    if (SESBUSINESSPACKAGE == 1) {
      $params = Engine_Api::_()->getItem('sesbusinesspackage_package', $this->package_id)->params;
      $params = json_decode($params, true);
      if (isset($params['businessdefaultphoto']))
        $defaultPhoto = $params['businessdefaultphoto'];
      else
        $defaultPhoto = '';
    } else {
      $defaultPhoto = Engine_Api::_()->authorization()->getPermission(Engine_Api::_()->getItem('user', $this->owner_id), 'businesses', 'bsdefaultphoto');
    }

    if (!$defaultPhoto) {
      $defaultPhoto = 'application/modules/Sesbusiness/externals/images/nophoto_business_thumb_profile.png';
    }
    return $defaultPhoto;
  }

  function canEditActivity($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_edit_delete');
    return $permission;
  }

  function canDeleteComment($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_delete_comment');
    return $permission;
  }

  function canEditComment($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_delete_comment');
    return $permission;
  }

  function canApproveActivity($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $permission = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'approve_disapprove_member');
    return $permission;
  }

  function approveAllowed() {
    return (!$this->auto_approve) ? true : false;
  }

  function approveFeed($action) {
    if (!$this->auto_approve) {
      $type = $action->object_type;
      $subject_id = $action->object_id;
      $subject = Engine_Api::_()->getItem($type, $subject_id);
      if (!$this->canApproveActivity($subject)) {
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

        $detailTable = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity');
        $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
        if($detail_id) {
          $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
          $detailAction->sesapproved = 0;
          $detailAction->save();
        }
        return $view->translate("Thank you for posting. Your post has been submitted for Business Owner's approval and will display once it is approved.");
      }
    }
    return "";
  }

  function activityComposerOptions($subject) {
    $viewer = Engine_Api::_()->user()->getViewer();
    $schedulePost = Engine_Api::_()->getDbTable('businessroles', 'sesbusiness')->toCheckUserBusinessRole($viewer->getIdentity(), $subject->getIdentity(), 'allow_schedult_post');
    $allowed = array('sesbusinessvideo' => 'sesbusinessvideo', 'sesbusiness_photo' => 'sesbusiness_photo', 'sesbusinessmusic' => 'sesbusinessmusic', 'sesadvancedactivitylinkedin' => 'sesadvancedactivitylinkedin', 'sesadvancedactivityfacebookpostembed' => 'sesadvancedactivityfacebookpostembed', 'buysell' => 'buysell', 'fileupload' => 'fileupload', 'sesadvancedactivityfacebook' => 'sesadvancedactivityfacebook', 'sesadvancedactivitytwitter' => 'sesadvancedactivitytwitter', 'tagUseses' => 'tagUseses', 'shedulepost' => 'shedulepost', 'sesadvancedactivitytargetpost' => 'sesadvancedactivitytargetpost', 'sesfeedgif' => 'sesfeedgif', 'feelingssctivity' => 'feelingssctivity', 'emojisses' => 'emojisses','sesbusinesspoll'=>'sesbusinesspoll', 'sesadvancedactivitylink' => 'sesadvancedactivitylink');

    if (!$schedulePost) {
      unset($allowed['shedulepost']);
    }

    //Manage Apps
    $photos = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $this->business_id, 'columnname' => 'photos'));
    if (empty($photos))
      unset($allowed['sesbusiness_photo']);
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinesspoll')) {
	  $polls = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $this->business_id, 'columnname' => 'sesbusinesspoll'));
	  if (empty($polls))
	  unset($allowed['sesbusinesspoll']);
    }

    $buysell = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $this->business_id, 'columnname' => 'buysell'));
    if (empty($buysell))
      unset($allowed['buysell']);

    $fileupload = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $this->business_id, 'columnname' => 'fileupload'));
    if (empty($fileupload))
      unset($allowed['fileupload']);

if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesbusinessvideo')) {
        $video = Engine_Api::_()->getDbTable('managebusinessapps', 'sesbusiness')->isCheck(array('business_id' => $this->business_id, 'columnname' => 'videos'));
    if (empty($video))
      unset($allowed['sesbusinessvideo']);
    }else
     unset($allowed['sesbusinessvideo']);
    return $allowed;
  }

  public function cancel() {
    $package = $this->getPackage();
    if ($package->isFree()) {
      return true;
    }
    //update transaction_id to other business of same package business
    if ($this->transaction_id) {
      $transaction = $this->getTransaction();
      $table = Engine_Api::_()->getDbTable('businesses', 'sesbusiness');
      $tableName = $table->info('name');
      //select business in package with our transaction id.
      $select = $table->select()->from($tableName)->where('transaction_id =?', '')->where('orderspackage_id =?', $this->orderspackage_id);
      $business = $table->fetchRow($select);
      if ($business) {
        $business->transaction_id = $this->transaction_id;
        $business->save();
        //update order
        $order_id = $transaction->order_id;
        $order = Engine_Api::_()->getItem('payment_order', $order_id);
        if ($order) {
          $order->source_id = $business->getIdentity();
          $order->save();
        }
        //update item count in order package
        $orderpackage = Engine_Api::_()->getItem('sesbusinesspackage_orderspackage', $this->orderspackage_id);
        $orderpackage->item_count = $orderpackage->item_count + 1;
        $orderpackage->save();
        return true;
      } else {
        //delete order package
        $orderpackage = Engine_Api::_()->getItem('sesbusinesspackage_orderspackage', $this->orderspackage_id);
        if ($orderpackage)
          $orderpackage->delete();
      }
    }else {
      //update item count in order package
      $orderpackage = Engine_Api::_()->getItem('sesbusinesspackage_orderspackage', $this->orderspackage_id);
      $orderpackage->item_count = $orderpackage->item_count + 1;
      $orderpackage->save();
      return true;
    }
    // Try to cancel recurring payments in the gateway
    if (!empty($transaction->gateway_id) && !empty($transaction->gateway_profile_id) && empty($transaction->gateway_transaction_id)) {
      try {

        $gateway = Engine_Api::_()->getItem('sesbusinesspackage_gateway', $transaction->gateway_id);
        if ($gateway) {
          $gatewayPlugin = $gateway->getPlugin();
          if (method_exists($gatewayPlugin, 'cancelBusiness')) {
            $gatewayPlugin->cancelBusiness($transaction->gateway_profile_id);
          }
        }
      } catch (Exception $e) {
        // Silence?
      }
    }
    return $this;
  }

  public function getPackage() {
    return Engine_Api::_()->getItem('sesbusinesspackage_package', $this->package_id);
  }

  public function getTransaction() {
    return Engine_Api::_()->getItem('sesbusinesspackage_transaction', $this->transaction_id);
  }

  // Cntests
  public function clearStatusChanged() {
    $this->_statusChanged = null;
    return $this;
  }

  public function didStatusChange() {
    return (bool) $this->_statusChanged;
  }

  // Active
  public function setActive($flag = true, $deactivateOthers = null) {
    //$this->active = true;
    if ((true === $flag && null === $deactivateOthers) ||
            $deactivateOthers === true) {
      $this->is_approved = 1;
    }
    $this->save();
    return $this;
  }

  public function changeApprovedStatus($approved = 0) {
    $transaction = $this->getTransaction();
    $orderPackageId = $this->orderspackage_id;
    if ($transaction && $orderPackageId) {
      $this->is_approved = $approved;
      $this->save();
      Engine_Api::_()->getDbtable('businesses', 'sesbusiness')->update(array('is_approved' => $approved), array('orderspackage_id' => $orderPackageId));
      if ($approved) {
        $activityApi = Engine_Api::_()->getDbtable('actions', 'activity');
        $action = $activityApi->addActivity(Engine_Api::_()->user()->getViewer(), $this, 'sesbusiness_create');
        if ($action) {
          $activityApi->attachActivity($action, $this);
        }
      }
    }
  }

  public function onPaymentSuccess() {
    $this->_statusChanged = false;
    $transaction = $this->getTransaction();
    if ($transaction) {
      if (in_array($transaction->state, array('initial', 'trial', 'pending', 'active'))) {
        // If the package is in initial or pending, set as active and
        // cancel any other active subscriptions
        if (in_array($transaction->state, array('initial', 'pending'))) {
          $this->setActive(true);
        }
        // Update expiration to expiration + recurrence or to now + recurrence?
        $package = $this->getPackage();
        $expiration = $package->getExpirationDate();
        //get custom feature of package
        $params = json_decode($package->params, true);
        $approved = 0;
        if (isset($params['business_approve']) && $params['business_approve'])
          $approved = 1;
        if (isset($params['business_featured']) && $params['business_featured'])
          $this->featured = 1;
        if (isset($params['business_sponsored']) && $params['business_sponsored'])
          $this->sponsored = 1;
        if (isset($params['business_verified']) && $params['business_verified'])
          $this->verified = 1;
        if (isset($params['business_hot']) && $params['business_hot'])
          $this->hot = 1;
        $this->save();

        if (!$approved) {
          Engine_Api::_()->sesbusiness()->sendMailNotification(array('business' => $this));
        }

        //check isonetime condition and renew exiration date if left
        $daysLeft = 0;
        if ($package->isOneTime() && !empty($transaction->expiration_date) && $transaction->expiration_date != '3000-00-00 00:00:00') {
          $datediff = strtotime($transaction->expiration_date) - time();
          $daysLeft = floor($datediff / (60 * 60 * 24));
        }
        $orderPackage = Engine_Api::_()->getItem('sesbusinesspackage_orderspackage', $this->orderspackage_id);

        if ($expiration) {
          $expiration_date = date('Y-m-d H:i:s', $expiration);
          //check days left or not
          if ($daysLeft >= 1) {
            //reniew condition
            $expiration_date = date('Y-m-d H:i:s', strtotime($transaction->expiration_date . '+ ' . $daysLeft . ' days'));
          }
          $transaction->expiration_date = $expiration_date;
          $orderPackage->expiration_date = $expiration_date;
          $orderPackage->save();
        } else {
          //make it a future business(never expired)
          $transaction->expiration_date = '3000-00-00 00:00:00';
          $orderPackage->expiration_date = '3000-00-00 00:00:00';
          $orderPackage->save();
        }
        //update all items in the transaction
        $this->changeApprovedStatus($approved);
        // Change status
        if ($transaction->state != 'active') {
          $transaction->state = 'active';
          $this->_statusChanged = true;
        }
        $transaction->save();
      }
    }
    return $transaction;
  }

  public function onPaymentPending() {
    $this->_statusChanged = false;
    $transaction = $this->getTransaction();
    if ($transaction && ( in_array($transaction->state, array('initial', 'trial', 'pending', 'active')))) {
      //update all items in the transaction
      $this->changeApprovedStatus(0);
      // Change status
      if ($transaction->state != 'pending') {
        $transaction->state = 'pending';
        $this->_statusChanged = true;
        $transaction->save();
      }
    }
    return $this;
  }

  public function onPaymentFailure() {
    $this->_statusChanged = false;
    $transaction = $this->getTransaction();

    if ($transaction && in_array($transaction->state, array('initial', 'trial', 'pending', 'active', 'overdue'))) {
      //update all items in the transaction
      $this->changeApprovedStatus(0);
      // Change status
      if ($transaction->state != 'overdue') {
        $transaction->state = 'overdue';
        $this->_statusChanged = true;
        $transaction->save();
      }
    }

    return $this;
  }

  public function onCancel() {
    $this->_statusChanged = false;
    $transaction = $this->getTransaction();
    if ($transaction && ( in_array($transaction->state, array('initial', 'trial', 'pending', 'active', 'overdue', 'cancelled', 'okay')) )) {
      //update all items in the transaction
      $this->changeApprovedStatus(0);
      // Change status
      if ($transaction->state != 'cancelled') {
        $transaction->state = 'cancelled';
        $this->_statusChanged = true;
        $transaction->save();
      }
    }

    return $this;
  }

  public function onExpiration() {
    $this->_statusChanged = false;
    $transaction = $this->getTransaction();
    if ($transaction && ( in_array($this->state, array('initial', 'trial', 'pending', 'active', 'expired', 'overdue')) )) {
      //update all items in the transaction
      $this->changeApprovedStatus(0);
      // Change status
      if ($transaction->state != 'expired') {
        $transaction->state = 'expired';
        $this->_statusChanged = true;
        $transaction->save();
      }
    }
    return $this;
  }

  public function onRefund() {
    $this->_statusChanged = false;
    $transaction = $this->getTransaction();
    if ($transaction && in_array($transaction->state, array('initial', 'trial', 'pending', 'active', 'refunded'))) {
      //update all items in the transaction
      $this->changeApprovedStatus(0);
      // Change status
      if ($transaction->state != 'refunded') {
        $transaction->state = 'refunded';
        $this->_statusChanged = true;
        $transaction->save();
      }
    }
    return $this;
  }
}
