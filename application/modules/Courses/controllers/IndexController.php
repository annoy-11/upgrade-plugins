<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: IndexController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_IndexController extends Core_Controller_Action_Standard
{
    public function init() {
      if (!$this->_helper->requireAuth()->setAuthParams('courses', null, 'view')->isValid())
      return;
    }
    public function welcomeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }
    public function homeAction() {
        //Render
        $this->_helper->content->setEnabled();
    }
    public function indexAction()
    {
        //Render
        $this->_helper->content->setEnabled();
    }
    public function browseAction() {
        //Render
        $this->_helper->content->setEnabled();
    }
    public function browseInstructorAction() {
        //Render
        $this->_helper->content->setEnabled();
    }
    public function featuredAction() {
      //Render
      $this->_helper->content->setEnabled();
    }

    public function sponsoredAction() {
      //Render
      $this->_helper->content->setEnabled();
    }
    public function verifiedAction() {
      //Render
      $this->_helper->content->setEnabled();
    }
    public function hotAction() {
      //Render
      $this->_helper->content->setEnabled();
    }
    public function tagsAction() {
        //Render
        $this->_helper->content->setEnabled();
    }
    function compareAction(){
        // Render
        $this->_helper->content->setEnabled();
    }
    function browseReviewAction(){
        // Render
        $this->_helper->content->setEnabled();
    }
  public function createAction() {
    if (!$this->_helper->requireUser->isValid())
      return;
    if( !$this->_helper->requireAuth()->setAuthParams('courses', null, 'create')->isValid()) return;
    $viewer = $this->view->viewer();
    $quckCreate = 0;
    $this->view->classroomId = $classroomId = $this->_getParam('classroom_id',false);
    $profile = $this->_getParam('profile',false);
    $classroom = Engine_Api::_()->getItem('classroom', $classroomId);
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if ($settings->getSetting('course.category.selection', 0) && $settings->getSetting('course.quick.create', 0)) {
      $quckCreate = 1;
    }
    $this->view->quickCreate = $quckCreate;
    $totalCourse = Engine_Api::_()->getDbTable('courses', 'courses')->countCourses($viewer->getIdentity());
    $allowCourseCount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'course_count');
    $this->view->widget_id = $widget_id = $this->_getParam('widget_id', 0);
    //Render
    
    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);
    
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      // Render
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
      $this->_helper->layout->setLayout('default-simple');
      $layoutOri = $this->view->layout()->orientation;
      if ($layoutOri == 'right-to-left') {
        $this->view->direction = 'rtl';
      } else {
        $this->view->direction = 'ltr';
      }
      $language = explode('_', $this->view->locale()->getLocale()->__toString());
      $this->view->language = $language[0];
    } else {
      $this->_helper->content->setEnabled();
    }
    $this->view->createLimit = 1;
    if ($totalCourse >= $allowCourseCount && $allowCourseCount != 0) {
      $this->view->createLimit = 0;
    } else {
        $this->view->defaultProfileId = 1;
        $this->view->form = $form = new Courses_Form_Course_Create(array(
            'defaultProfileId' => 1,
            'smoothboxType' => $sessmoothbox,
        ));
    }
     if (!$this->getRequest()->isPost()) {
       return;
    }
    if( !$form->isValid($_POST) || $this->_getParam('is_ajax')){
        if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
            $custom_url = Engine_Api::_()->getDbtable('courses', 'courses')->checkCustomUrl($_POST['custom_url']);
            if ($custom_url) {
                $form->addError($this->view->translate("Custom URL is not available. Please select another URL."));
            }
        }
        //price check
        if(empty($_POST['price'])){
           $form->addError($this->view->translate('Price is required.'));
           $priceError = true;
        }
      //discount check
      if(!empty($_POST['discount'])){
        if(empty($_POST['price'])){
           $form->addError($this->view->translate('Price is required.'));
           $priceError = true;
        }
        if(!empty($_POST['discount_end_type']) && empty($_POST['discount_end_date'])){
          $form->addError($this->view->translate('Discount End Date is required.'));
        }
        if(empty($priceError) && empty($_POST['discount_type'])){
          if(empty($_POST['percentage_discount_value'])){
            $form->addError($this->view->translate('Discount Value is required.'));
          }else if($_POST['percentage_discount_value'] > 100){
              $form->addError($this->view->translate('Discount Value must be less than or equal to 100.'));
          }
        }else if(empty($priceError)){
          if(empty($_POST['fixed_discount_value'])){
            $form->addError($this->view->translate('Discount Value is required.'));
          }else if($_POST['fixed_discount_value'] > $_POST['price']){
             $form->addError($this->view->translate('Discount Value must be less than or equal to Price.'));
           }
        }
        //check discount dates
        if(!empty($_POST['discount_start_date'])){
            $time = $_POST['discount_start_date'].' '.(!empty($_POST['discount_start_date_time']) ? $_POST['discount_start_date_time'] : "00:00:00"); 
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($this->view->viewer()->timezone);
            $start = strtotime($time);
            if($start < time()){
               $timeDiscountError = true;
               $form->addError($this->view->translate('Discount Start Date field value must be greater than Current Time.'));
            }
            date_default_timezone_set($oldTz);
         }
         if(!empty($_POST['discount_end_date'])){
            $time = $_POST['discount_end_date'].' '.(!empty($_POST['discount_end_date_time']) ? $_POST['discount_end_date_time'] : "00:00:00");
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($this->view->viewer()->timezone);
            $start = strtotime($time);

            if($start < time()){
               $timeDiscountError = true;
               $form->addError($this->view->translate('Discount End Date field value must be greater than Current Time.'));
            }
          date_default_timezone_set($oldTz);
         }
         if(empty($timeDiscountError)){
            if(!empty($_POST['discount_start_date'])){
               if(!empty($_POST['discount_end_date'])){
                  $starttime = $_POST['discount_start_date'].' '.(!empty($_POST['discount_start_date_time']) ? $_POST['discount_start_date_time'] : "00:00:00");
                  $endtime = $_POST['discount_end_date'].' '.(!empty($_POST['discount_end_date_time']) ? $_POST['discount_end_date_time'] : "00:00:00");
                  $oldTz = date_default_timezone_get();
                  date_default_timezone_set($this->view->viewer()->timezone);
                  $start = strtotime($starttime);
                  $end = strtotime($endtime);
                  if($start > $end){
                      $form->addError($this->view->translate('Discount Start Date value must be less than Discount End Date field value.'));
                  }
                  date_default_timezone_set($oldTz);
               }
            }
         }
      }
      //avalability check
      if(empty($_POST['show_start_time'])){
        if(empty($_POST['start_date'])){
          //  $form->addError($this->view->translate('Start Time is required.'));
        }else{
          $time = $_POST['start_date'].' '.(!empty($_POST['start_date_time']) ? $_POST['start_date_time'] : "00:00:00");
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($this->view->viewer()->timezone);
          $start = strtotime($time);
          if($start < time()){
             $timeError = true;
             $form->addError($this->view->translate('Start Time must be greater than Current Time.'));
          }
          date_default_timezone_set($oldTz);
        }
      }
      if(!empty($_POST['show_end_time'])){
        if(empty($_POST['end_date'])){
            $form->addError($this->view->translate('End Time is required.'));
        }else{
          $time = $_POST['end_date'].' '.(!empty($_POST['end_date_time']) ? $_POST['end_date_time'] : "00:00:00");
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($this->view->viewer()->timezone);
          $end = strtotime($time);
          if($end < time()){
             $timeError = true;
             $form->addError($this->view->translate('End Time must be greater than Current Time.'));
          }
          date_default_timezone_set($oldTz);
        }
      }
      if(empty($timeError)){
        if(!empty($_POST['show_end_time'])){
           if(empty($_POST['show_start_time'])){
              $starttime = $_POST['start_date'].' '.(!empty($_POST['start_date_time']) ? $_POST['start_date_time'] : "00:00:00");
              $endtime = $_POST['end_date'].' '.(!empty($_POST['end_date_time']) ? $_POST['end_date_time'] : "00:00:00");
              //Convert Time Zone
              $oldTz = date_default_timezone_get();
              date_default_timezone_set($this->view->viewer()->timezone);
              $start = strtotime($starttime);
              $end = strtotime($endtime);

              if($end < $start){
                  $form->addError($this->view->translate('End Time must be greater than Start Time.'));
              }
			date_default_timezone_set($oldTz);
           }
        }
      }
      if(!$this->_getParam('is_ajax')){
        return;
      }
     $arrMessages = $form->getMessages();
     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
     $error = '';
     foreach($arrMessages as $field => $arrErrors) {
        if($field && intval($field) <= 0){
          $error .= sprintf(
              '<li>%s%s</li>',
              $form->getElement($field)->getLabel(),
              $view->formErrors($arrErrors)
          );
        }else{
           $error .= sprintf(
              '<li>%s</li>',
              $arrErrors
          );
        }
      }
      if($error)
        echo json_encode(array('status'=>0,'message'=>'<ul class="form-errors">'.$error."<ul>"));
      else
        echo json_encode(array('status'=>1));
      die;
     }
    $values = array();
    if (!$quckCreate) {
      $values = $form->getValues();
    }
    $values['owner_id'] = $viewer->getIdentity();
    $settings = Engine_Api::_()->getApi('settings', 'core');
    if (!$quckCreate && $settings->getSetting('courses.mainPhoto.mandatory', 1)) {
      if (isset($values['photo']) && empty($values['photo'])) {
        $form->addError(Zend_Registry::get('Zend_Translate')->_('Main Photo is a required field.'));
        return;
      }
    }
    if (isset($values['networks'])) {
      //Start Network Work
      $networkValues = array();
      foreach (Engine_Api::_()->getDbTable('networks', 'network')->fetchAll() as $network) {
        $networkValues[] = $network->network_id;
      }
      if (@$values['networks'])
        $values['networks'] = ',' . implode(',', $values['networks']);
      else
        $values['networks'] = '';
      //End Network Work
    }

    if (!isset($values['can_join']))
      $values['approval'] = $settings->getSetting('classroom.default.joinoption', 1) ? 0 : 1;

    $courseTable = Engine_Api::_()->getDbTable('courses', 'courses');
    $db = $courseTable->getAdapter();
    $db->beginTransaction();
    try {
      // Create courses
      $courses = $courseTable->createRow();
      if (!$quckCreate) {
        if (empty($values['category_id']))
          $values['category_id'] = 0;
        if (empty($values['subsubcat_id']))
          $values['subsubcat_id'] = 0;
        if (empty($values['subcat_id']))
          $values['subcat_id'] = 0;
      }
    if (!isset($values['discount_end_type']))
        $values['discount_end_type'] = 0;

    $courses->setFromArray($values);
    if(!isset($values['search']))
        $courses->search = 1;
    else
        $courses->search = $values['search'];
    if (isset($_POST['title'])) {
        $courses->title = $_POST['title'];
    }
    if (isset($_POST['subcat_id']))
        $courses->category_id = $_POST['category_id'];
    if (isset($_POST['subcat_id']))
        $courses->category_id = $_POST['category_id'];
    if (isset($_POST['subsubcat_id']))
        $courses->category_id = $_POST['category_id'];
    if (isset($_POST['draft']))
        $courses->draft = $_POST['draft'];

    $courses->parent_id = $parentId;
    $courses->save();

    // Other module work
    if(!empty($resource_type) && !empty($resource_id)) {
      $courses->resource_id = $resource_id;
      $courses->resource_type = $resource_type;
      $courses->save();
    }
			
    if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $courses->custom_url = $_POST['custom_url'];
    else
        $courses->custom_url = $courses->course_id;

    //upsell
    if(!empty($_POST['upsell_id'])){
        $upsell = trim($_POST['upsell_id'],',');
        $upsells = explode(',',$upsell);
        foreach($upsells as $item){
            $params['course_id'] = $courses->getIdentity();
            $params['resource_id'] = $item;
            Engine_Api::_()->getDbTable('upsells','courses')->create($params);
        }
    }
    //crosssell
    if(!empty($_POST['crosssell_id'])){
        $crosssell = trim($_POST['crosssell_id'],',');
        $crosssells = explode(',',$crosssell);
        foreach($crosssells as $item){
            $params['course_id'] = $courses->getIdentity();
            $params['resource_id'] = $item;
            Engine_Api::_()->getDbTable('crosssells','courses')->create($params);
        }
    }
    $customfieldform = $form->getSubForm('fields');
    if (!is_null($customfieldform)) {
        $customfieldform->setItem($courses);
        $customfieldform->saveValues();
    }
    // Auth
    $auth = Engine_Api::_()->authorization()->context;
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
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
        $auth->setAllowed($courses, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($courses, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($courses, $role, 'ltr_create', ($i <= $lectureCreate));
        $auth->setAllowed($courses, $role, 'tst_create', ($i <= $tstCreate));
    }

    $tags = preg_split('/[,]+/', $values['tags']);
    $courses->tags()->addTagMaps($viewer, $tags);
    $courses->seo_keywords = implode(',', $tags);
    $courses->save();
    if(!empty($classroom)) {
      $courses->classroom_id = $classroom->classroom_id;
      $classroom->course_count++;
      $classroom->save();
    }
    if(empty($_POST['show_start_time'])){
        if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
            $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_date_time'])) : '';
            $courses->starttime =$starttime;
        }
        if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
            //Convert Time Zone
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($viewer->timezone);
            $start = strtotime($_POST['start_date'].' '.(!empty($_POST['start_date_time']) ? $_POST['start_date_time'] : "00:00:00"));

            $courses->starttime = date('Y-m-d H:i:s', $start);
            date_default_timezone_set($oldTz);
        }
    }
    if(!empty($_POST['show_end_time'])){
        if(isset($_POST['end_date']) && $_POST['end_date'] != ''){
            $starttime = isset($_POST['end_date']) ? date('Y-m-d H:i:s',strtotime($_POST['end_date'].' '.$_POST['end_date_time'])) : '';
            $courses->endtime =$starttime;
        }
        if(isset($_POST['end_date']) && $viewer->timezone && $_POST['end_date'] != ''){
            //Convert Time Zone
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($viewer->timezone);
            $start = strtotime($_POST['end_date'].' '.(!empty($_POST['end_date_time']) ? $_POST['end_date_time'] : "00:00:00"));

            $courses->endtime = date('Y-m-d H:i:s', $start);
            date_default_timezone_set($oldTz);
        }
    }
    //discount
    if(!empty($_POST['show_end_time'])){
        if(isset($_POST['discount_start_date']) && $_POST['discount_start_date'] != ''){
            $starttime = isset($_POST['discount_start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['discount_start_date'].' '.$_POST['discount_start_date_time'])) : '';
            $courses->discount_start_date =$starttime;
        }
        if(isset($_POST['discount_start_date']) && $viewer->timezone && $_POST['discount_start_date'] != ''){
            //Convert Time Zone
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($viewer->timezone);
            $start = strtotime($_POST['discount_start_date'].' '.(!empty($_POST['discount_start_date_time']) ? $_POST['discount_start_date_time'] : "00:00:00"));

            $courses->discount_start_date = date('Y-m-d H:i:s', $start);
            date_default_timezone_set($oldTz);
        }
    }
    if(!empty($_POST['discount_end_date'])){
        if(isset($_POST['discount_end_date']) && $_POST['discount_end_date'] != ''){
            $starttime = isset($_POST['discount_end_date']) ? date('Y-m-d H:i:s',strtotime($_POST['discount_end_date'].' '.$_POST['discount_end_date_time'])) : '';
            $courses->discount_end_date =$starttime;
        }
        if(isset($_POST['discount_end_date']) && $viewer->timezone && $_POST['discount_end_date'] != ''){
            //Convert Time Zone
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($viewer->timezone);
            $start = strtotime($_POST['discount_end_date'].' '.(!empty($_POST['discount_end_date_time']) ? $_POST['discount_end_date_time'] : "00:00:00"));
            $courses->discount_end_date = date('Y-m-d H:i:s', $start);
            date_default_timezone_set($oldTz);
        }
    }
    if (!Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'auto_approve'))
        $courses->is_approved = 0;
    else
         $courses->is_approved = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'bs_featured'))
        $courses->featured = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'bs_sponsored'))
        $courses->sponsored = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'bs_verified'))
        $courses->verified = 1;
    if (Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'course_hot'))
        $courses->hot = 1;
        
    // Add photo
    if (isset($_FILES['photo']) && $_FILES['photo']['name'] != '') {
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('coursesalbum')) {
          $courses->setPhoto($form->photo, '', 'profile');
        } else {
          $courses->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,'courses','courses','',$courses,true);
        }
    }
    $courses->save();
    $coursename = '<a href="'.$courses->getHref().'">'.$courses->getTitle().'</a>';
      // Add activity only if courses is published
    if( $values['draft'] == 0 && $courses->is_approved == 1 && (!$courses->starttime || strtotime($courses->starttime) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $courses, 'courses_course_create');
        // make sure action exists before attaching the courses to the activity
        if($action) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $courses);
        }
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
            $isRowExists = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->action_id);
            if($isRowExists) {
                $details = Engine_Api::_()->getItem('sesadvancedactivity_detail', $isRowExists);
                $details->sesresource_id = $courses->getIdentity();
                $details->sesresource_type = $courses->getType();
                $details->save();
            }
        }
        //Tag Work
        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity') && $tags) {
          $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
          foreach($tags as $tag) {
            $dbGetInsert->query('INSERT INTO `engine4_sesadvancedactivity_hashtags` (`action_id`, `title`) VALUES ("'.$action->getIdentity().'", "'.$tag.'")');
          }
        }
        $followers = Engine_Api::_()->getDbtable('followers', 'eclassroom')->getFollowers($courses->classroom_id);
        $favourites = Engine_Api::_()->getDbtable('favourites', 'courses')->getAllFavMembers($courses->course_id);
        $likes = Engine_Api::_()->getDbtable('likes', 'core')->getAllLikes($courses);
        $followerCourse = array();
        $favouriteCourse = array();
        $likesCourse = array();
        foreach($favourites as $favourite){
            $favouriteCourse[$favourite->owner_id] = $favourite->owner_id;
        }
        foreach($followers as $follower){
            $followerCourse[$follower->owner_id] = $follower->owner_id;

        }
        foreach($likes as $like){
            $likesCourse[$likes->owner_id] =  $likes->owner_id;
        }
        $users = array_unique(array_merge($likesCourse ,$followerCourse, $favouriteCourse), SORT_REGULAR);
        foreach($users as $user){ 
            $usersOject = Engine_Api::_()->getItem('user', $user);
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($usersOject, $viewer, $courses, 'courses_course_create');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($usersOject->email, 'courses_course_create', array('host' => $_SERVER['HTTP_HOST'], 'course_name' => $coursename,'object_link'=>$courses->getHref()));
        }
     }
    $emails = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.emailalert', null);
    if(!empty($emails)) {
        $emailArray = explode(",",$emails);
        foreach($emailArray as $email) {
            $email = str_replace(' ', '', $email);
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'courses_course_create', array('host' => $_SERVER['HTTP_HOST'], 'course_name' => $coursename,'object_link'=>$courses->getHref()));
        }
    }
     //Start Send Approval Request to Admin
    try {
      if (!$courses->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->courses()->getAdminnSuperAdmins();
          foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {  
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $courses, 'courses_waitingadminapproval');
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'courses_waitingadminapproval', array('sender_title' => $courses->getOwner()->getTitle(), 'adminmanage_link' => 'admin/courses/manage','course_name' => $coursename, 'object_link' => $courses->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        }
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($courses->getOwner(), 'courses_course_wtapr', array('course_title' => $courses->getTitle(), 'course_name' => $coursename, 'object_link' => $courses->getHref(), 'host' => $_SERVER['HTTP_HOST']));
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($viewer, $viewer, $courses, 'courses_course_wtapr');
        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'courses_waitingadminapproval', array('sender_title' => $courses->getOwner()->getTitle(), 'object_link' => $courses->getHref(),'course_name' => $coursename, 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      }
      //Send mail to all super admin and admins
      if ($courses->is_approved) {
        $getAdminnSuperAdmins = Engine_Api::_()->courses()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
          $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
          Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'courses_waitingadminapproval', array('sender_title' => $courses->getOwner()->getTitle(), 'object_link' => $courses->getHref(),'course_name' => $coursename, 'host' => $_SERVER['HTTP_HOST']));
        }
        $receiverEmails = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.receivenewalertemails');
        if (!empty($receiverEmails)) {
          $receiverEmails = explode(',', $receiverEmails);
          foreach ($receiverEmails as $receiverEmail) { 
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($receiverEmail, 'courses_waitingadminapproval', array('sender_title' => $courses->getOwner()->getTitle(), 'object_link' => $courses->getHref(),'course_name' => $coursename, 'host' => $_SERVER['HTTP_HOST']));
          }
        }
      } 
    } catch(Exception $e) {}
    $db->commit();
    if($profile && !empty($classroom)){
      return $this->_helper->redirector->gotoRoute(array('classroom_id' => $classroom->custom_url,'action'=>'manage-courses'), 'eclassroom_dashboard', true);
    }
    $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.autoopenpopup', 1);
    if ($autoOpenSharePopup) {
      $_SESSION['newCourse'] = true;
    }
    $redirection = Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.page.redirect', 1);
    if (!$courses->is_approved) {
          return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'courses_general', true);
    } else if(!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
      header('location:' . $resource->getHref());
      die;
    } elseif ($redirection == 1) {
        header('location:' . $courses->getHref());
        die;
    } else {
        return $this->_helper->redirector->gotoRoute(array('course_id' => $courses->custom_url), 'courses_dashboard', true);
    }
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

 public function upsellCourseAction(){
    $content_title = $this->_getParam('text', null);
    $table = Engine_Api::_()->getItemTable('courses');
    $courseTableName = $table->info('name');
    $course_id = $this->_getParam('course_id');
    $select = $table->select()
                    ->from($courseTableName)
                    ->where("{$courseTableName}.search = ?", 1)
                    ->where("{$courseTableName}.draft != ?", 0)
                    ->where("{$courseTableName}.owner_id = ?", $this->view->viewer()->user_id)
                    ->where("(`{$courseTableName}`.`title` LIKE ?)", "%{$content_title}%");
    if($course_id)
        $select->where("{$courseTableName}.course_id !=?",$course_id);
    $results = Zend_Paginator::factory($select);
      $data = array();
    foreach ($results as $result) {
      $photo_icon_photo = $this->view->itemPhoto($result, 'thumb.icon');
      $data[] = array(
        'id' => $result->getIdentity(),
        'label' => $result->getTitle(),
        'photo' => $photo_icon_photo,
      );
    }
    return $this->_helper->json($data);
  }
   public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');
        $id = $this->_getParam('course_id'); 
        if($this->_getParam('is_Ajax_Delete',null) && $id) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try
            {
               $courses = Engine_Api::_()->getItem('courses', $id);
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
        $this->view->course_id = $id;
        // Check post
        if($this->getRequest()->isPost())
        {
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try
          {
            $courses = Engine_Api::_()->getItem('courses', $id); 
            // delete the courses entry into the database
            Engine_Api::_()->courses()->deleteCourse($courses);
            $db->commit();
          }
          catch( Exception $e )
          { 
              $db->rollBack();
              throw $e;
          } 
          return $this->_forward('success', 'utility', 'core', array(
                'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'eclassroom_general', true),
                'messages' => array('Your Classroom has been  Deleted successfully')
          ));
        }
    }
    public function createTestAction() {
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $this->view->form = $form = new Courses_Form_Lecture_Create();
       if (!$this->getRequest()->isPost() || $is_ajax_content)
        return;
    }
    function compareCourseAction(){
      $course_id = $this->_getParam('course_id');
      $catgeory_id = $this->_getParam('category_id');
      $type = $this->_getParam('type');
      if($type == "add")
        $_SESSION['courses_add_to_compare'][$catgeory_id][$course_id] = $course_id;
      else if($type == "all"){
          unset($_SESSION["courses_add_to_compare"]);
      }else{
          if(!empty($_SESSION['courses_add_to_compare'][$catgeory_id][$course_id])){
              unset($_SESSION['courses_add_to_compare'][$catgeory_id][$course_id]);
          }
      }
      echo 1;die;
    }
    function reviewVotesAction() {
        if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
            echo json_encode(array('status' => 'false', 'error' => 'Login'));
            die;
        }
        $item_id = $this->_getParam('id');
        $type = $this->_getParam('type');
        if (intval($item_id) == 0 || ($type != 1 && $type != 2 && $type != 3)) {
            echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
            die;
        }
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $itemTable = Engine_Api::_()->getItemTable('courses_review');
        $tableVotes = Engine_Api::_()->getDbtable('reviewvotes', 'courses');
        $tableMainVotes = $tableVotes->info('name');
        $review = Engine_Api::_()->getItem('courses_review',$item_id);
        $select = $tableVotes->select()
            ->from($tableMainVotes)
            ->where('review_id = ?', $item_id)
            ->where('user_id = ?', $viewer_id)
            ->where('type =?', $type);
        $result = $tableVotes->fetchRow($select);
        if ($type == 1)
            $votesTitle = 'useful_count';
        else if ($type == 2)
            $votesTitle = 'funny_count';
        else
            $votesTitle = 'cool_count';

        if (count($result) > 0) {
            //delete
            $db = $result->getTable()->getAdapter();
            $db->beginTransaction();
            try {
                $result->delete();
                $itemTable->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' - 1')), array('review_id = ?' => $item_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $selectReview = $itemTable->select()->where('review_id =?', $item_id);
            $review = $itemTable->fetchRow($selectReview);
            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $review->{$votesTitle}));
            die;
        } else {
            //update
            $db = Engine_Api::_()->getDbTable('reviewvotes', 'courses')->getAdapter();
            $db->beginTransaction();
            try {
                $votereview = $tableVotes->createRow();
                $votereview->user_id = $viewer_id;
                $votereview->review_id = $item_id;
                $votereview->type = $type;
                $votereview->save();
                $itemTable->update(array($votesTitle => new Zend_Db_Expr($votesTitle . ' + 1')), array('review_id = ?' => $item_id));
                //Commit
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            //Send notification and activity feed work.
            $selectReview = $itemTable->select()->where('review_id =?', $item_id);
            $review = $itemTable->fetchRow($selectReview);
            echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $review->{$votesTitle}));
            die;
        }
    }
    public function searchAction() {
        $text = $this->_getParam('text', null);
        $actonType = $this->_getParam('actonType', null);
        $courses_commonsearch = $this->_getParam('search_type', 'courses');
        if ($courses_commonsearch && $actonType == 'browse') {
            $type = $courses_commonsearch;
        } else {
            if (isset($_COOKIE['courses_commonsearch']))
                $type = $_COOKIE['courses_commonsearch'];
            else
                $type = 'courses';
        }
        if(empty($type) || $type == '') {
            $type = 'courses';
        }
        if ($type == 'courses') {
            $table = Engine_Api::_()->getDbTable('courses', 'courses');
            $tableName = $table->info('name');
            $id = 'course_id';
            $route = 'courses_entry_view';
            $label = 'title';
        } elseif ($type == 'courses_wishlist') {
            $table = Engine_Api::_()->getDbTable('wishlists', 'courses');
            $tableName = $table->info('name');
            $id = 'wishlist_id';
            $route = 'courses_wishlist_view';
            $label = 'title';
        }
        $data = array();
        $select = $table->select()->from($tableName);
        $select->where('title  LIKE ? ', '%' . $text . '%')->order('title ASC');
        if ($type == 'courses')
            $select->where('search = ?', 1);
        $select->limit('40');
        $results = Zend_Paginator::factory($select);
        foreach ($results as $result) {
            $url = $result->getHref();
                    $photo_icon_photo = $this->view->itemPhoto($result, 'thumb.icon');
            if ($actonType == 'browse') {
                $data[] = array(
                    'id' => $result->$id,
                    'label' => $result->$label,
                    'photo' => $photo_icon_photo
                );
            } else {
                $data[] = array(
                    'id' => $result->$id,
                    'label' => $result->$label,
                    'url' => $url,
                    'photo' => $photo_icon_photo
                );
            }
        }
        return $this->_helper->json($data);
    }
    public function getCoursesAction() {
		$sesdata = array();
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$courseTable = Engine_Api::_()->getDbtable('courses', 'courses');
		$courseTableName = $courseTable->info('name');
		$courseClaimTable = Engine_Api::_()->getDbtable('claims', 'eclassroom');
		$courseClaimTableName = $courseClaimTable->info('name');
		$text = $this->_getParam('text', null);
		$selectClaimTable = $courseClaimTable->select()
                                          ->from($courseClaimTableName, 'classroom_id')
                                          ->where('user_id =?', $viewerId);
		$claimedClassrooms = $courseClaimTable->fetchAll($selectClaimTable);
		$currentTime = date('Y-m-d H:i:s');
		$select = $courseTable->select()
		->where('draft != ?', 0)
		->where("publish_date <= '$currentTime' OR publish_date = ''")
		//->where('owner_id !=?', $viewerId)
		->where('is_approved =?', 1)
		->where($courseTableName .'.title  LIKE ? ', '%' .$text. '%');
		if(count($claimedClassrooms) > 0)
		$select->where('course_id NOT IN(?)', $selectClaimTable);
		$select->order('course_id ASC')->limit('20');
		$courses = $courseTable->fetchAll($select);
		foreach ($courses as $course) {
			$course_icon_photo = $this->view->itemPhoto($course, 'thumb.icon');
			$sesdata[] = array(
			'id' => $course->course_id,
			'label' => $course->title,
			'photo' => $course_icon_photo
			);
		}
		return $this->_helper->json($sesdata);
	}
	  // USER SPECIFIC METHODS
    public function manageAction() {
        if( !$this->_helper->requireUser()->isValid() ) return;
        // Render
        $this->_helper->content
            //->setNoRender()
            ->setEnabled();
        // Prepare data
        $viewer = Engine_Api::_()->user()->getViewer();
       // $this->view->form = $form = new Courses_Form_Search();
        $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('courses', null, 'create')->checkRequire();
       // $form->removeElement('show');
        // Populate form
//         $categories = Engine_Api::_()->getDbtable('categories', 'courses')->getCategoriesAssoc();
//         if( !empty($categories) && is_array($categories) && $form->getElement('category') ) {
//           $form->getElement('category')->addMultiOptions($categories);
//         }
    }
  public function shareAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    $type = $this->_getParam('type');
    $id = $this->_getParam('id');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->attachment = $attachment = Engine_Api::_()->getItem($type, $id);
    if (empty($_POST['is_ajax']))
      $this->view->form = $form = new Activity_Form_Share();
    if (!$attachment) {
      // tell smoothbox to close
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('You cannot share this item because it has been removed.');
      $this->view->smoothboxClose = true;
      return $this->render('deletedItem');
    }
    // hide facebook and twitter option if not logged in
    $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
    if (!$facebookTable->isConnected() && empty($_POST['is_ajax'])) {
      $form->removeElement('post_to_facebook');
    }
    $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
    if (!$twitterTable->isConnected() && empty($_POST['is_ajax'])) {
      $form->removeElement('post_to_twitter');
    }
    if (empty($_POST['is_ajax']) && !$this->getRequest()->isPost()) {
      return;
    }
    if (empty($_POST['is_ajax']) && !$form->isValid($this->getRequest()->getPost())) {
      return;
    }
    // Process
    $db = Engine_Api::_()->getDbtable('actions', 'activity')->getAdapter();
    $db->beginTransaction();
    try {
      // Get body
      if (empty($_POST['is_ajax']))
        $body = $form->getValue('body');
      else
        $body = '';
      // Set Params for Attachment
      $params = array(
          'type' => '<a href="' . $attachment->getHref() . '">' . $attachment->getMediaType() . '</a>',
      );
      // Add activity
      $api = Engine_Api::_()->getDbtable('actions', 'activity');
      //$action = $api->addActivity($viewer, $viewer, 'post_self', $body);
      $action = $api->addActivity($viewer, $attachment->getOwner(), 'share', $body, $params);
      if ($action) {
        $api->attachActivity($action, $attachment);
      }
      $db->commit();
      // Notifications
      $notifyApi = Engine_Api::_()->getDbtable('notifications', 'activity');
      // Add notification for owner of activity (if user and not viewer)
      if ($action->subject_type == 'user' && $attachment->getOwner()->getIdentity() != $viewer->getIdentity()) {
        $notifyApi->addNotification($attachment->getOwner(), $viewer, $action, 'shared', array(
            'label' => $attachment->getMediaType(),
        ));
      }
      // Preprocess attachment parameters
      if (empty($_POST['is_ajax']))
        $publishMessage = html_entity_decode($form->getValue('body'));
      else
        $publishMessage = '';
      $publishUrl = null;
      $publishName = null;
      $publishDesc = null;
      $publishPicUrl = null;
      // Add attachment
      if ($attachment) {
        $publishUrl = $attachment->getHref();
        $publishName = $attachment->getTitle();
        $publishDesc = $attachment->getDescription();
        if (empty($publishName)) {
          $publishName = ucwords($attachment->getShortType());
        }
        if (($tmpPicUrl = $attachment->getPhotoUrl())) {
          $publishPicUrl = $tmpPicUrl;
        }
        // prevents OAuthException: (#100) FBCDN image is not allowed in stream
        if ($publishPicUrl &&
                preg_match('/fbcdn.net$/i', parse_url($publishPicUrl, PHP_URL_HOST))) {
          $publishPicUrl = null;
        }
      } else {
        $publishUrl = $action->getHref();
      }
      // Check to ensure proto/host
      if ($publishUrl &&
              false === stripos($publishUrl, 'http://') &&
              false === stripos($publishUrl, 'https://')) {
        $publishUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishUrl;
      }
      if ($publishPicUrl &&
              false === stripos($publishPicUrl, 'http://') &&
              false === stripos($publishPicUrl, 'https://')) {
        $publishPicUrl = 'http://' . $_SERVER['HTTP_HOST'] . $publishPicUrl;
      }
      // Add site title
      if ($publishName) {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title
                . ": " . $publishName;
      } else {
        $publishName = Engine_Api::_()->getApi('settings', 'core')->core_general_site_title;
      }
      // Publish to facebook, if checked & enabled
      if ($this->_getParam('post_to_facebook', false) &&
              'publish' == Engine_Api::_()->getApi('settings', 'core')->core_facebook_enable) {
        try {
          $facebookTable = Engine_Api::_()->getDbtable('facebook', 'user');
          $facebookApi = $facebook = $facebookTable->getApi();
          $fb_uid = $facebookTable->find($viewer->getIdentity())->current();
          if ($fb_uid &&
                  $fb_uid->facebook_uid &&
                  $facebookApi &&
                  $facebookApi->getUser() &&
                  $facebookApi->getUser() == $fb_uid->facebook_uid) {
            $fb_data = array(
                'message' => $publishMessage,
            );
            if ($publishUrl) {
              $fb_data['link'] = $publishUrl;
            }
            if ($publishName) {
              $fb_data['name'] = $publishName;
            }
            if ($publishDesc) {
              $fb_data['description'] = $publishDesc;
            }
            if ($publishPicUrl) {
              $fb_data['picture'] = $publishPicUrl;
            }
            $res = $facebookApi->api('/me/feed', 'POST', $fb_data);
          }
        } catch (Exception $e) {
          // Silence
        }
      } // end Facebook
      // Publish to twitter, if checked & enabled
      if ($this->_getParam('post_to_twitter', false) &&
              'publish' == Engine_Api::_()->getApi('settings', 'core')->core_twitter_enable) {
        try {
          $twitterTable = Engine_Api::_()->getDbtable('twitter', 'user');
          if ($twitterTable->isConnected()) {
            // Get attachment info
            $title = $attachment->getTitle();
            $url = $attachment->getHref();
            $picUrl = $attachment->getPhotoUrl();
            // Check stuff
            if ($url && false === stripos($url, 'http://')) {
              $url = 'http://' . $_SERVER['HTTP_HOST'] . $url;
            }
            if ($picUrl && false === stripos($picUrl, 'http://')) {
              $picUrl = 'http://' . $_SERVER['HTTP_HOST'] . $picUrl;
            }
            // Try to keep full message
            // @todo url shortener?
            $message = html_entity_decode($form->getValue('body'));
            if (strlen($message) + strlen($title) + strlen($url) + strlen($picUrl) + 9 <= 140) {
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
              if ($picUrl) {
                $message .= ' - ' . $picUrl;
              }
            } else if (strlen($message) + strlen($title) + strlen($url) + 6 <= 140) {
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
            } else {
              if (strlen($title) > 24) {
                $title = Engine_String::substr($title, 0, 21) . '...';
              }
              // Sigh truncate I guess
              if (strlen($message) + strlen($title) + strlen($url) + 9 > 140) {
                $message = Engine_String::substr($message, 0, 140 - (strlen($title) + strlen($url) + 9)) - 3 . '...';
              }
              if ($title) {
                $message .= ' - ' . $title;
              }
              if ($url) {
                $message .= ' - ' . $url;
              }
            }
            $twitter = $twitterTable->getApi();
            $twitter->statuses->update($message);
          }
        } catch (Exception $e) {
          // Silence
        }
      }
      // Publish to janrain
      if (//$this->_getParam('post_to_janrain', false) &&
              'publish' == Engine_Api::_()->getApi('settings', 'core')->core_janrain_enable) {
        try {
          $session = new Zend_Session_Namespace('JanrainActivity');
          $session->unsetAll();
          $session->message = $publishMessage;
          $session->url = $publishUrl ? $publishUrl : 'http://' . $_SERVER['HTTP_HOST'] . _ENGINE_R_BASE;
          $session->name = $publishName;
          $session->desc = $publishDesc;
          $session->picture = $publishPicUrl;
        } catch (Exception $e) {
          // Silence
        }
      }
    } catch (Exception $e) {
      $db->rollBack();
      throw $e; // This should be caught by error handler
    }
    // If we're here, we're done
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Success!');
    $typeItem = ucwords(str_replace(array('courses_'), '', $attachment->getType()));
    // Redirect if in normal context
    if (null === $this->_helper->contextSwitch->getCurrentContext()) {
      $return_url = $form->getValue('return_url', false);
      if (!$return_url) {
        $return_url = $this->view->url(array(), 'default', true);
      }
      return $this->_helper->redirector->gotoUrl($return_url, array('prependBase' => false));
    } else if ('smoothbox' === $this->_helper->contextSwitch->getCurrentContext()) {
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => true,
          'parentRefresh' => false,
          'messages' => array($typeItem . ' share successfully.')
      ));
    } else if (isset($_POST['is_ajax'])) {
      echo "true";
      die();
    }
  }
  public function likeItemAction() {
    $item_id = $this->_getParam('item_id', '0');
    $item_type = $this->_getParam('item_type', '0');
    if (!$item_id || !$item_type)
      return;
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $title = $this->_getParam('title',0);
		$this->view->title = $title == '' ? $view->translate("People Who Like This") : $title;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->viewmore = isset($_POST['viewmore']) ? $_POST['viewmore'] : '';
    $item = Engine_Api::_()->getItem($item_type, $item_id);
    $param['type'] = $this->view->item_type = $item_type;
    $param['id'] = $this->view->item_id = $item->getIdentity();
    $paginator = Engine_Api::_()->sesvideo()->likeItemCore($param);
    $this->view->item_id = $item_id;
    $this->view->paginator = $paginator;
    // Set item count per page and current page number
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($page);
  }
}
