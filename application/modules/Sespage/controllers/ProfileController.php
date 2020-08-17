<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ProfileController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_ProfileController extends Core_Controller_Action_Standard {

  public function init() {
    // @todo this may not work with some of the content stuff in here, double-check
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() &&
            ($id = $this->_getParam('id'))) {
      $page_id = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageId($id);
      if ($page_id) {
        $page = Engine_Api::_()->getItem('sespage_page', $page_id);
        if ($page)
          Engine_Api::_()->core()->setSubject($page);
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
      $dbObject->query('INSERT INTO engine4_sespage_recentlyviewitems (resource_id, resource_type,owner_id,creation_date ) VALUES ("' . $subject->getIdentity() . '", "' . $subject->getType() . '","' . $viewer->getIdentity() . '",NOW())	ON DUPLICATE KEY UPDATE	creation_date = NOW()');
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
    $attributionType = Engine_Api::_()->getDbTable('postattributions', 'sespage')->getPagePostAttribution(array('page_id' => $subject->getIdentity()));
    $pageAttributionType = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'page_attribution');
    $allowUserChoosePageAttribution = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'auth_defattribut');
    $enablePostAttribution = Engine_Api::_()->authorization()->isAllowed('sespage_page', $viewer, 'auth_contSwitch');
    if (!$pageAttributionType || $attributionType == 0) {
      $pageAttribution = "";
    }
    
    if($pageAttributionType && !$allowUserChoosePageAttribution || !$enablePostAttribution) {
      $pageAttribution = $subject;
    }
    if($pageAttributionType && $allowUserChoosePageAttribution && $attributionType == 1 || !$enablePostAttribution) {
       $pageAttribution = $subject;
    }
    $data = $this->view->partial('_showAttribution.tpl', 'sespage', array('page' => $pageAttribution, 'sespage' => $subject));
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
      $table = Engine_Api::_()->getDbTable('pageroles','sespage');
      $selelct = $table->select($table->info('name'),'page_id')->where('user_id =?',$this->view->viewer()->getIdentity());
      $res = $table->fetchAll($selelct);
      $pageIds = array();
      foreach($res as $page){
        $pageIds[] = $page->page_id;  
      }
      if (!$user_id)
        $user_id = $this->view->viewer()->getIdentity();
      $value['user_id'] = $user_id;
      $value['pageIds'] = $pageIds;      
      $pagesUser = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageSelect($value);
    }
    
    $script .= "sesJqueryObject(document).ready(function () {
       sesJqueryObject('" . $attrPost . "').insertBefore('#compose-container');
       sesJqueryObject('#sesact_post_box_status').find('.sesact_post_box_img').find('a').find('img').attr('src',sesJqueryObject('.sespage_feed_change_option_a').data('src'));
    });
    var sesItemSubjectGuid = '" . $subject->getGuid() . "';
    ";
    $view->headScript()->appendScript($script);
    if (!$enablePostAttribution || (!$pageAttributionType) || !$user_id || !count($pagesUser)) {
      $view->headStyle()->appendStyle('.sespage_switcher_cnt{display:none !important;}');
    }
		}
    if ($subject->pagestyle == 1)
      $page = 'sespage_profile_index_1';
    elseif ($subject->pagestyle == 2)
      $page = 'sespage_profile_index_2';
    elseif ($subject->pagestyle == 3)
      $page = 'sespage_profile_index_3';
    elseif ($subject->pagestyle == 4)
      $page = 'sespage_profile_index_4';

    $this->_helper->content->setContentName($page)->setEnabled();
  }

  //update cover photo function
  public function uploadPhotoAction() {

    $page = Engine_Api::_()->core()->getSubject();
    if (!$page)
      return;
    $photo = $page->photo_id;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $page->setPhoto($data, '', 'profile');
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'sespage')->getPhotoId($page->photo_id);
    $photo = Engine_Api::_()->getItem('sespage_photo', $getPhotoId);
    
    $pagelink = '<a href="' . $page->getHref() . '">' . $page->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'sespage_page_profilephoto', null, array('pagename' => $pagelink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) { 
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $page->getIdentity();
        $detailAction->sesresource_type = $page->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);
      
//    if ($photo != 0) {
//      $im = Engine_Api::_()->getItem('storage_file', $photo);
//      $im->delete();
//    }
    echo json_encode(array('file' => $page->getPhotoUrl()));
    die;
  }

  public function removePhotoAction() {
    $page = Engine_Api::_()->core()->getSubject();
    if (!$page)
      return false;
    if (isset($page->photo_id) && $page->photo_id > 0) {
      $page->photo_id = 0;
      $page->save();
    }
    echo json_encode(array('file' => $page->getPhotoUrl()));
    die;
  }

  //update cover photo function
  public function uploadCoverAction() {

    $page = Engine_Api::_()->core()->getSubject();
    if (!$page)
      return;
    $cover_photo = $page->cover;
    if (isset($_FILES['Filedata']))
      $data = $_FILES['Filedata'];
    else if (isset($_FILES['webcam']))
      $data = $_FILES['webcam'];
    $page->setCoverPhoto($data);
    
    $viewer = Engine_Api::_()->user()->getViewer();
    $getPhotoId = Engine_Api::_()->getDbTable('photos', 'sespage')->getPhotoId($page->cover);
    $photo = Engine_Api::_()->getItem('sespage_photo', $getPhotoId);
    
    $pagelink = '<a href="' . $page->getHref() . '">' . $page->getTitle() . '</a>';
    $action = Engine_Api::_()->getDbTable('actions', 'activity')->addActivity($viewer, $photo, 'sespage_page_coverphoto', null, array('pagename' => $pagelink));
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $detail_id = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->getIdentity());
      if($detail_id) {
        $detailAction = Engine_Api::_()->getItem('sesadvancedactivity_detail',$detail_id);
        $detailAction->sesresource_id = $page->getIdentity();
        $detailAction->sesresource_type = $page->getType();
        $detailAction->save();
      }
    }
    if ($action)
      Engine_Api::_()->getDbTable('actions', 'activity')->attachActivity($action, $photo);
            
    if ($cover_photo != 0) {
      $im = Engine_Api::_()->getItem('storage_file', $cover_photo);
      $im->delete();
    }
    echo json_encode(array('file' => $page->getCoverPhotoUrl()));
    die;
  }

  public function removeCoverAction() {
    $page = Engine_Api::_()->core()->getSubject();
    if (!$page)
      return false;
    if (isset($page->cover) && $page->cover > 0) {
      $im = Engine_Api::_()->getItem('storage_file', $page->cover);
      $page->cover = 0;
      $page->save();
      $im->delete();
    }
    echo json_encode(array('file' => $page->getCoverPhotoUrl()));
    die;
  }

  public function repositionCoverAction() {
    $page_id = $this->_getParam('id', '0');
    if ($page_id == 0)
      return;
    $page = Engine_Api::_()->getItem('sespage_page', $page_id);
    if (!$page)
      return;

    $position = $this->_getParam('position', '0');
    $page->cover_position = $position;
    $page->save();
    echo json_encode(array('status' => "1"));
    die;
  }

}
