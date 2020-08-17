<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ProfileController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_ProfileController extends Core_Controller_Action_Standard {

  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() && ($id = $this->_getParam('id'))) {
      $business_id = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessId($id);
      if ($business_id) {
        $business = Engine_Api::_()->getItem('businesses', $business_id);
        if ($business)
          Engine_Api::_()->core()->setSubject($business);
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
      $dbObject->query('INSERT INTO engine4_sesbusiness_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $subject->getIdentity() . '", "' . $subject->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
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
    $attributionType = Engine_Api::_()->getDbTable('postattributions', 'sesbusiness')->getBusinessPostAttribution(array('business_id' => $subject->getIdentity()));
    $businessAttributionType = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'seb_attribution');
    $allowUserChooseBusinessAttribution = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'auth_defattribut');
    $enablePostAttribution = Engine_Api::_()->authorization()->isAllowed('businesses', $viewer, 'auth_contSwitch');
    if (!$businessAttributionType || $attributionType == 0) {
      $businessAttribution = "";
    }

    if($businessAttributionType && !$allowUserChooseBusinessAttribution || !$enablePostAttribution) {
      $businessAttribution = $subject;
    }
    if($businessAttributionType && $allowUserChooseBusinessAttribution && $attributionType == 1 || !$enablePostAttribution) {
       $businessAttribution = $subject;
    }
    $data = $this->view->partial('_showAttribution.tpl', 'sesbusiness', array('business' => $businessAttribution, 'sesbusiness' => $subject));
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
      $table = Engine_Api::_()->getDbTable('businessroles','sesbusiness');
      $selelct = $table->select($table->info('name'),'business_id')->where('user_id =?',$this->view->viewer()->getIdentity());
      $res = $table->fetchAll($selelct);
      $businessIds = array();
      foreach($res as $business){
        $businessIds[] = $business->business_id;
      }
      if (!$user_id)
        $user_id = $this->view->viewer()->getIdentity();
      $value['user_id'] = $user_id;
      $value['businessIds'] = $businessIds;
      $businessesUser = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect($value);
    }

    $script .= "sesJqueryObject(document).ready(function () {
       sesJqueryObject('" . $attrPost . "').insertBefore('#compose-container');
       sesJqueryObject('#sesact_post_box_status').find('.sesact_post_box_img').find('a').find('img').attr('src',sesJqueryObject('.sesbusiness_feed_change_option_a').data('src'));
    });
    var sesItemSubjectGuid = '" . $subject->getGuid() . "';
    ";
    $view->headScript()->appendScript($script);
    if (!$enablePostAttribution || (!$businessAttributionType) || !$user_id || !count($businessesUser)) {
      $view->headStyle()->appendStyle('.sesbusiness_switcher_cnt{display:none !important;}');
    }
		}
    if ($subject->businessestyle == 1)
      $business = 'sesbusiness_profile_index_1';
    elseif ($subject->businessestyle == 2)
      $business = 'sesbusiness_profile_index_2';
    elseif ($subject->businessestyle == 3)
      $business = 'sesbusiness_profile_index_3';
    elseif ($subject->businessestyle == 4)
      $business = 'sesbusiness_profile_index_4';

    $this->_helper->content->setContentName($business)->setEnabled();
  }

  //update cover photo function
  public function uploadPhotoAction() {

    $business = Engine_Api::_()->core()->getSubject();
    if (!$business)
      return;
    $photo = $business->photo_id;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $business->setPhoto($data, '', 'profile');

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'sesbusiness')->getPhotoId($business->photo_id);
    $photo = Engine_Api::_()->getItem('sesbusiness_photo', $getPhotoId);

    $businesslink = '<a href="' . $business->getHref() . '">' . $business->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'sesbusiness_business_pfphoto', null, array('businessname' => $businesslink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $business->getIdentity();
        $detailAction->sesresource_type = $business->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);

//    if ($photo != 0) {
//      $im = Engine_Api::_()->getItem('storage_file', $photo);
//      $im->delete();
//    }
    echo json_encode(array('file' => $business->getPhotoUrl()));
    die;
  }

  public function removePhotoAction() {
    $business = Engine_Api::_()->core()->getSubject();
    if (!$business)
      return false;
    if (isset($business->photo_id) && $business->photo_id > 0) {
      $business->photo_id = 0;
      $business->save();
    }
    echo json_encode(array('file' => $business->getPhotoUrl()));
    die;
  }

  //update cover photo function
  public function uploadCoverAction() {

    $business = Engine_Api::_()->core()->getSubject();
    if (!$business)
      return;
    $cover_photo = $business->cover;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $business->setCoverPhoto($data) ;

    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'sesbusiness')->getPhotoId($business->cover);
    $photo = Engine_Api::_()->getItem('sesbusiness_photo', $getPhotoId);

    $businesslink = '<a href="' . $business->getHref() . '">' . $business->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'sesbusiness_business_coverphoto', null, array('businessname' => $businesslink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $business->getIdentity();
        $detailAction->sesresource_type = $business->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);

    if ($cover_photo != 0) {
      $im = Engine_Api::_()->getItem('storage_file', $cover_photo);
      $im->delete();
    }
    echo json_encode(array('file' => $business->getCoverPhotoUrl()));
    die;
  }

  public function removeCoverAction() {
    $business = Engine_Api::_()->core()->getSubject();
    if (!$business)
      return false;
    if (isset($business->cover) && $business->cover > 0) {
      $im = Engine_Api::_()->getItem('storage_file', $business->cover);
      $business->cover = 0;
      $business->save();
      $im->delete();
    }
    echo json_encode(array('file' => $business->getCoverPhotoUrl()));
    die;
  }

  public function repositionCoverAction() {
    $business_id = $this->_getParam('id', '0');
    if ($business_id == 0)
      return;
    $business = Engine_Api::_()->getItem('businesses', $business_id);
    if (!$business)
      return;

    $position = $this->_getParam('position', '0');
    $business->cover_position = $position;
    $business->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
