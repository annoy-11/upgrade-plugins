<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ProfileController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_ProfileController extends Core_Controller_Action_Standard {

  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() && ($id = $this->_getParam('id'))) {
      $store_id = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreId($id);
      if ($store_id) {
        $store = Engine_Api::_()->getItem('stores', $store_id);
        if ($store)
          Engine_Api::_()->core()->setSubject($store);
        else
          return $this->_forward('requireauth', 'error', 'core');
      } else
        return $this->_forward('requireauth', 'error', 'core');
    }

    $this->_helper->requireSubject();
    $this->_helper->requireAuth()->setNoForward()->setAuthParams(
            $subject, Engine_Api::_()->user()->getViewer(), 'view'
    );
  }

  public function indexAction() {
    $subject = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$viewer->getIdentity())
      $level_id = 0;
    else
      $level_id = $viewer->level_id;
    if ((!$subject->is_approved || !$subject->draft ) && $level_id != 1 && $level_id != 2) {
      return $this->_forward('notfound', 'error', 'core');
    }

    if (!$this->_helper->requireAuth()->setAuthParams($subject, $viewer, 'view')->isValid()) {
      return;
    }

    // Check block
    if ($viewer->isBlockedBy($subject)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Increment view count
    if (!$subject->getOwner()->isSelf($viewer)) {
      $subject->view_count++;
      $subject->save();
    }

    /* Insert data for recently viewed widget */
    if ($viewer->getIdentity() != 0) {
      $dbObject = Engine_Db_Table::getDefaultAdapter();
      $dbObject->query('INSERT INTO engine4_estore_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $subject->getIdentity() . '", "' . $subject->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
    }

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $subject->getType())
            ->where('id = ?', $subject->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }

    $getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
      $view->doctype('XHTML1_RDFA');
      if ($subject->seo_title)
        $view->headTitle($subject->seo_title, 'SET');
      if ($subject->seo_description)
        $view->headMeta()->appendName('description', $subject->seo_description);
    }

    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')){
        $attributionType = Engine_Api::_()->getDbTable('postattributions', 'estore')->getStorePostAttribution(array('store_id' => $subject->getIdentity()));

        $storeAttributionType = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'seb_attribution');

        $allowUserChooseStoreAttribution = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'auth_defattribut');

        $enablePostAttribution = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'auth_contSwitch');

        if (!$storeAttributionType || $attributionType == 0) {
          $storeAttribution = "";
        }

        if($storeAttributionType && !$allowUserChooseStoreAttribution || !$enablePostAttribution) {
          $storeAttribution = $subject;
        }
        if($storeAttributionType && $allowUserChooseStoreAttribution && $attributionType == 1 || !$enablePostAttribution) {
           $storeAttribution = $subject;
        }
        $data = $this->view->partial('_showAttribution.tpl', 'estore', array('store' => $storeAttribution, 'estore' => $subject));
        $search = array(
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space
            '/[^\S ]+\</s', // strip whitespaces before tags, except space
            '/(\s)+/s'       // shorten multiple whitespace sequences
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $attrPost = preg_replace($search, $replace, $data);
        $script = '';
        $user_id = $this->view->viewer()->getIdentity();
        if($user_id){
          $value['fetchAll'] = true;
          $table = Engine_Api::_()->getDbTable('storeroles','estore');
          $selelct = $table->select($table->info('name'),'store_id')->where('user_id =?',$this->view->viewer()->getIdentity());
          $res = $table->fetchAll($selelct);
          $storeIds = array();
          foreach($res as $store){
            $storeIds[] = $store->store_id;
          }
          if (!$user_id)
            $user_id = $this->view->viewer()->getIdentity();
          $value['user_id'] = $user_id;
          $value['storeIds'] = $storeIds;
          $storesUser = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreSelect($value);
        }

        $script .= "sesJqueryObject(document).ready(function () {
           sesJqueryObject('" . $attrPost . "').insertBefore('#compose-container');
           sesJqueryObject('#sesact_post_box_status').find('.sesact_post_box_img').find('a').find('img').attr('src',sesJqueryObject('.estore_feed_change_option_a').data('src'));
        });
        var sesItemSubjectGuid = '" . $subject->getGuid() . "';
        ";
        $view->headScript()->appendScript($script);
        if (!$enablePostAttribution || (!$storeAttributionType) || !$user_id || !count($storesUser)) {
          $view->headStyle()->appendStyle('.estore_switcher_cnt{display:none !important;}');
        }
	}
    if ($subject->storestyle == 1)
      $store = 'estore_profile_index_1';
    elseif ($subject->storestyle == 2)
      $store = 'estore_profile_index_2';
    elseif ($subject->storestyle == 3)
      $store = 'estore_profile_index_3';
    elseif ($subject->storestyle == 4)
      $store = 'estore_profile_index_4';

    $this->_helper->content->setContentName($store)->setEnabled();
  }

  //update cover photo function
  public function uploadPhotoAction() {

    $store = Engine_Api::_()->core()->getSubject();
    if (!$store)
      return;
    $photo = $store->photo_id;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $store->setPhoto($data, '', 'profile');

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'estore')->getPhotoId($store->photo_id);
    $photo = Engine_Api::_()->getItem('estore_photo', $getPhotoId);

    $storelink = '<a href="' . $store->getHref() . '">' . $store->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'estore_store_pfphoto', null, array('storename' => $storelink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $store->getIdentity();
        $detailAction->sesresource_type = $store->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);

//    if ($photo != 0) {
//      $im = Engine_Api::_()->getItem('storage_file', $photo);
//      $im->delete();
//    }
    echo json_encode(array('file' => $store->getPhotoUrl()));
    die;
  }

  public function removePhotoAction() {
    $store = Engine_Api::_()->core()->getSubject();
    if (!$store)
      return false;
    if (isset($store->photo_id) && $store->photo_id > 0) {
      $store->photo_id = 0;
      $store->save();
    }
    echo json_encode(array('file' => $store->getPhotoUrl()));
    die;
  }

  //update cover photo function
  public function uploadCoverAction() {

    $store = Engine_Api::_()->core()->getSubject();
    if (!$store)
      return;
    $cover_photo = $store->cover;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $store->setCoverPhoto($data) ;

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'estore')->getPhotoId($store->cover);
    $photo = Engine_Api::_()->getItem('estore_photo', $getPhotoId);

    $storelink = '<a href="' . $store->getHref() . '">' . $store->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'estore_store_coverphoto', null, array('storename' => $storelink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $store->getIdentity();
        $detailAction->sesresource_type = $store->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);

    if ($cover_photo != 0) {
      $im = Engine_Api::_()->getItem('storage_file', $cover_photo);
      $im->delete();
    }
    echo json_encode(array('file' => $store->getCoverPhotoUrl()));
    die;
  }

  public function removeCoverAction() {
    $store = Engine_Api::_()->core()->getSubject();
    if (!$store)
      return false;
    if (isset($store->cover) && $store->cover > 0) {
      $im = Engine_Api::_()->getItem('storage_file', $store->cover);
      $store->cover = 0;
      $store->save();
      $im->delete();
    }
    echo json_encode(array('file' => $store->getCoverPhotoUrl()));
    die;
  }

  public function repositionCoverAction() {
    $store_id = $this->_getParam('id', '0');
    if ($store_id == 0)
      return;
    $store = Engine_Api::_()->getItem('stores', $store_id);
    if (!$store)
      return;

    $position = $this->_getParam('position', '0');
    $store->cover_position = $position;
    $store->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
