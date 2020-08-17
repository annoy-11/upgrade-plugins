<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ProfileController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgroup_ProfileController extends Core_Controller_Action_Standard {

  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() &&
            ($id = $this->_getParam('id'))) {
      $group_id = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupId($id);
      if ($group_id) {
        $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
        if ($group)
          Engine_Api::_()->core()->setSubject($group);
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
      $dbObject->query('INSERT INTO engine4_sesgroup_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $subject->getIdentity() . '", "' . $subject->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
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
    $attributionType = Engine_Api::_()->getDbTable('postattributions', 'sesgroup')->getGroupPostAttribution(array('group_id' => $subject->getIdentity()));
    $groupAttributionType = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'gp_attribution');
    $allowUserChooseGroupAttribution = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'auth_defattribut');
    $enablePostAttribution = Engine_Api::_()->authorization()->isAllowed('sesgroup_group', $viewer, 'auth_contSwitch');
    if (!$groupAttributionType || $attributionType == 0) {
      $groupAttribution = "";
    }
    
    if($groupAttributionType && !$allowUserChooseGroupAttribution || !$enablePostAttribution) {
      $groupAttribution = $subject;
    }
    if($groupAttributionType && $allowUserChooseGroupAttribution && $attributionType == 1 || !$enablePostAttribution) {
       $groupAttribution = $subject;
    }
    $data = $this->view->partial('_showAttribution.tpl', 'sesgroup', array('group' => $groupAttribution, 'sesgroup' => $subject));
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
      $table = Engine_Api::_()->getDbTable('grouproles','sesgroup');
      $selelct = $table->select($table->info('name'),'group_id')->where('user_id =?',$this->view->viewer()->getIdentity());
      $res = $table->fetchAll($selelct);
      $groupIds = array();
      foreach($res as $group){
        $groupIds[] = $group->group_id;  
      }
      if (!$user_id)
        $user_id = $this->view->viewer()->getIdentity();
      $value['user_id'] = $user_id;
      $value['groupIds'] = $groupIds;      
      $groupsUser = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupSelect($value);
    }
    
    $script .= "sesJqueryObject(document).ready(function () {
       sesJqueryObject('" . $attrPost . "').insertBefore('#compose-container');
       sesJqueryObject('#sesact_post_box_status').find('.sesact_post_box_img').find('a').find('img').attr('src',sesJqueryObject('.sesgroup_feed_change_option_a').data('src'));
    });
    var sesItemSubjectGuid = '" . $subject->getGuid() . "';
    ";
    $view->headScript()->appendScript($script);
    if (!$enablePostAttribution || (!$groupAttributionType) || !$user_id || !count($groupsUser)) {
      $view->headStyle()->appendStyle('.sesgroup_switcher_cnt{display:none !important;}');
    }
		}
    if ($subject->groupstyle == 1)
      $group = 'sesgroup_profile_index_1';
    elseif ($subject->groupstyle == 2)
      $group = 'sesgroup_profile_index_2';
    elseif ($subject->groupstyle == 3)
      $group = 'sesgroup_profile_index_3';
    elseif ($subject->groupstyle == 4)
      $group = 'sesgroup_profile_index_4';

    $this->_helper->content->setContentName($group)->setEnabled();
  }

  //update cover photo function
  public function uploadPhotoAction() {

    $group = Engine_Api::_()->core()->getSubject();
    if (!$group)
      return;
    $photo = $group->photo_id;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $group->setPhoto($data, '', 'profile');
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'sesgroup')->getPhotoId($group->photo_id);
    $photo = Engine_Api::_()->getItem('sesgroup_photo', $getPhotoId);
    
    $grouplink = '<a href="' . $group->getHref() . '">' . $group->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'sesgroup_group_profilephoto', null, array('groupname' => $grouplink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { 
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $group->getIdentity();
        $detailAction->sesresource_type = $group->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);
      
//    if ($photo != 0) {
//      $im = Engine_Api::_()->getItem('storage_file', $photo);
//      $im->delete();
//    }
    echo json_encode(array('file' => $group->getPhotoUrl()));
    die;
  }

  public function removePhotoAction() {
    $group = Engine_Api::_()->core()->getSubject();
    if (!$group)
      return false;
    if (isset($group->photo_id) && $group->photo_id > 0) {
      $group->photo_id = 0;
      $group->save();
    }
    echo json_encode(array('file' => $group->getPhotoUrl()));
    die;
  }

  //update cover photo function
  public function uploadCoverAction() {

    $group = Engine_Api::_()->core()->getSubject();
    if (!$group)
      return;
    $cover_photo = $group->cover;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $group->setCoverPhoto($data);
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'sesgroup')->getPhotoId($group->cover);
    $photo = Engine_Api::_()->getItem('sesgroup_photo', $getPhotoId);
    
    $grouplink = '<a href="' . $group->getHref() . '">' . $group->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'sesgroup_group_coverphoto', null, array('groupname' => $grouplink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $group->getIdentity();
        $detailAction->sesresource_type = $group->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);
            
    if ($cover_photo != 0) {
      $im = Engine_Api::_()->getItem('storage_file', $cover_photo);
      $im->delete();
    }
    echo json_encode(array('file' => $group->getCoverPhotoUrl()));
    die;
  }

  public function removeCoverAction() {
    $group = Engine_Api::_()->core()->getSubject();
    if (!$group)
      return false;
    if (isset($group->cover) && $group->cover > 0) {
      $im = Engine_Api::_()->getItem('storage_file', $group->cover);
      $group->cover = 0;
      $group->save();
      $im->delete();
    }
    echo json_encode(array('file' => $group->getCoverPhotoUrl()));
    die;
  }

  public function repositionCoverAction() {
    $group_id = $this->_getParam('id', '0');
    if ($group_id == 0)
      return;
    $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    if (!$group)
      return;

    $position = $this->_getParam('position', '0');
    $group->cover_position = $position;
    $group->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
