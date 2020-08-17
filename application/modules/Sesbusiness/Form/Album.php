<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Album.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Album extends Engine_Form {

  public function init() {

    // Init form
    $this->setTitle('Add New Photos')
      ->setDescription('Choose photos on your computer to add to this album.')
      ->setAttrib('id', 'form-upload')
      ->setAttrib('name', 'albums_create')
      ->setAttrib('enctype','multipart/form-data')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    // Init album
    $businessId = Zend_Controller_Front::getInstance()->getRequest()->getParam('business_id', null);
		$albumId = Zend_Controller_Front::getInstance()->getRequest()->getParam('album_id', null);
		if($albumId){
			$businessId = Engine_Api::_()->getItem('sesbusiness_album', $albumId)->business_id;
		}

    $albumTable = Engine_Api::_()->getItemTable('sesbusiness_album');
    $myAlbums = $albumTable->select()
        ->from($albumTable, array('album_id', 'title'))
        ->where('business_id = ?', $businessId)
        ->query()
        ->fetchAll();
    $albumOptions = array('0' => 'Create A New Album');
    foreach( $myAlbums as $myAlbum ) {
      $albumOptions[$myAlbum['album_id']] = $myAlbum['title'];
    }

    $this->addElement('Select', 'album', array(
      'label' => 'Choose Album',
      'multiOptions' => $albumOptions,
      'onchange' => "updateTextFields()",
    ));

    // Init name
    $this->addElement('Text', 'title', array(
      'label' => 'Album Title',
      'maxlength' => '255',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '255')),
      )
    ));

    // Init descriptions
    $this->addElement('Textarea', 'description', array(
      'label' => 'Album Description',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_EnableLinks(),
      ),
    ));
      $restapi=Zend_Controller_Front::getInstance()->getRequest()->getParam( 'restApi', null );
      if ($restapi == 'Sesapi'){
          $this->addElement('file', 'album_photo', array(
              'label' => 'Album Photo',
          ));
          $this->album_photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
      }

    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('Dummy', 'fancyuploadfileids', array('content'=>'<input id="fancyuploadfileids" name="file" type="hidden" value="" >'));

    $this->addElement('Dummy', 'tabs_form_albumcreate', array(
     'content' => '<div class="sesbusiness_create_form_tabs sesbasic_clearfix sesbm"><ul id="sesbusiness_create_form_tabs" class="sesbasic_clearfix"><li class="active sesbm"><i class="fa fa-arrows sesbasic_text_light"></i><a href="javascript:;" class="drag_drop">'.$translate->translate('Drag & Drop').'</a></li><li class=" sesbm"><i class="fa fa-upload sesbasic_text_light"></i><a href="javascript:;" class="multi_upload">'.$translate->translate('Multi Upload').'</a></li><li class=" sesbm"><i class="fa fa-link sesbasic_text_light"></i><a href="javascript:;" class="from_url">'.$translate->translate('From URL').'</a></li></ul></div>',
    ));
    $this->addElement('Dummy', 'drag-drop', array(
      'content' => '<div id="dragandrophandler" class="sesbusiness_upload_dragdrop_content sesbasic_bxs">'.$translate->translate('Drag & Drop Photos Here').'</div>',
    ));
    $this->addElement('Dummy', 'from-url', array(
      'content' => '<div id="from-url" class="sesbusiness_upload_url_content sesbm"><input type="text" name="from_url" id="from_url_upload" value="" placeholder="'.$translate->translate('Enter Image URL to upload').'"><span id="loading_image"></span><span></span><button id="upload_from_url">'.$translate->translate('Upload').'</button></div>',
    ));

    $this->addElement('Dummy', 'file_multi', array('content'=>'<input type="file" accept="image/x-png,image/jpeg" onchange="readImageUrl(this)" multiple="multiple" id="file_multi" name="file_multi">'));

    $this->addElement('Dummy', 'uploadFileContainer', array('content'=>'<div id="show_photo_container" class="sesbusiness_upload_photos_container sesbasic_bxs sesbasic_custom_scroll clear"><div id="show_photo"></div></div>'));

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Photos',
      'type' => 'submit',
    ));
  }

  public function clearAlbum() {
    $this->getElement('album')->setValue(0);
  }

  public function saveValues() {

    $set_cover = false;
    $businessId = Zend_Controller_Front::getInstance()->getRequest()->getParam('business_id', null);
    $business = Engine_Api::_()->getItem('businesses', $businessId);
    $values = $this->getValues();
    $params = array();
    if ((empty($values['business_id'])) || (empty($values['user_id']))) {
      $params['owner_id'] = Engine_Api::_()->user()->getViewer()->user_id;
      $params['business_id'] = $businessId;
    } else {
      $params['owner_id'] = Engine_Api::_()->user()->getViewer()->user_id;
      $params['business_id'] = $businessId;
      throw new Zend_Exception("Non-user album owners not yet implemented");
    }

    if( ($values['album'] == 0) ) {
      $params['title'] = $values['title'];
      if (empty($params['title'])) {
        $params['title'] = "Business Profile Photos";
      }
      $params['description'] = $values['description'];
      $params['search'] = 1;
      $album = Engine_Api::_()->getDbTable('albums', 'sesbusiness')->createRow();
      $album->setFromArray($params);
      $album->save();
      $set_cover = true;
    } else {
      if (!isset($album)) {
        $album = Engine_Api::_()->getItem('sesbusiness_album', $values['album']);
      }
    }

    // Add action and attachments
    $api = Engine_Api::_()->getDbTable('actions', 'activity');


    $businesslink = '<a href="' . $business->getHref() . '">' . $business->getTitle() . '</a>';
    $albumlink = '<a href="' . $album->getHref() . '">' . 'album' . '</a>';
    $actionalbum = $api->addActivity(Engine_Api::_()->user()->getViewer(), $album, 'sesbusiness_album_create', null, array('businessname' => $businesslink, 'albumlink' => $albumlink));
    if ($actionalbum) {
      $api->attachActivity($actionalbum, $album);
    }

    //Send to business owner when someone create business album

    Engine_Api::_()->getApi('mail', 'core')->sendSystem($business->getOwner(), 'notify_businesses_albumcreate', array('business_title' => $business->getTitle(), 'sender_title' => Engine_Api::_()->user()->getViewer()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'album_title' => $album->getTitle()));
    //Send to all joined members
    $joinedMembers = Engine_Api::_()->sesbusiness()->getallJoinedMembers($business);
    foreach($joinedMembers as $joinedMember) {
      if($joinedMember->user_id == $business->owner_id) continue;
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $album, 'sesbusiness_business_bsjoinalbum', array('businesslink' => $businesslink));
    }

    //Send to all followed members
    $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getFollowers($business->getIdentity());
    foreach($followerMembers as $followerMember) {
      if($followerMember->owner_id == $business->owner_id) continue;
      $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, Engine_Api::_()->user()->getViewer(), $album, 'sesbusiness_business_bsfollphoto', array('businesslink' => $businesslink));

      Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_businesses_albumcreatefollowed', array('business_title' => $business->getTitle(), 'sender_title' => Engine_Api::_()->user()->getViewer()->getTitle(), 'object_link' => $business->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'album_title' => $album->getTitle()));
    }

    // Add action and attachments
    $action = $api->addActivity(Engine_Api::_()->user()->getViewer(), $album, 'sesbusiness_album_photo_new', null, array('count' => count($_POST['file']), 'businessname' => $businesslink));


    // Do other stuff
    $count = 0;
    if(isset($_POST['file'])) {
      $explodeFile = explode(' ',rtrim($_POST['file'],' '));
      foreach( $explodeFile as $photo_id ) {

        if($photo_id == '')
          continue;

        $photo = Engine_Api::_()->getItem("sesbusiness_photo", $photo_id);

        if( !($photo instanceof Core_Model_Item_Abstract) || !$photo->getIdentity() )
          continue;

        if(isset($_POST['cover']) && $_POST['cover'] == $photo_id ) {
          $album->photo_id = $photo_id;
          $album->save();
          unset($_POST['cover']);
          $set_cover = false;
        } else if( $set_cover){
          $album->photo_id = $photo_id;
          $album->save();
          $set_cover = false;
        }
        $photo->album_id = $album->album_id;
        $photo->save();

        if( $action instanceof Activity_Model_Action && $count < 100 ) {
          $api->attachActivity($action, $photo, Activity_Model_Action::ATTACH_MULTI);
        }

        $count++;
      }
    }

    //Send to all joined members
    $joinedMembers = Engine_Api::_()->sesbusiness()->getallJoinedMembers($business);
    foreach($joinedMembers as $joinedMember) {
      if($joinedMember->user_id == $business->owner_id) continue;
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $album, 'sesbusiness_business_bsjoinphoto', array('businesslink' => $businesslink));
    }

    //Send to all followed members
    $followerMembers = Engine_Api::_()->getDbTable('followers', 'sesbusiness')->getFollowers($business->getIdentity());
    foreach($followerMembers as $followerMember) {
      if($followerMember->owner_id == $business->owner_id) continue;
      $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
      Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($followerMember, Engine_Api::_()->user()->getViewer(), $album, 'sesbusiness_business_bsfoupphoto', array('businesslink' => $businesslink));
    }

    $album->save();
    return $album;
  }
}
