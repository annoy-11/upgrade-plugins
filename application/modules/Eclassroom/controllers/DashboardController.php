<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: DashboardController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_DashboardController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('eclassroom', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('classroom_id', null);
    $viewer = $this->view->viewer();
    $classroom_id = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getClassroomId($id);
        if ($classroom_id) {
        $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
        if ($classroom && (($classroom->is_approved || $viewer->level_id == 1 || $viewer->level_id == 2 || $viewer->getIdentity() == $classroom->owner_id) ))
            Engine_Api::_()->core()->setSubject($classroom);
        else
            return $this->_forward('requireauth', 'error', 'core');
        } else
        return $this->_forward('requireauth', 'error', 'core');
  }
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();

    if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
        $this->view->category_id = $_POST['category_id'];
    else
        $this->view->category_id = $classroom->category_id;
    if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
        $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
        $this->view->subsubcat_id = $classroom->subsubcat_id;
    if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
        $this->view->subcat_id = $_POST['subcat_id'];
    else
        $this->view->subcat_id = $classroom->subcat_id;
    $viewer = Engine_Api::_()->user()->getViewer();
    // Prepare form
    $this->view->form = $form = new Eclassroom_Form_Classroom_Edit(array('defaultProfileId' => $defaultProfileId));
    // Populate form
    $form->populate($classroom->toArray());
    $form->title->setValue($classroom->title);
//     $form->populate(array(
//         'networks' => explode(",",$classroom->networks),
//         'levels' => explode(",",$classroom->levels)
//     ));
    $tagStr = '';
    foreach($classroom->tags()->getTagMaps() as $tagMap ) {
      $tag = $tagMap->getTag();
      if( !isset($tag->text) ) continue;
      if( '' !== $tagStr ) $tagStr .= ', ';
      $tagStr .= $tag->text;
    }
    $form->populate(array(
      'tags' => $tagStr,
    ));
    $this->view->tagNamePrepared = $tagStr;

    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    foreach( $roles as $role ) {
      if ($form->auth_view){
        if( $auth->isAllowed($classroom, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }
      if ($form->auth_comment){
        if( $auth->isAllowed($classroom, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }
      if ($form->auth_album){
        if($auth->isAllowed($classroom, $role, 'album') ) {
          $form->auth_album->setValue($role);
        }
      }
    }
    //hide status change if it has been already published
    if($classroom->draft != 0)
      $form->removeElement('draft');
    $this->view->edit = true;

    if( !$this->getRequest()->isPost() ) return;
    if (!$form->isValid($this->getRequest()->getPost()))
        return;
        //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
        $custom_url = Engine_Api::_()->getDbtable('classrooms', 'eclassroom')->checkCustomUrl($_POST['custom_url'],$classroom->classroom_id);
        if ($custom_url) {
            $form->addError($this->view->translate("Custom URL not available. Please select other."));
            return;
        }
    }
    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try
    {
        $values = $form->getValues();
        $classroom->setFromArray($values);
        $classroom->modified_date = date('Y-m-d H:i:s');

        if(isset($values['levels']))
            $values['levels'] = implode(',',$values['levels']);
        if(isset($values['networks']))
            $values['networks'] = implode(',',$values['networks']);
        $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
        $classroom->save();
        // Auth
        if( empty($values['auth_view']) ) {
            $values['auth_view'] = 'everyone';
        }
        if( empty($values['auth_comment']) ) {
            $values['auth_comment'] = 'everyone';
        }
        $viewMax = array_search($values['auth_view'], $roles);
        $commentMax = array_search($values['auth_comment'], $roles);
        $lectureCreate = array_search(isset($values['auth_ltr_create']) ? $values['auth_ltr_create']: '', $roles);
        $tstCreate = array_search(isset($values['auth_tst_create']) ? $values['auth_tst_create']: '', $roles);
        foreach( $roles as $i => $role ) {
            $auth->setAllowed($classroom, $role, 'view', ($i <= $viewMax));
            $auth->setAllowed($classroom, $role, 'comment', ($i <= $commentMax));
            $auth->setAllowed($classroom, $role, 'album', ($i <= $lectureCreate));
        }
        // handle tags
        $tags = preg_split('/[,]+/', $values['tags']);
        $classroom->tags()->setTagMaps($viewer, $tags);
        if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
            $classroom->custom_url = $_POST['custom_url'];
        else
            $classroom->custom_url = $classroom->classroom_id;
        $classroom->save();

        $db->commit();
    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }
    $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'edit', 'classroom_id' => $classroom->custom_url));
  }

    public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');
        $id = $this->_getParam('classroom_id');
        if($this->_getParam('is_Ajax_Delete',null) && $id) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try
            {
               $courses = Engine_Api::_()->getItem('eclassroom', $id);
              //  delete the course entry into the database
               Engine_Api::_()->courses()->deleteCourse($courses);
               $db->commit();
                  echo json_encode(array('status'=>1));die;
            }
            catch( Exception $e )
            {
                $db->rollBack();
                throw $e;
            }
             echo json_encode(array('status'=>0));die;
        }
        $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
        $form->setTitle('Delete course?');
        $form->setDescription('Are you sure that you want to delete this course? It will not be recoverable after being deleted.');
        $form->submit->setLabel('Delete');
        $this->view->classroom_id = $id;
        // Check post
        if($this->getRequest()->isPost())
        {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try
        {
            $courses = Engine_Api::_()->getItem('eclassroom', $id);
            // delete the courses entry into the database
           Engine_Api::_()->courses()->deleteCourse($courses);
            $db->commit();
        }
        catch( Exception $e )
        {
            $db->rollBack();
            throw $e;
        }
        $this->_forward('success', 'utility', 'core', array('smoothboxClose' => 10,'parentRefresh'=> 10,'messages' => array('')
        ));
        }
    }
  //get classroom contact information
  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    // Create form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Contactinformation();

    $form->populate($classroom->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    if (!empty($_POST["classroom_contact_email"]) && !filter_var($_POST["classroom_contact_email"], FILTER_VALIDATE_EMAIL)) {
      $form->addError($this->view->translate("Invalid email format."));
      return;
    }
    if (!empty($_POST["classroom_contact_website"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["classroom_contact_website"])) {
      $form->addError($this->view->translate("Invalid WebSite URL."));
      return;
    }
    if (!empty($_POST["classroom_contact_facebook"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["classroom_contact_facebook"])) {
      $form->addError($this->view->translate("Invalid Facebook URL."));
      return;
    }
    if (!empty($_POST["classroom_contact_linkedin"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["classroom_contact_linkedin"])) {
      $form->addError($this->view->translate("Invalid Linkedin URL."));
      return;
    }
    if (!empty($_POST["classroom_contact_twitter"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["classroom_contact_twitter"])) {
      $form->addError($this->view->translate("Invalid Twitter URL."));
      return;
    }
    if (!empty($_POST["classroom_contact_instagram"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["classroom_contact_instagram"])) {
      $form->addError($this->view->translate("Invalid Instagram URL."));
      return;
    }
    if (!empty($_POST["classroom_contact_pinterest"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["classroom_contact_pinterest"])) {
      $form->addError($this->view->translate("Invalid Pinterest URL."));
      return;
    }
    $db = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getAdapter();
    $db->beginTransaction();
    try {
      $classroom->setFromArray($form->getValues());
      $classroom->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      echo false;
      die;
    }
  }
    public function policyAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
      $viewer = Engine_Api::_()->user()->getViewer();
      if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('classrooms.allow.termncondition', 1))
         return $this->_forward('notfound', 'error', 'core');
      $this->view->form = $form = new Eclassroom_Form_Course_Dashboard_Policy();
      $form->populate($classroom->toArray());
      if (!$this->getRequest()->isPost())
        return;
      // Not post/invalid
      if (!$this->getRequest()->isPost() || $is_ajax_content)
        return;
      if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
        return;
      $db = Engine_Api::_()->getDbTable('classroom', 'eclassroom')->getAdapter();
      $db->beginTransaction();
      try {
        $classroom->setFromArray($_POST);
        $classroom->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
      }
  }
   public function mainphotoAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('eclassroom', $this->view->viewer(), 'upload_mainphoto'))
        return $this->_forward('requireauth', 'error', 'core');

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    // Get form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Mainphoto();
    if (empty($classroom->photo_id)) {
        $form->removeElement('remove');
    }
    if (!$this->getRequest()->isPost()) {
        return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
        return;
    }
        // Uploading a new photo
    if ($form->Filedata->getValue() !== null) {
        $db = $classroom->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $fileElement = $form->Filedata;
            $classroom->setPhoto($fileElement, '', 'profile');
            $db->commit();
        }
        // If an exception occurred within the image adapter, it's probably an invalid image
        catch (Engine_Image_Adapter_Exception $e) {
            $db->rollBack();
            $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
        }
        // Otherwise it's probably a problem with the database or the storage system (just throw it)
        catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
  }
  public function backgroundphotoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Backgroundphoto();
    $form->populate($classroom->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getAdapter();
    $db->beginTransaction();
    try {
      $classroom->setBackgroundPhoto($_FILES['background'], 'background');
      $classroom->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'classroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }
  public function removeBackgroundphotoAction() {
    $classroom = Engine_Api::_()->core()->getSubject();
    $classroom->background_photo_id = 0;
    $classroom->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'classroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }
  public function designAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Viewdesign();
    $form->classroomstyle->setValue($classroom->classroomstyle);
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    $classroom->classroomstyle = $_POST['classroomstyle'];
    $classroom->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'design', 'classroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }
    //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get current row
    $table = Engine_Api::_()->getDbTable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'eclassroom')
            ->where('id = ?', $classroom->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Style();
    // Check post
    if (!$this->getRequest()->isPost()) {
      $form->populate(array(
          'style' => ( null === $row ? '' : $row->style )
      ));
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Cool! Process
    $style = $form->getValue('style');
    // Save
    if (null == $row) {
      $row = $table->createRow();
      $row->type = 'eclassroom';
      $row->id = $classroom->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }
   //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Seo();

    $form->populate($classroom->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getAdapter();
    $db->beginTransaction();
    try {
      $classroom->setFromArray($_POST);
      $classroom->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
    public function overviewAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Overview();
    $form->populate($classroom->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getAdapter();
    $db->beginTransaction();
    try {
      $classroom->setFromArray($_POST);
      $classroom->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
   //get style detail
  public function openHoursAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    if ($this->getRequest()->isPost()) {
      $openHours = Engine_Api::_()->getDbTable('openhours', 'eclassroom')->getClassroomHours(array('classroom_id' => $classroom->getIdentity()));
      $data = array();
      $dayOption = $_POST['hours'];
      $data['type'] = $dayOption;
      if ($dayOption == "selected") {
        for ($i = 1; $i < 8; $i++) {
          if (!empty($_POST['checkbox' . $i]) && !empty($_POST[$i])) {
            foreach ($_POST[$i] as $key => $value) {
              $startTime = $value['starttime'];
              $endTime = $value['endtime'];
              if ($startTime && $endTime) {
                $data[$i][$key]['starttime'] = $startTime;
                $data[$i][$key]['endtime'] = $endTime;
              }
            }
          }
        }
      }
      $openHoursTable = Engine_Api::_()->getDbTable('openhours', 'eclassroom');
      $db = $openHoursTable->getAdapter();
      $db->beginTransaction();
      try {
        if ($_POST['hours'] == "closed") {
          $classroom->status = 0;
          $classroom->save();
        } else {
          $classroom->status = 1;
          $classroom->save();
        }
        if (!$openHours)
          $openHours = $openHoursTable->createRow();
        $values['params'] = json_encode($data);
        $values['classroom_id'] = $classroom->getIdentity();
        $values['timezone'] = $_POST['timezone'];
        $openHours->setFromArray($values);
        $openHours->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
    $this->view->hoursData = "";
    //fetch data
    $hoursData = Engine_Api::_()->getDbTable('openhours', 'eclassroom')->getClassroomHours(array('classroom_id' => $classroom->getIdentity()));
    if ($hoursData) {
      $this->view->hoursData = json_decode($hoursData->params, true);
      $this->view->timezone = $hoursData->timezone;
    }
  }
  public function postAttributionAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $value = $this->_getParam('value', '');
    if (strlen($value)) {
      $res = Engine_Api::_()->getDbTable('postattributions', 'eclassroom')->getClassroomPostAttribution(array('classroom_id' => $classroom->getIdentity(), 'return' => 1));
      if ($res) {
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      } else {
        $table = Engine_Api::_()->getDbTable('postattributions', 'eclassroom');
        $res = $table->createRow();
        $res->classroom_id = $classroom->getIdentity();
        $res->user_id = $viewer->getIdentity();
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      }
    }
    $this->view->attribution = Engine_Api::_()->getDbTable('postattributions', 'eclassroom')->getClassroomPostAttribution(array('classroom_id' => $classroom->getIdentity()));
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Attribution(array('classroomItem' => $classroom));
    $form->attribution->setValue($this->view->attribution);
  }
  public function announcementAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('eclassroom', $this->view->viewer(), 'auth_announce'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'eclassroom')
            ->getClassroomAnnouncementPaginator(array('classroom_id' => $classroom->classroom_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
   public function postAnnouncementAction() {
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Postannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcementTable = Engine_Api::_()->getDbTable('announcements', 'eclassroom');
    $db = $announcementTable->getAdapter();
    $db->beginTransaction();
    try {
      $announcement = $announcementTable->createRow();
      $announcement->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'classroom_id' => $classroom->classroom_id), $form->getValues()));
      $announcement->save();
      $db->commit();
      // Redirect
      $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'announcement', 'classroom_id' => $classroom->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editAnnouncementAction() {
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('eclassroom_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Editannouncement();
    $form->title->setValue($announcement->title);
    $form->body->setValue($announcement->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->title = $_POST['title'];
    $announcement->body = $_POST['body'];
    $announcement->save();
    $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'announcement', 'classroom_id' => $classroom->custom_url));
  }

  public function deleteAnnouncementAction() {
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
     $this->view->form = $form = new Eclassroom_Form_Dashboard_Deleteannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if($this->_getParam('id')) {
        $announcement = Engine_Api::_()->getItem('eclassroom_announcement', $this->_getParam('id'));
         $announcement->delete();
    } else if(isset($_POST['ids']) && !empty($_POST['ids'])) {
        $ids = explode(",",$_POST['ids']);
        foreach($ids as $id){

             $announcement = Engine_Api::_()->getItem('eclassroom_announcement',$id);
             if(!empty($announcement)) {
                 $announcement->delete();
             }
        }
    } else {
      $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'announcement', 'classroom_id' => $classroom->custom_url));
    }
    $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'announcement', 'classroom_id' => $classroom->custom_url));
  }
  public function linkedClassroomAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('linkclassrooms', 'eclassroom')
        ->getLinkClassroomPaginator(array('classroom_id' => $classroom->classroom_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    if (!$this->getRequest()->isPost() || empty($_POST['classroom_id']))
      return;
    $linkClassroom = Engine_Api::_()->getItem('classroom', $_POST['classroom_id']);
    $ClassroomOwner = Engine_Api::_()->getItem('user', $linkClassroom->owner_id);
    $classroomLinkTable = Engine_Api::_()->getDbTable('linkclassrooms', 'eclassroom');
    $db = $classroomLinkTable->getAdapter();
    $db->beginTransaction();
    try {
      $linkedClassroom = $classroomLinkTable->createRow();
      $linkedClassroom->setFromArray(array(
          'user_id' => $viewer->getIdentity(),
          'classroom_id' => $classroom->classroom_id,
          'link_classroom_id' => $_POST['classroom_id']));
      $linkedClassroom->save();
      $db->commit();
     if ($ClassroomOwner->getIdentity() != $viewer->getIdentity())
       Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($ClassroomOwner, $viewer, $linkClassroom, 'eclassroom_link_classroom');
      $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'linked-classroom', 'classroom_id' => $classroom->custom_url));
      
      Engine_Api::_()->getApi('mail', 'core')->sendSystem($ClassroomOwner, 'eclassroom_link_classroom', array('classroom_name' => $classroom->getTitle(),'linkclassroom_name'=>$linkClassroom->getTitle(),'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST']));
       
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
   public function advertiseClassroomAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
  }
   // Send Update who like, follow and join classroom
  public function sendUpdatesAction() {
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_id');
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type');
    if (!$id || !$type)
      return;
    // Make form
    $this->view->form = $form = new Eclassroom_Form_Dashboard_SendUpdates();
    // Try attachment getting stuff
    $attachment = Engine_Api::_()->getItem($type, $id);
    // Check method/data
    if (!$this->getRequest()->isPost())
      return;
    if (!$form->isValid($this->getRequest()->getPost()))
      return;
    $values = $form->getValues();
    $likeMemberIds = $followMemberIds = array();
    if (in_array('liked', $values['type'])) {
      $likeMembers = Engine_Api::_()->courses()->getMemberByLike($attachment->getIdentity(),'eclassroom');
      foreach ($likeMembers as $likeMember) {
        $likeMemberIds[] = $likeMember['poster_id'];
      }
    }
    if (in_array('followed', $values['type'])) {
      $followMembers = Engine_Api::_()->courses()->getMemberFollow($attachment->getIdentity(),'eclassroom');
      foreach ($followMembers as $followMember) {
        $followMemberIds[] = $followMember['owner_id'];
      }
    }
    if (in_array('joined', $values['type'])) {
    }
    $recipientsUsers = array_unique(array_merge($likeMemberIds, $followMemberIds));

    // Process
    $db = Engine_Api::_()->getDbTable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      // Create conversation
      foreach ($recipientsUsers as $user) {
        $user = Engine_Api::_()->getItem('user', $user);
        if ($user->getIdentity() == $viewer->getIdentity()) {
          continue;
        }
        $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send($viewer, $user, $values['title'], $values['body'], $attachment);
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $conversation, 'message_new');
        Engine_Api::_()->getDbTable('statistics', 'core')->increment('messages.creations');
      }
      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    if ($this->getRequest()->getParam('format') == 'smoothbox') {
      return $this->_forward('success', 'utility', 'core', array(
                  'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your update message has been sent successfully.')),
                  'smoothboxClose' => true,
      ));
    }
  }
 public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $users = array();
    $roleTable = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('classroom_id =?', $this->_getParam('classroom_id', null))->query()->fetchAll();
    foreach ($roleIds as $roleID) {
      $roleIDArray[] = $roleID['user_id'];
    }
    $diffIds = array_merge($users, $roleIDArray);
    $users_table = Engine_Api::_()->getDbTable('users', 'user');
    $usersTableName = $users_table->info('name');
    $select = $users_table->select()->where('displayname  LIKE ? ', '%' . $this->_getParam('text') . '%');
    if ($diffIds)
      $select->where($usersTableName . '.user_id NOT IN (?)', $diffIds);
    $select->order('displayname ASC')->limit('40');
    $users = $users_table->fetchAll($select);
    foreach ($users as $user) {
      $user_icon_photo = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }
 public function classroomRolesAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    if (!Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'bs_allow_roles'))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->classroomRoles = Engine_Api::_()->getDbTable('memberroles', 'eclassroom')->getLevels(array('status' => true));
    $roleTable = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('classroom_id =?', $classroom->getIdentity())->order('memberrole_id ASC')->query()->fetchAll();
  }

  public function changeClassroomAdminAction() {
    $classroomrole_id = $this->_getParam('classroomrole_id', '');
    $classroomroleid = $this->_getParam('classroomroleid', '');
    $classroom = $this->_getParam('classroom_id', '');
    $roleTable = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    if (!$classroomroleid) {
      $roleId = $this->_getParam('roleId', '');
      $roleIds = $roleTable->select()->from($roleTable->info('name'), '*')->where('classroom_id =?', $this->_getParam('classroom_id', null))->where('classroomrole_id =?', $classroomrole_id);
      $classroomRole = $roleTable->fetchRow($roleIds);
      if (!($classroomRole)) {
        echo 0;
        die;
      }
      $classroomRole->memberrole_id = $roleId;
      $classroomRole->save();
    } else {
      $classroomRole = Engine_Api::_()->getItem('eclassroom_classroomroles', $classroomroleid);
      $classroomRole->delete();
    }
    $this->view->classroom = $classroom = Engine_Api::_()->getItem('classroom', $classroom);
    $this->view->is_ajax = 1;
    $this->view->classroomRoles = Engine_Api::_()->getDbTable('memberroles', 'eclassroom')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('classroom_id =?', $classroom->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/classroom-roles.tpl');
  }
  public function addClassroomAdminAction() {
    if (!count($_POST)) {
      echo 0;
      die;
    }
    $user_id = $this->_getParam('user_id', '');
    $classroom_id = $this->_getParam('classroom_id', '');
    $roleId = $this->_getParam('roleId', '');
    $roleTable = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('classroom_id =?', $this->_getParam('classroom_id', null))->where('user_id =?', $user_id)->query()->fetchAll();
    if (count($roleIds)) {
      echo 0;
      die;
    }
    $classroomRoleTable = Engine_Api::_()->getDbTable('classroomroles', 'eclassroom');
    $classrooRole = $classroomRoleTable->createRow();
    $classrooRole->user_id = $user_id;
    $classrooRole->classroom_id = $classroom_id;
    $classrooRole->memberrole_id = $roleId;
    $classrooRole->save();
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->classroom = $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    $classrooRole = Engine_Api::_()->getItem('eclassroom_memberrole', $roleId);
    $title = array('roletitle' => $classrooRole->title);
    //notification
//     Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $classroom->getOwner(), $classroom, 'eclassroom_classroomroll_ctbs', $title);

    //mail
//     Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_eclassroom_classroomroll_createclassroom', array('classroom_name' => $classroom->getTitle(), 'sender_title' => $classroom->getOwner()->getTitle(), 'object_link' => $classroom->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'role_title' => $classrooRole->title));

    $this->view->is_ajax = 1;
    $this->view->classroomRoles = Engine_Api::_()->getDbTable('memberroles', 'eclassroom')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('classroom_id =?', $classroom->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/classroom-roles.tpl');
  }
  public function manageServiceAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Permission check
    $enableService = Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'service');
    if (empty($enableService)) {
      return $this->_forward('requireauth', 'error', 'core');
    }
    $classroom_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.service', 1);
    if(empty($classroom_allow_service))
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'eclassroom')->getServiceMemers(array('classroom_id' => $classroom->classroom_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
   public function addserviceAction() {
    $classroom_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.service', 1);
    if(empty($classroom_allow_service))
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    $this->view->classroom_id = $classroom_id = $this->_getParam('classroom_id', null);
    $this->view->type = $type = $this->_getParam('type', 'sitemember');
    $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    if (!$is_ajax) {
      //Render Form
      $this->view->form = $form = new Eclassroom_Form_Service_Add();
      $form->setTitle('Add New Service');
      $form->setDescription("Here, you can enter your service details.");
    }
    if ($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('services', 'eclassroom');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $_POST;
        $values['classroom_id'] = $classroom_id;
        $values['owner_id'] = $viewer_id;
        if (empty($values['photo_id'])) {
          $values['photo_id'] = 0;
        }
        $row = $table->createRow();
        $row->setFromArray($values);
        $row->save();
        if (isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['photo_id'], array(
              'parent_id' => $row->service_id,
              'parent_type' => 'eclassroom_service',
              'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $row->photo_id = $filename->file_id;
          $row->save();
        }
        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('services', 'eclassroom')->getServiceMemers(array('classroom_id' => $classroom->classroom_id));
        $showData = $this->view->partial('_services.tpl', 'eclassroom', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'classroom_id' => $classroom->classroom_id, 'is_ajax' => true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));
        exit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;
        die;
      }
    }
  }

  public function editserviceAction() {
    $classroom_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.allow.service', 1);
    if(empty($classroom_allow_service))
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();
    $this->view->classroom_id = $classroom_id = $this->_getParam('classroom_id', null);
    $classroom = Engine_Api::_()->getItem('classroom', $classroom_id);
    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $this->view->service = $service = Engine_Api::_()->getItem('eclassroom_service', $service_id);
    if (!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Eclassroom_Form_Service_Edit();
      // Populate form
      $form->populate($service->toArray());
    }
    if ($is_ajax) {
      if (empty($_POST['photo_id']))
        unset($_POST['photo_id']);
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $service->setFromArray($_POST);
        $service->save();
        if (isset($_FILES['photo_id']['name']) && $_FILES['photo_id']['name'] != '') {
          $previousPhoto = $service->photo_id;
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($_FILES['photo_id'], array(
              'parent_id' => $service->service_id,
              'parent_type' => 'eclassroom_service',
              'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          if ($previousPhoto) {
            $catIcon = Engine_Api::_()->getItem('storage_file', $previousPhoto);
            $catIcon->delete();
          }
          $service->photo_id = $filename->file_id;
          $service->save();
        }
        if (isset($_POST['remove_profilecover']) && !empty($_POST['remove_profilecover'])) {
          $storage = Engine_Api::_()->getItem('storage_file', $service->photo_id);
          $service->photo_id = 0;
          $service->save();
          if ($storage)
            $storage->delete();
        }
        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('services', 'eclassroom')->getServiceMemers(array('classroom_id' => $classroom->classroom_id));
        $showData = $this->view->partial('_services.tpl', 'eclassroom', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'classroom_id' => $classroom->classroom_id, 'is_ajax' => true));
        echo Zend_Json::encode(array('status' => 1, 'message' => $showData));
        exit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;
        die;
      }
    }
  }
  public function deleteserviceAction() {
    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->classroom_id = $classroom_id = $this->_getParam('classroom_id', null);
    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $item = Engine_Api::_()->getItem('eclassroom_service', $service_id);
    if (!$is_ajax) {
      $this->view->form = $form = new Eclassroom_Form_Service_Delete();
    }
    if ($is_ajax) {
      $db = $item->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $item->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
        echo 0;
        die;
      }
    }
  }
  public function manageLocationAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('eclassroom.enable.location', 1) || !Engine_Api::_()->authorization()->isAllowed('eclassroom', $viewer, 'allow_mlocation'))
      return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('locations', 'eclassroom')
            ->getClassroomLocationPaginator(array('classroom_id' => $classroom->classroom_id));
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function addLocationAction() {
    $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Addlocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_eclassroom_locations', array('is_default' => 0), array('classroom_id =?' => $classroom->classroom_id));
      }
      $dbGetInsert->query('INSERT INTO engine4_eclassroom_locations (classroom_id,title,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $classroom->classroom_id . '","' . $_POST['title'] . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '","' . $_POST['is_default'] . '") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $classroom->classroom_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "classrooms")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $classroom->location = $_POST['location'];
        $classroom->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'classroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }
  public function editLocationAction() {
    $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Editlocation();
    $location = Engine_Api::_()->getItem('eclassroom_location', $this->_getParam('location_id'));
    $form->title->setValue($location->title);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_eclassroom_locations', array('is_default' => 0), array('classroom_id =?' => $classroom->classroom_id));
      }
      $location->lat = $_POST['lat'];
      $location->title = $_POST['title'];
      $location->lng = $_POST['lng'];
      $location->city = $_POST['city'];
      $location->state = $_POST['state'];
      $location->country = $_POST['country'];
      $location->address = $_POST['address'];
      $location->address2 = $_POST['address2'];
      $location->venue = $_POST['venue'];
      $location->location = $_POST['location'];
      $location->is_default = isset($_POST['is_default']) ? $_POST['is_default'] : 0;
      $location->zip = $_POST['zip'];
      $location->save();
      if ($location->is_default || (isset($_POST['is_default']) && !empty($_POST['is_default']))) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $classroom->classroom_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "classrooms")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $classroom->location = $_POST['location'];
        $classroom->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'classroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }
  public function deleteLocationAction() {
    $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Deletelocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $location = Engine_Api::_()->getItem('eclassroom_location', $this->_getParam('location_id'));
    $location->delete();

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'classroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }

   public function addPhotosAction() {
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->location = $location = Engine_Api::_()->getItem('eclassroom_location', $this->_getParam('location_id'));
  }

  public function composeUploadAction() {
    if (!Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->_redirect('login');
      return;
    }
    $location = Engine_Api::_()->getItem('eclassroom_location', $this->_getParam('location_id'));
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid method');
      return;
    }
    if (empty($_FILES['Filedata'])) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }

    // Get album
    $viewer = Engine_Api::_()->user()->getViewer();
    $photoTable = Engine_Api::_()->getItemTable('eclassroom_locationphoto');
    $db = $photoTable->getAdapter();
    $db->beginTransaction();
    try {
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
          'owner_type' => 'user',
          'owner_id' => Engine_Api::_()->user()->getViewer()->getIdentity()
      ));
      $photo->save();
      $photo->setPhoto($_FILES['Filedata']);
      $photo->classroom_id = $location->classroom_id;
      $photo->location_id = $location->location_id;
      $photo->save();
      $db->commit();
      $this->view->status = true;
      $this->view->locationphoto_id = $photo->locationphoto_id;
      $this->view->src = $this->view->url = $photo->getPhotoUrl('thumb.normalmain');
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected photos have been successfully saved.');
      echo json_encode(array('src' => $this->view->src, 'location_id' => $location->location_id, 'locationphoto_id' => $this->view->locationphoto_id, 'status' => $this->view->status));
      die;
    } catch (Exception $e) {
      throw $e;
      $db->rollBack();
      //throw $e;
      $this->view->status = false;
    }
  }
    //ACTION FOR PHOTO DELETE
  public function removeAction() {
    if (empty($_POST['locationphoto_id']))
      die('error');
    //GET PHOTO ID AND ITEM
    $photo_id = (int) $this->_getParam('locationphoto_id');
    $photo = Engine_Api::_()->getItem('eclassroom_locationphoto', $photo_id);
    $db = Engine_Api::_()->getItemTable('eclassroom_locationphoto')->getAdapter();
    $db->beginTransaction();
    try {
      $photo->delete();
      $db->commit();
      echo true;
      die;
    } catch (Exception $e) {
      $db->rollBack();
    }
    echo false;
    die;
  }
  public function removeMainphotoAction() {
    //GET Store ID AND ITEM
    $classroom = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('classrooms', 'eclassroom')->getAdapter();
    $db->beginTransaction();
    try {
      $classroom->photo_id = '';
      $classroom->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'clasroom_id' => $classroom->custom_url), "eclassroom_dashboard", true);
  }
  public function manageCoursesAction(){
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
    parse_str($_POST['searchParams'], $searchArray);
    if ($this->getRequest()->isPost()) {
        $values = $this->getRequest()->getPost();
        foreach ($values as $key => $valueCourse) {
            if ($key == 'delete_' . $valueCourse) {
                $course = Engine_Api::_()->getItem('courses', $valueCourse);
                if(count($course))
                    $course->delete();
            }
        }
    }
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $value['title'] = isset($searchArray['title']) ? $searchArray['title'] : '';
    $value['owner_name'] = isset($searchArray['owner_name']) ? $searchArray['owner_name'] : '';
    $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
    $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
    $value['category_id'] = isset($searchArray['category_id']) ? $searchArray['category_id'] : '';
    $value['classroom_id'] = $classroom->getIdentity();
    $value['manage-dashborad'] = true; 
    $value['manage-widget'] = true; 
    $this->view->formFilter = $formFilter = new Eclassroom_Form_Dashboard_ManageCourse();
    if($value)
    $formFilter->populate($value);
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $user_id = $this->view->user_id = $this->_getParam('user_id', null);
    $classroom_id = $classroom->getIdentity();
    // Create form
    $this->view->courses = $paginator = Engine_Api::_()->getDbTable('courses', 'courses')->getCoursePaginator($value);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($this->_getparam('page',1));
  }
  public function manageOrdersAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $viewer = $this->view->viewer();
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $this->view->searchForm = $searchForm = new Eclassroom_Form_Searchorder();
    $viewer = Engine_Api::_()->user()->getViewer();

    $value['order_id'] = isset($searchArray['order_id']) ? $searchArray['order_id'] : '';
    $value['buyer_name'] = isset($searchArray['buyer_name']) ? $searchArray['buyer_name'] : '';
    $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
    $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
    $value['order_min'] = isset($searchArray['order']['order_min']) ? $searchArray['order']['order_min'] : '';
    $value['order_max'] = isset($searchArray['order']['order_max']) ? $searchArray['order']['order_max'] : '';
    $value['commision_min'] = isset($searchArray['commision']['commision_min']) ? $searchArray['commision']['commision_min'] : '';
    $value['commision_max'] = isset($searchArray['commision']['commision_max']) ? $searchArray['commision']['commision_max'] : '';
    $value['gateway'] = isset($searchArray['gateway']) ? $searchArray['gateway'] : '';
    $value['classroom_id'] = $classroom->getIdentity() ? $classroom->getIdentity() : $this->_getParam('classroom_id'); 
    
    $this->view->orders = $orders = Engine_Api::_()->getDbtable('ordercourses', 'courses')->coursesOrders($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }
   public function manageClassroomappsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $getManageclassroomId = Engine_Api::_()->getDbTable('manageclassroomapps', 'eclassroom')->getManageclassroomId(array('classroom_id' => $classroom->classroom_id));
    $this->view->manageclassroomapps = Engine_Api::_()->getItem('eclassroom_manageclassroomapps', $getManageclassroomId);
    $viewer = Engine_Api::_()->user()->getViewer();
  }
  public function manageclassroomonoffappsAction() {
    $classroomType = $this->_getParam('type', 'photos');
    $classroomId = $this->_getParam('classroom_id', null);
    if (empty($classroomId))
      return;
    $isCheck = Engine_Api::_()->getDbTable('manageclassroomapps', 'eclassroom')->isCheck(array('classroom_id' => $classroomId, 'columnname' => $classroomType));
    $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
    if ($isCheck) {
      $dbGetInsert->update('engine4_eclassroom_manageclassroomapps', array($classroomType => 0), array('classroom_id =?' => $classroomId));
    } else {
      $dbGetInsert->update('engine4_eclassroom_manageclassroomapps', array($classroomType => 1), array('classroom_id =?' => $classroomId));
    }
    echo true;
    die;
  }
    public function searchMemberAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $userTable = Engine_Api::_()->getItemTable('user');
    $selectUserTable = $userTable->select()->where('displayname LIKE "%' . $this->_getParam('text', '') . '%"')->where('user_id !=?', $this->view->viewer()->getIdentity());
    $users = $userTable->fetchAll($selectUserTable);
    foreach ($users as $user) {
      $user_icon = $this->view->itemPhoto($user, 'thumb.icon');
      $sesdata[] = array(
          'id' => $user->user_id,
          'user_id' => $user->user_id,
          'label' => $user->displayname,
          'photo' => $user_icon
      );
    }
    return $this->_helper->json($sesdata);
  }
  public function searchClassroomAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $viewerId = $this->view->viewer()->getIdentity();
    $classroomTable = Engine_Api::_()->getItemTable('classroom');
    $linkClassroomTable = Engine_Api::_()->getDbTable('linkclassrooms', 'eclassroom');
    $select = $linkClassroomTable->select()
            ->from($linkClassroomTable->info('name'), 'link_classroom_id')
            ->where('user_id =?', $viewerId);
    $linkedClassroom = $classroomTable->fetchAll($select)->toArray();
    $selectClassroomTable = $classroomTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    if (count($linkedClassroom) > 0)
      $selectClassroomTable->where('classroom_id NOT IN(?)', $linkedClassroom);

    $classrooms = $classroomTable->fetchAll($selectClassroomTable);
    foreach ($classrooms as $classroom) {
      $classroom_icon = $this->view->itemPhoto($classroom, 'thumb.icon');
      $sesdata[] = array(
          'id' => $classroom->classroom_id,
          'user_id' => $classroom->owner_id,
          'label' => $classroom->title,
          'photo' => $classroom_icon
      );
    }
    return $this->_helper->json($sesdata);
  }
   function manageNotificationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Notification();
    if ($this->getRequest()->getPost() && $form->isValid($this->getRequest()->getPost())) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      $dbGetInsert->query("DELETE FROM engine4_eclassroom_notifications WHERE user_id = " . $viewer->getIdentity() . ' AND classroom_id =' . $classroom->getIdentity());
      $values = $form->getValues();
      // Process
      $table = Engine_Api::_()->getDbTable('notifications', 'eclassroom');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        foreach ($values as $key => $value) {
          if ($key != "notification_type") {
            foreach ($value as $noti) {
              $this->createNotification($noti, $table, $classroom->getIdentity(), $viewer->getIdentity());
            }
          } else {
            $this->createNotification($value, $table, $classroom->getIdentity(), $viewer->getIdentity(), $key);
          }
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
    $notifications = Engine_Api::_()->getDbTable('notifications', 'eclassroom')->getNotifications(array('classroom_id' => $classroom->getIdentity(), 'getAll' => true));
    if (count($notifications)) {
      $notificationArray = array();
      foreach ($notifications as $noti) {
        if ($noti->type == "notification_type") {
          $form->notification_type->setValue($noti->value);
        } else {
          $notificationArray[] = $noti->type;
        }
      }
      $form->notifications->setValue($notificationArray);
    }
  }
  function createNotification($val, $table, $classroom_id, $user_id, $key = "") {
    $noti = $table->createRow();
    $noti->classroom_id = $classroom_id;
    $noti->user_id = $user_id;
    if ($key == "notification_type") {
      $noti->type = $key;
      $noti->value = $val;
    } else {
      $noti->type = $val;
      $noti->value = 1;
    }
    $noti->save();
    return $noti;
  }
  public function profileFieldAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
      //Classroom Category and profile fileds
      $this->view->defaultProfileId = $defaultProfileId = 1;
      if (isset($classroom->category_id) && $classroom->category_id != 0)
          $this->view->category_id = $classroom->category_id;
      else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
          $this->view->category_id = $_POST['category_id'];
      else
          $this->view->category_id = 0;
      if (isset($classroom->subsubcat_id) && $classroom->subsubcat_id != 0)
          $this->view->subsubcat_id = $classroom->subsubcat_id;
      else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
          $this->view->subsubcat_id = $_POST['subsubcat_id'];
      else
          $this->view->subsubcat_id = 0;
      if (isset($classroom->subcat_id) && $classroom->subcat_id != 0)
          $this->view->subcat_id = $classroom->subcat_id;
      else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
          $this->view->subcat_id = $_POST['subcat_id'];
      else
          $this->view->subcat_id = 0;
      //Classroom category and profile fields
      $viewer = Engine_Api::_()->user()->getViewer();
      // Create form
      $this->view->form = $form = new Eclassroom_Form_Dashboard_Profilefield(array('defaultProfileId' => $defaultProfileId));
      $this->view->category_id = $classroom->category_id;
      $this->view->subcat_id = $classroom->subcat_id;
      $this->view->subsubcat_id = $classroom->subsubcat_id;
      $form->populate($classroom->toArray());
      if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
          return;
      // Process
      $db = Engine_Api::_()->getItemTable('classroom')->getAdapter();
      $db->beginTransaction();
      try {
          //Add fields
          $customfieldform = $form->getSubForm('fields');
          if ($customfieldform) {
              $customfieldform->setItem($classroom);
              $customfieldform->saveValues();
          }
          $classroom->save();
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }
      $db->beginTransaction();
      try {
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }
      // Redirect
      $this->_redirectCustom(array('route' => 'eclassroom_dashboard', 'action' => 'profile-field', 'classroom_id' => $classroom->custom_url));
  }
  public function salesStatsAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
      $viewer = Engine_Api::_()->user()->getViewer();
      $this->view->todaySale = Engine_Api::_()->getDbtable('orders', 'courses')->getSaleStats(array('stats' => 'today', 'classroom_id' => $classroom->classroom_id));
      $this->view->weekSale = Engine_Api::_()->getDbtable('orders', 'courses')->getSaleStats(array('stats' => 'week', 'classroom_id' => $classroom->classroom_id));
      $this->view->monthSale = Engine_Api::_()->getDbtable('orders', 'courses')->getSaleStats(array('stats' => 'month', 'classroom_id' => $classroom->classroom_id));
      //get getCoursesStats
      $this->view->classroomStatsSale = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseStats(array('classroom_id' => $classroom->classroom_id));
  }
   //get sales report
    public function salesReportsAction() {
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $this->view->classroom = $classroom = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->form = $form = new Eclassroom_Form_Dashboard_Searchsalereport();
        $value = array();
        if (isset($_GET['course_id']))
            $value['course_id'] = $_GET['course_id'];
        if (isset($_GET['startdate']))
            $value['startdate'] = $value['start'] = date('Y-m-d', strtotime($_GET['startdate']));
        if (isset($_GET['enddate']))
            $value['enddate'] = $value['end'] = date('Y-m-d', strtotime($_GET['enddate']));
        if (isset($_GET['type']))
            $value['type'] = $_GET['type'];
        if (!count($value)) {
            $value['enddate'] = date('Y-m-d', strtotime(date('Y-m-d')));
            $value['startdate'] = date('Y-m-d', strtotime('-30 days'));
            $value['type'] = $form->type->getValue();
        }
        if(isset($_GET['excel']) && $_GET['excel'] != '')
            $value['download'] = 'excel';
        if(isset($_GET['csv']) && $_GET['csv'] != '')
            $value['download'] = 'csv';
        $form->populate($value);
        $value['classroom_id'] = $classroom->getIdentity();

        $this->view->classroomSaleData = $data = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseReportData($value);

        if(isset($value['download'])){
            $name = str_replace(' ','_',$classroom->getTitle()).'_'.time();
            switch($value["download"])
            {
                case "excel" :
                    // Submission from
                    $filename = $name . ".xls";
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=\"$filename\"");
                    $this->exportFile($data);
                    exit();
                case "csv" :
                    // Submission from
                    $filename = $name . ".csv";
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
                    header("Content-type: text/csv");
                    header("Content-Disposition: attachment; filename=\"$filename\"");
                    header("Expires: 0");
                    $this->exportCSVFile($data);
                    exit();
                default :
                    //silence
                    break;
            }
        }

    }
    protected function exportCSVFile($records) {
        // create a file pointer connected to the output stream
        $fh = fopen( 'php://output', 'w' );
        $heading = false;
        $counter = 1;
        if(!empty($records))
            foreach($records as $row) {
                $valueVal['S.No'] = $counter;
                $valueVal['Date of Purchase'] = ($row['creation_date']);
                $valueVal['Quatity'] = $row['total_orders'];
                $valueVal['Total Tax Amount'] = Engine_Api::_()->courses()->getCurrencyPrice($row['total_billingtax_cost'],$defaultCurrency);
                $valueVal['Commission Amount'] = Engine_Api::_()->courses()->getCurrencyPrice($row['commission_amount'],$defaultCurrency);
                $valueVal['Total Amount'] = Engine_Api::_()->courses()->getCurrencyPrice($row['total_amount'],$defaultCurrency);
                $counter++;
                if(!$heading) {
                    // output the column headings
                    fputcsv($fh, array_keys($valueVal));
                    $heading = true;
                }
                // loop over the rows, outputting them
                fputcsv($fh, array_values($valueVal));

            }
        fclose($fh);
    }
    protected function exportFile($records) {
        $heading = false;
        $counter = 1;
        $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency();
        if(!empty($records))
            foreach($records as $row) {
                $valueVal['S.No'] = $counter;
                $valueVal['Date of Purchase'] = ($row['creation_date']);
                $valueVal['Quatity'] = $row['total_orders'];
                $valueVal['Total Tax Amount'] = Engine_Api::_()->courses()->getCurrencyPrice($row['total_billingtax_cost'],$defaultCurrency);
                $valueVal['Commission Amount'] = Engine_Api::_()->courses()->getCurrencyPrice($row['commission_amount'],$defaultCurrency);
                $valueVal['Total Amount'] = Engine_Api::_()->courses()->getCurrencyPrice($row['total_amount'],$defaultCurrency);
                $counter++;
                if(!$heading) {
                    // display field/column names as a first row
                    echo implode("\t", array_keys($valueVal)) . "\n";
                    $heading = true;
                }
                echo implode("\t", array_values($valueVal)) . "\n";
            }
        exit;
    }
}
