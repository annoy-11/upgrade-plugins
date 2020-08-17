<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: DashboardController.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Ecoupon_DashboardController extends Core_Controller_Action_Standard {
  public function init() { 
   if (!$this->_helper->requireAuth()->setAuthParams('coupon', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $subject = null;
    if (!Engine_Api::_()->core()->hasSubject() && ($id = $this->_getParam('coupon_id'))) {
      if ($id) {
        $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $id);
        if ($coupon)
          Engine_Api::_()->core()->setSubject($coupon);
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
  public function editAction() {
     if (!$this->_helper->requireUser()->isValid())
      return;
    $coupon_id = $this->_getParam('coupon_id',false);
    $this->view->subject = $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $subjectType = null;
    $subjectType = Engine_Api::_()->getItem($coupon->resource_type, $coupon->resource_id);
    if(empty($coupon) || empty($subjectType))
        return false;
    $this->view->form = $form = new Ecoupon_Form_Create(array('couponId'=>$coupon_id));
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
    } else {
    }
    $form->populate($coupon->toArray());
     if (!$this->getRequest()->isPost()) {
       return;
    }
    if(!$form->isValid($_POST) || $this->_getParam('is_ajax')){
        if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
            $couponTable = Engine_Api::_()->getDbtable('coupons', 'ecoupon');
            $values = $form->getValues();
            $result = $couponTable->isAvailable($values['coupon_code']);
            if($result){
              return $form->addError('Coupon Code is not available');
            }
        }
        //price check
        if(empty($_POST['price'])){
           $form->addError($this->view->translate('Price is required.'));
           $priceError = true;
        }
      //discount_type check
      if(!empty($_POST['discount_type'])){
        if(empty($_POST['price'])){
           $form->addError($this->view->translate('Price is required.'));
           $priceError = true;
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
      $values = $form->getValues();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $coupon->setFromArray($values);
         //discount
        if(!empty($_POST['discount_start_date'])){
            if(isset($_POST['discount_start_date']) && $_POST['discount_start_date'] != ''){
                $starttime = isset($_POST['discount_start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['discount_start_date'].' '.$_POST['discount_start_date_time'])) : '';
                $couponsRow->discount_start_time =$starttime;
            }
            if(isset($_POST['discount_start_date']) && $viewer->timezone && $_POST['discount_start_date'] != ''){
                //Convert Time Zone
                $oldTz = date_default_timezone_get();
                $oldTime = time();
                date_default_timezone_set($viewer->timezone);
                $start = strtotime($_POST['discount_start_date'].' '.(!empty($_POST['discount_start_date_time']) ? $_POST['discount_start_date_time'] : "00:00:00"));
                $currentTime = time();
                $newtime = $currentTime > $oldTime ? ($start - abs($currentTime - $oldTime)) : ($start + abs($currentTime - $oldTime));
                $couponsRow->discount_start_time = date('Y-m-d H:i:s', $newtime);
                date_default_timezone_set($oldTz);
            }
        }
        if(!empty($_POST['discount_end_date'])){
            if(isset($_POST['discount_end_date']) && $_POST['discount_end_date'] != ''){
                $starttime = isset($_POST['discount_end_date']) ? date('Y-m-d H:i:s',strtotime($_POST['discount_end_date'].' '.$_POST['discount_end_date_time'])) : '';
                $couponsRow->discount_end_time =$starttime;
            }
            if(isset($_POST['discount_end_date']) && $viewer->timezone && $_POST['discount_end_date'] != ''){
                //Convert Time Zone
                $oldTz = date_default_timezone_get();
                $oldTime = time();
                date_default_timezone_set($viewer->timezone);
                $start = strtotime($_POST['discount_end_date'].' '.(!empty($_POST['discount_end_date_time']) ? $_POST['discount_end_date_time'] : "00:00:00"));
                 $currentTime = time();
                $newtime = $currentTime > $oldTime ? ($start - abs($currentTime - $oldTime)) : ($start + abs($currentTime - $oldTime));
                $couponsRow->discount_end_time = date('Y-m-d H:i:s', $newtime);
                date_default_timezone_set($oldTz);
            }
        }
        $coupon->owner_id = $coupon->getOwner()->getIdentity();
        if (!empty($values['photo'])) {
            $coupon->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,$coupon->resource_type,$coupon->resource_type,'',$subjectType,true);
        }
         $coupon->save();
         $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_redirectCustom($subjectType->getHref(), array('prependBase' => false));
  }
    public function profileFieldAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $this->view->course = $courses = Engine_Api::_()->core()->getSubject();
      //Classroom Category and profile fileds
      $this->view->defaultProfileId = $defaultProfileId = 1;
      if (isset($courses->category_id) && $courses->category_id != 0)
          $this->view->category_id = $courses->category_id;
      else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
          $this->view->category_id = $_POST['category_id'];
      else
          $this->view->category_id = 0;
      if (isset($courses->subsubcat_id) && $courses->subsubcat_id != 0)
          $this->view->subsubcat_id = $courses->subsubcat_id;
      else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
          $this->view->subsubcat_id = $_POST['subsubcat_id'];
      else
          $this->view->subsubcat_id = 0;
      if (isset($courses->subcat_id) && $courses->subcat_id != 0)
          $this->view->subcat_id = $courses->subcat_id;
      else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
          $this->view->subcat_id = $_POST['subcat_id'];
      else
          $this->view->subcat_id = 0;
      //Classroom category and profile fields
      $viewer = Engine_Api::_()->user()->getViewer();
      // Create form
      $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Profilefield(array('defaultProfileId' => $defaultProfileId));
      $this->view->category_id = $courses->category_id;
      $this->view->subcat_id = $courses->subcat_id;
      $this->view->subsubcat_id = $courses->subsubcat_id;
      $form->populate($courses->toArray());
      if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
          return;
      // Process
      $db = Engine_Api::_()->getItemTable('courses')->getAdapter();
      $db->beginTransaction();
      try {
          //Add fields
          $customfieldform = $form->getSubForm('fields');
          if ($customfieldform) {
              $customfieldform->setItem($courses);
              $customfieldform->saveValues();
          }
          $courses->save();
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
      $this->_redirectCustom(array('route' => 'courses_dashboard', 'action' => 'profile-field', 'course_id' => $courses->custom_url));
  }
  
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get current row
    $table = Engine_Api::_()->getDbTable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'courses')
            ->where('id = ?', $course->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Style();
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
      $row->type = 'courses';
      $row->id = $course->getIdentity();
    }
    $row->style = $style;
    $row->save();
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
               $course = Engine_Api::_()->getItem('courses', $id);
              //  delete the course entry into the database
               Engine_Api::_()->courses()->deleteCourse($course);
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
            $course = Engine_Api::_()->getItem('courses', $id);
            // delete the courses entry into the database
           Engine_Api::_()->courses()->deleteCourse($course);
            $db->commit();
        }
        catch( Exception $e )
        {
            $db->rollBack();
            throw $e;
        }
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh'=> 10,
            'messages' => array('')
        ));
        }
    }
    public function accountDetailsAction() {

     $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $gateway_type = $this->view->gateway_type = $this->_getParam('gateway_type', "paypal");
    $viewer = Engine_Api::_()->user()->getViewer();
    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'courses')->getUserGateway(array('course_id' => $course->course_id,'gateway_type'=>$gateway_type,'user_id'=>$viewer->getIdentity()));
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $userGatewayEnable = $settings->getSetting('courses.userGateway', 'paypal');

    $this->view->form = $form = new Ecoupon_Form_PayPal();
    if($gateway_type == "paypal") {
        $userGatewayEnable = 'paypal';
        $this->view->form = $form = new Sesbasic_Form_PayPal();
        $gatewayTitle = 'Paypal';
        $gatewayClass= 'Ecoupon_Plugin_Gateway_PayPal';
    } else if($gateway_type == "stripe") {
        $userGatewayEnable = 'stripe';
        $this->view->form = $form = new Sesadvpmnt_Form_Admin_Settings_Stripe();
        $gatewayTitle = 'Stripe';
        $gatewayClass= 'Sesadvpmnt_Plugin_Gateway_User_Stripe';
    } else if($gateway_type == "paytm") {
        $userGatewayEnable = 'paytm';
        $this->view->form = $form = new Epaytm_Form_Admin_Settings_Paytm();
        $gatewayTitle = 'Paytm';
        $gatewayClass= 'Epaytm_Plugin_Gateway_User_Paytm';
    }
    if (count($userGateway)) {
      $form->populate($userGateway->toArray());
      if (is_array($userGateway['config'])) {
        $form->populate($userGateway['config']);
      }
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    // Process
    $values = $form->getValues();
    $enabled = (bool) $values['enabled'];
    unset($values['enabled']);
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $userGatewayTable = Engine_Api::_()->getDbtable('usergateways', 'courses');
    // insert data to table if not exists
    try {
      if (!count($userGateway)) {
        $gatewayObject = $userGatewayTable->createRow();
        $gatewayObject->course_id = $course->course_id;
        $gatewayObject->user_id = $viewer->getIdentity();
        $gatewayObject->title = $gatewayTitle;
        $gatewayObject->plugin = $gatewayClass;
        $gatewayObject->gateway_type = $gateway_type;
        $gatewayObject->save();
      } else { 
        $gatewayObject = Engine_Api::_()->getItem("courses_usergateway", $userGateway['usergateway_id']);
      }
      $db->commit();

    } catch (Exception $e) {
      echo $e->getMessage();
    }
    // Validate gateway config
    if ($enabled && !empty($userGateway->plugin)) {
      $gatewayObjectObj = $gatewayObject->getGateway($userGateway->plugin);
      try {
        $gatewayObjectObj->setConfig($values);
        $response = $gatewayObjectObj->test();
      } catch (Exception $e) {
        $enabled = false;
        $form->populate(array('enabled' => false));
        $form->addError(sprintf('Gateway login failed. Please double check ' .
                        'your connection information. The gateway has been disabled. ' .
                        'The message was: [%2$d] %1$s', $e->getMessage(), $e->getCode()));
      }
    } else {
      $form->addError('Gateway is currently disabled.');
    }
    // Process
    $message = null;
    try {
      $values = $gatewayObject->getPlugin($userGateway->plugin)->processAdminGatewayForm($values);
    } catch (Exception $e) {
      $message = $e->getMessage();
      $values = null;
    }
    if (null !== $values) {
      $gatewayObject->setFromArray(array(
          'enabled' => $enabled,
          'config' => $values,
      ));
      $gatewayObject->save();
      $form->addNotice('Changes saved.');
    } else {
      $form->addError($message);
    }
  }
  //get course contact information
  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Contactinformation();

    $form->populate($course->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    if (!empty($_POST["course_contact_email"]) && !filter_var($_POST["course_contact_email"], FILTER_VALIDATE_EMAIL)) {
      $form->addError($this->view->translate("Invalid email format."));
      return;
    }
    if (!empty($_POST["course_contact_website"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["course_contact_website"])) {
      $form->addError($this->view->translate("Invalid WebSite URL."));
      return;
    }
    if (!empty($_POST["course_contact_facebook"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["course_contact_facebook"])) {
      $form->addError($this->view->translate("Invalid Facebook URL."));
      return;
    }
    if (!empty($_POST["course_contact_linkedin"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["course_contact_linkedin"])) {
      $form->addError($this->view->translate("Invalid Linkedin URL."));
      return;
    }
    if (!empty($_POST["course_contact_twitter"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["course_contact_twitter"])) {
      $form->addError($this->view->translate("Invalid Twitter URL."));
      return;
    }
    if (!empty($_POST["course_contact_instagram"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["course_contact_instagram"])) {
      $form->addError($this->view->translate("Invalid Instagram URL."));
      return;
    }
    if (!empty($_POST["course_contact_pinterest"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["course_contact_pinterest"])) {
      $form->addError($this->view->translate("Invalid Pinterest URL."));
      return;
    }
    $db = Engine_Api::_()->getDbTable('courses', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
      $course->setFromArray($form->getValues());
      $course->save();
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
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $viewer = Engine_Api::_()->user()->getViewer();
        if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.allow.termncondition', 1))
            return $this->_forward('notfound', 'error', 'core');
      // Create form
      $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Policy();
      $form->populate($course->toArray());
      if (!$this->getRequest()->isPost())
        return;
      // Not post/invalid
      if (!$this->getRequest()->isPost() || $is_ajax_content)
        return;
      if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
        return;
      $db = Engine_Api::_()->getDbTable('courses', 'courses')->getAdapter();
      $db->beginTransaction();
      try {
        $course->setFromArray($_POST);
        $course->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
      }
  }
   public function manageLecturesAction(){
        $viewer = $this->view->viewer();
        $totalLecture = Engine_Api::_()->getDbTable('lectures', 'courses')->countLectures($viewer->getIdentity());
        $allowLectureCount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'lecture_count');
        $this->view->createLimit = 1;
        $this->view->course = $course = Engine_Api::_()->core()->getSubject();
        if ($totalLecture >= $allowLectureCount && $allowLectureCount != 0) {
          $this->view->createLimit = 0;
        }
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
        if (isset($_POST['searchParams']) && $_POST['searchParams'])
            parse_str($_POST['searchParams'], $searchArray);
        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $valueLecture) {
                if ($key == 'delete_' . $valueLecture) {
                    $lecture = Engine_Api::_()->getItem('courses_lecture', $valueLecture);
                    if(count($lecture)) {
                        $lecture->delete();
                        $course->lecture_count--;
                    }
                }
            }
          $course->save();
        }
        $this->view->allowCreate = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'courses', 'lec_create');
        $value['title'] = isset($searchArray['title']) ? $searchArray['title'] : '';
        $value['owner_name'] = isset($searchArray['owner_name']) ? $searchArray['owner_name'] : '';
        $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
        $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
        $value['category_id'] = isset($searchArray['category_id']) ? $searchArray['category_id'] : '';
        $value['course_id'] = $course->getIdentity();

//         $this->view->formFilter = $formFilter = new Ecourse_Form_Dashboard_ManageProduct();
//         if($value)
//         $formFilter->populate($value);
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $user_id = $this->view->user_id = $this->_getParam('user_id', null);
        $course_id = $course->getIdentity();
        $viewer = $this->view->viewer();
        // Create form
        $this->view->lectures = $paginator = Engine_Api::_()->getDbTable('lectures', 'courses')->getLecturesPaginator($value,array('title','lecture_id','creation_date','course_id'));
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getparam('page',1));
  }
  public function manageDocumentAction(){
      $viewer = $this->view->viewer();
//       $totalLecture = Engine_Api::_()->getDbTable('lectures', 'courses')->countLectures($viewer->getIdentity());
//       $allowLectureCount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'lecture_count');
//       $this->view->createLimit = 1;
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
//       if ($totalLecture >= $allowLectureCount && $allowLectureCount != 0) {
//         $this->view->createLimit = 0;
//       }
//       $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
//       $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
//       if (isset($_POST['searchParams']) && $_POST['searchParams'])
//           parse_str($_POST['searchParams'], $searchArray);
//       if ($this->getRequest()->isPost()) {
//           $values = $this->getRequest()->getPost();
//           foreach ($values as $key => $valueLecture) {
//               if ($key == 'delete_' . $valueLecture) {
//                   $lecture = Engine_Api::_()->getItem('courses_lecture', $valueLecture);
//                   if(count($lecture)) {
//                       $lecture->delete();
//                       $course->lecture_count--;
//                   }
//               }
//           }
//         $course->save();
//       }
//       $this->view->allowCreate = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'courses', 'lec_create');
//       $value['title'] = isset($searchArray['title']) ? $searchArray['title'] : '';
//       $value['owner_name'] = isset($searchArray['owner_name']) ? $searchArray['owner_name'] : '';
//       $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
//       $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
//       $value['category_id'] = isset($searchArray['category_id']) ? $searchArray['category_id'] : '';
//       $value['course_id'] = $course->getIdentity();
//       $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
//       $user_id = $this->view->user_id = $this->_getParam('user_id', null);
//       $course_id = $course->getIdentity();
//       $viewer = $this->view->viewer();
      // Create form
      $this->view->lectures = $paginator = Engine_Api::_()->getDbTable('lectures', 'courses')->getLecturesPaginator($value,array('title','lecture_id','creation_date','course_id'));
      $paginator->setItemCountPerPage(100);
      $paginator->setCurrentPageNumber($this->_getparam('page',1));
  }
   public function manageTestsAction(){
        $viewer = $this->view->viewer();
        $totalTests = Engine_Api::_()->getDbTable('tests', 'courses')->countTests($viewer->getIdentity());
        $allowTestCount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'test_count');
        $this->view->createLimit = 1;
        $this->view->course = $course = Engine_Api::_()->core()->getSubject();
        if ($totalTests >= $allowTestCount && $allowTestCount != 0) {
          $this->view->createLimit = 0;
        }
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
        if (isset($_POST['searchParams']) && $_POST['searchParams'])
            parse_str($_POST['searchParams'], $searchArray);
        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $valueTest) {
                if ($key == 'delete_' . $valueTest) {
                    $test = Engine_Api::_()->getItem('courses_test', $valueTest);
                    if(count($test)) {
                        $test->delete();
                        $course->test_count--;
                    }
                }
            }
          $course->save();
        }
        $this->view->allowCreate = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'courses', 'test_create');
//         $value['title'] = isset($searchArray['title']) ? $searchArray['title'] : '';
//         $value['owner_name'] = isset($searchArray['owner_name']) ? $searchArray['owner_name'] : '';
//         $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
//         $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
//         $value['category_id'] = isset($searchArray['category_id']) ? $searchArray['category_id'] : '';
           $value['course_id'] = $course->getIdentity();
//         $this->view->formFilter = $formFilter = new Ecourse_Form_Dashboard_ManageTests();
//         if($value)
//         $formFilter->populate($value);
//         $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
//         $user_id = $this->view->user_id = $this->_getParam('user_id', null);
        $course_id = $course->getIdentity();
        // Create form
        $this->view->tests = $paginator = Engine_Api::_()->getDbTable('tests', 'courses')->getTestsPaginator($value);
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getparam('page',1));
  }
  public function createLectureAction() {
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Ecoupon_Form_Lecture_Create();
      if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
  }
  public function taxesAction(){
      if ($this->getRequest()->isPost()) {
          $values = $this->getRequest()->getPost();
          foreach ($values as $key => $value) {
              if ($key == 'delete_' . $value) {
                  Engine_Api::_()->getDbtable('taxes', 'courses')->delete(array('tax_id = ?' => $value));
              }
          }
      }
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $viewer = $this->view->viewer();
      //fetch Course taxes
      $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
      $params['course_id'] = $course->getIdentity();
      $this->view->taxes = $paginator = Engine_Api::_()->getDbTable('taxes','courses')->getTaxes($params); 
      $paginator->setItemCountPerPage(10);
      $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function createTaxAction(){
      if (!$this->_helper->requireUser()->isValid())
          return;
      $this->_helper->layout->setLayout('default-simple');
      $this->view->form = $form = new Ecoupon_Form_Taxes_Addtaxes();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

          $values = $form->getValues();

          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              $table = Engine_Api::_()->getDbTable('taxes','courses');
              $row = $table->createRow();
              $values = $form->getValues();
              $values['course_id'] = $course->getIdentity();
              $row->setFromArray($values);
              $row->save();
              $db->commit();
          } catch (Exception $e) {
              $db->rollBack();
              throw $e;
          }

          $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 10,
              'parentRefresh' => 10,
              'messages' => array(Zend_Registry::get('Zend_Translate')->_('Tax added successfully.'))
          ));
      }
  }
  function editTaxAction(){
    if (!$this->_helper->requireUser()->isValid())
        return;
    $this->_helper->layout->setLayout('default-simple');
    $id = $this->_getParam('tax_id');
    $tax = Engine_Api::_()->getItem('courses_taxes',$id);
    $this->view->form = $form = new Ecoupon_Form_Taxes_Addtaxes();
    $form->populate($tax->toArray());
    $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
    $form->setTitle('Edit Tax');
    $form->submit->setLabel('Edit Tax');
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
        $values = $form->getValues();
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $table = Engine_Api::_()->getDbTable('taxes','courses');
            $values = $form->getValues();
            $values['is_admin'] = 0;
            $tax->setFromArray($values);
            $tax->save();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Tax edited successfully.'))
        ));
    }
  }
  public function deleteTaxAction(){
    $id = $this->_getParam('tax_id');
    $tax = Engine_Api::_()->getItem('courses_taxes',$id);
    if (!$this->getRequest()->isPost()) {
        $this->view->status = false;
        $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
        return;
    }
    $db = $tax->getTable()->getAdapter();
    $db->beginTransaction();
    try {
        $tax->delete();
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
    echo 1;die;
  }
  function enableTaxAction(){
      $id = $this->_getParam('tax_id');
      $tax = Engine_Api::_()->getItem('courses_taxes',$id);
      $tax->status = !$tax->status;
      $tax->save();
      if(Engine_Api::_()->getItem('courses_taxes',$id)->status){
          echo 1;die;
      }else{
          echo 0;die;
      }
  }
  function manageLocationsAction(){
      if ($this->getRequest()->isPost()) {
          $values = $this->getRequest()->getPost();
          foreach ($values as $key => $value) {
              if ($key == 'delete_' . $value) {
                  Engine_Api::_()->getDbtable('taxstates', 'courses')->delete(array('taxstate_id = ?' => $value));
              }
          }
      }
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $viewer = $this->view->viewer();
      //fetch Course taxes
      $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
      $this->view->tax_id = $tax_id = $this->_getParam('tax_id');
      $params = array();
      $tax = Engine_Api::_()->getItem('courses_taxes',$tax_id);
      if(isset($_POST['status'])){
          $params['status'] = $_POST['status'];
      }
      if(isset($_POST['tax_type'])){
          $params['tax_type'] = $_POST['tax_type'];
      }
      if(isset($_POST['title'])){
          $params['title'] = $_POST['title'];
      }
      $params['tax_id'] = $tax_id;
      $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('taxstates','courses')->getStates($params);
      $paginator->setItemCountPerPage(10);
      $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  function statesAction(){
        $country_id = $this->_getParam('country_id');
        $stateTable = Engine_Api::_()->getDbTable('states','courses');
        $select = $stateTable->select()->where('status =?',1)->where('country_id =?',$country_id);
        $states = $stateTable->fetchAll($select);
        $statesString = '';
        foreach($states as $state){
            $statesString .= '<option value="'.$state->getIdentity().'">'.$state->name.'</option>';
        }
        echo $statesString;die;
  }
  function enableLocationTaxAction(){
      $id = $this->_getParam('tax_id');
      $tax = Engine_Api::_()->getItem('courses_taxstate',$id);
      $tax->status = !$tax->status;
      $tax->save();
      if(Engine_Api::_()->getItem('courses_taxstate',$id)->status){
          echo 1;die;
      }else{
          echo 0;die;
      }
  }
  public function deleteLocationTaxAction(){
        $id = $this->_getParam('tax_id');
        $tax = Engine_Api::_()->getItem('courses_taxstate',$id);
        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }
        $db = $tax->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            $tax->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        echo 1;die;
    }
  function createLocationAction(){
      $id = $this->_getParam('id',0);
      if (!$this->_helper->requireUser()->isValid())
          return;
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $this->_helper->layout->setLayout('default-simple');
      $this->view->form = $form = new Ecoupon_Form_Taxes_AddLocation();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
      //get all countries
      $countries = Engine_Api::_()->getDbTable('countries','courses')->fetchAll(Engine_Api::_()->getDbTable('countries','courses')->select()->where('status = ?',1));
      $countriesArray = array('0'=>'All Countries');
      foreach($countries as $country){
          $countriesArray[$country->getIdentity()] = $country['name'];
      }
      $form->country_id->setMultiOptions($countriesArray);
      if($id){
          $form->removeElement('country_id');
          $form->removeElement('state_id');
          $form->removeElement('location_type');
          $row = Engine_Api::_()->getItem('courses_taxstate',$id);
          $form->populate($row->toArray());
          $form->submit->setLabel('Edit Location');
          $form->setTitle('Edit Location');
          $tax_type = $row['tax_type'];
          if($tax_type == "0"){
              $form->fixed_price->setValue($row['value']);
          }else{
              $form->percentage_price->setValue($row['value']);
          }
      }
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
          $values = $form->getValues();
          $tax_type = $_POST['tax_type'];
          if($tax_type == "0"){
              $price = $_POST['fixed_price'];
          }else{
              $price = $_POST['percentage_price'];
          }
          if(!Engine_Api::_()->courses()->isValidPriceValue($price)){
              if($tax_type == "0") {
                  $form->addError('Enter valid Price.');
              }else{
                  $form->addError('Enter valid %age Price.');
              }
              return;
          }
          if(!empty($_POST['country_id']) && empty($_POST['state_id']) && $_POST['location_type'] == 0){
              $form->addError('Select state to enable tax.');
              return;
          }
          try {
              $table = Engine_Api::_()->getDbTable('taxstates','courses');
              $values = $form->getValues();

              if(empty($row)) {
                  $state = !empty($_POST['state_id']) ? $_POST['state_id'] : array('0');
                  if(!$values['country_id']){
                      $state = array(0);
                  }
                  $values['tax_id'] = $this->_getParam('tax_id');
              }else{
                  $state = array(0);
              }

              foreach ($state as $state) {
                  if(empty($row)){
                      $taxstate = $table->createRow();
                      $values['state_id'] = $state;
                  }else{
                      $taxstate = $row;
                  }
                  $tax_type = $_POST['tax_type'];
                  if ($tax_type == "0") {
                      $values['value'] = $_POST['fixed_price'];
                  } else {
                      $values['value'] = $_POST['percentage_price'];
                  }
                  $taxstate->setFromArray($values);
                  $taxstate->save();
                  //$db->commit();
              }
          } catch (Exception $e) {
              //$db->rollBack();
              throw $e;
          }
          $this->_forward('success', 'utility', 'core', array(
              'smoothboxClose' => 100,
              'parentRefresh' => 100,
              'messages' => array(Zend_Registry::get('Zend_Translate')->_('Tax added successfully.'))
          ));
      }
  }
  public function paymentRequestsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->userGateway = Engine_Api::_()->getDbtable('usergateways', 'courses')->getUserGateway(array('course_id' => $course->getIdentity()));
    $this->view->orderDetails = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseStats(array('course_id' => $course->getIdentity()));
    $this->view->thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'course_threshold');
    //get ramaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'courses')->getCourseRemainingAmount(array('course_id' => $course->course_id));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else
    $this->view->remainingAmount = $remainingAmount->remaining_payment;
    $this->view->isAlreadyRequests = Engine_Api::_()->getDbtable('userpayrequests', 'courses')->getPaymentRequests(array('course_id' => $course->course_id,'isPending'=>true));
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'courses')->getPaymentRequests(array('course_id' => $course->course_id,'isPending'=>true));
  }
  public function paymentRequestAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->thresholdAmount = $thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'courses', 'course_threshold');
    //get remaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'courses')->getCourseRemainingAmount(array('course_id' => $course->course_id));
    if (!$remainingAmount) {
        $this->view->remainingAmount = 0;
    } else {
        $this->view->remainingAmount = $remainingAmount->remaining_payment;
    }
    $defaultCurrency = Engine_Api::_()->courses()->defaultCurrency();
    $orderDetails = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseStats(array('course_id' => $course->course_id));
    $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Paymentrequest();
    $value = array();

    $value['total_tax_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['total_billingtax_cost'], $defaultCurrency);
    $value['total_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['total_amount'], $defaultCurrency);
    $value['total_commission_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($orderDetails['commission_amount'], $defaultCurrency);

    $value['remaining_amount'] = Engine_Api::_()->courses()->getCurrencyPrice($remainingAmount->remaining_payment, $defaultCurrency);
    $value['requested_amount'] = round($remainingAmount->remaining_payment,2);
    //set value to form
    if ($this->_getParam('id', false)) {
        $item = Engine_Api::_()->getItem('courses_userpayrequest', $this->_getParam('id'));
        if ($item) {
            $itemValue = $item->toArray();
            //unset($value['requested_amount']);
            $value = array_merge($itemValue, $value);
        } else {
            return $this->_forward('requireauth', 'error', 'core');
        }
    }
    if (empty($_POST))
        $form->populate($value);

    if (!$this->getRequest()->isPost())
        return;
    if (!$form->isValid($this->getRequest()->getPost()))
        return;
    if (@round($thresholdAmount,2) > @round($remainingAmount->remaining_payment,2) && empty($_POST)) {
        $this->view->message = 'Remaining amount is less than Threshold amount.';
        $this->view->errorMessage = true;
        return;
    } else if (isset($_POST['requested_amount']) && @round($_POST['requested_amount'],2) > @round($remainingAmount->remaining_payment,2)) {
        $form->addError('Requested amount must be less than or equal to remaining amount.');
        return;
    } else if (isset($_POST['requested_amount']) && @round($thresholdAmount) > @round($_POST['requested_amount'],2)) {
        $form->addError('Requested amount must be greater than or equal to threshold amount.');
        return;
    }

    $db = Engine_Api::_()->getDbtable('userpayrequests', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
        $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'courses');
        if (isset($itemValue))
            $order = $item;
        else
          $order = $tableOrder->createRow();
        $order->requested_amount = round($_POST['requested_amount'],2);
        $order->user_message = $_POST['user_message'];
        $order->course_id = $course->course_id;
        $order->owner_id = $viewer->getIdentity();
        $order->user_message = $_POST['user_message'];
        $order->creation_date = date('Y-m-d h:i:s');
        $order->currency_symbol = $defaultCurrency;
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $userGatewayEnable = $settings->getSetting('courses.userGateway', 'paypal');
        $order->save();
        $db->commit();

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment request send successfully.');
        $courseTitle = '<a href="'.$course->getHref().'">'.$course->getTitle().'</a>';
        $senderTitle = '<a href="'.$viewer->getHref().'">'.$viewer->getTitle().'</a>';
        $getAdminnSuperAdmins = Engine_Api::_()->courses()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $course, 'courses_payment_request',array('requestAmount' => Engine_Api::_()->courses()->getCurrencyPrice(round($_POST['requested_amount'],2), $defaultCurrency)));
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($user->email, 'courses_payment_request', array('host' => $_SERVER['HTTP_HOST'],'course_name' => $courseTitle,'sender_title'=>$senderTitle,'object_link'=>$course->getHref()));
        }
        return $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array($this->view->message)
        ));
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }
  }
  public function paymentTransactionAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $viewer = Engine_Api::_()->user()->getViewer();
      $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'courses')->getPaymentRequests(array('course_id' => $course->course_id, 'state' => 'complete'));
  }
  //get paymnet detail
  public function detailPaymentAction() {
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $this->view->item = $paymnetReq = Engine_Api::_()->getItem('courses_userpayrequest', $this->getRequest()->getParam('id'));
      $this->view->viewer = Engine_Api::_()->user()->getViewer();
      if (!$paymnetReq) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
          return;
      }
  }
  //delete payment request
  public function deletePaymentAction() {
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
      $paymnetReq = Engine_Api::_()->getItem('courses_userpayrequest', $this->getRequest()->getParam('id'));
      $viewer = Engine_Api::_()->user()->getViewer();
      // In smoothbox
      $this->_helper->layout->setLayout('default-simple');

      // Make form
      $this->view->form = $form = new Sesbasic_Form_Delete();
      $form->setTitle('Delete Payment Request?');
      $form->setDescription('Are you sure that you want to delete this payment request? It will not be recoverable after being deleted.');
      $form->submit->setLabel('Delete');
      if (!$paymnetReq) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
          return;
      }
      if (!$this->getRequest()->isPost()) {
          $this->view->status = false;
          $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
          return;
      }
      $db = $paymnetReq->getTable()->getAdapter();
      $db->beginTransaction();
      try {
//           $getAdminnSuperAdmins = Engine_Api::_()->courses()->getAdminnSuperAdmins();
//           foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
//               $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
//               Engine_Api::_()->getDbTable('notifications', 'activity')->delete(array('type =?' => 'courses_payment_request', "subject_id =?" => $user->getIdentity(), "object_type =? " => $course->getType(), "object_id = ?" => $course->getIdentity()));
//   
//           }
          $paymnetReq->delete();
          $db->commit();
      } catch (Exception $e) {
          $db->rollBack();
          throw $e;
      }
      $this->view->status = true;
      $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment Request has been deleted.');
      return $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array($this->view->message)
      ));
  }
   public function mainphotoAction() { 
    if (!Engine_Api::_()->authorization()->isAllowed('courses', $this->view->viewer(), 'upload_mainphoto'))
        return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    // Get form
    $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Mainphoto();
    if (empty($course->photo_id)) {
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
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $fileElement = $form->Filedata;
            $course->photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'courses','courses','',$course,true);
            $course->save();
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
  public function salesStatsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
     $this->view->view_type = $interval = isset($_POST['type']) ? $_POST['type'] : 'monthly';
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->todaySale = Engine_Api::_()->getDbtable('orders', 'courses')->getSaleStats(array('stats' => 'today', 'course_id' => $course->course_id));
    $this->view->weekSale = Engine_Api::_()->getDbtable('orders', 'courses')->getSaleStats(array('stats' => 'week', 'course_id' => $course->course_id));
    $this->view->monthSale = Engine_Api::_()->getDbtable('orders', 'courses')->getSaleStats(array('stats' => 'month', 'course_id' => $course->course_id));
    //get getEcouponStats
    $this->view->courseStatsSale = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseStats(array('course_id' => $course->course_id));
    $orderStats = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseOrderReport(array('course_id' => $course->course_id,'type'=>$interval));
    $total_orders = $commission_amount = $total_amount = $total_tax_cost = $totalAmountSale = $date =  array();
    $dateArray = Engine_Api::_()->courses()->createDateRangeArray($course->creation_date, $course->creation_date, $interval);
    foreach($orderStats as $data) {
      $total_orders[] = round($data->total_orders,2);
      $commission_amount[] = round($data->commission_amount,2);
      $total_amount[] = round($data->total_amount,2);
      $total_tax_cost[] = round($data->total_billingtax_cost,2);
      $totalAmountSale[] = round($data->totalAmountSale,2);
      switch($interval) {
        case 'monthly':
          $date[] = date('d', strtotime($date));
        break;
        case 'weekly':
          $date[] = date('d-M', strtotime($date));
        break;
        case 'daily':
          $date[] = date('d', strtotime($date));
        break;
        case 'hourly':
          $date[] = date('h A', strtotime($date));
        break;
        default:
        $date[] = 0;
      }
    }
    if ($is_ajax) {
      echo json_encode(array('date' => $date, 'total_orders' => $total_orders, 'commission_amount' => $commission_amount, 'total_amount' => $total_amount, 'total_tax_cost' => $total_tax_cost, 'totalAmountSale' => $totalAmountSale));
      die;
    } else {
      $this->view->date = $date;
      $this->view->total_orders = $total_orders;
      $this->view->commission_amount = $commission_amount;
      $this->view->total_amount = $total_amount;
      $this->view->total_tax_cost = $total_tax_cost;
      $this->view->totalAmountSale = $totalAmountSale;
    }
  }
  //get sales report
  public function salesReportsAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $this->view->course = $course = Engine_Api::_()->core()->getSubject();
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
      $value['course_id'] = $course->getIdentity();
      $this->view->coursesSaleData = $data = Engine_Api::_()->getDbtable('orders', 'courses')->getCourseReportData($value);
      if(isset($value['download'])){
          $name = str_replace(' ','_',$course->getTitle()).'_'.time();
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
  public function coursePolicyAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $courseId = $this->_getParam('course_id');
      $viewer = Engine_Api::_()->user()->getViewer();
			if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.terms.conditions', 1))
				return $this->_forward('notfound', 'error', 'core');
      // Create form
      if($courseId) {
        $this->view->course = Engine_Api::_()->getItem('courses',$courseId);
      } else {
        return false;
      }
  }
  public function manageOrdersAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $viewer = $this->view->viewer();
    $searchArray = array();
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->searchForm = $searchForm = new Ecoupon_Form_Searchorder();
    $searchForm->populate($searchArray);
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
    $value['course_id'] = $course->getIdentity();
    //print_r($value);die;
    $this->view->orders = $orders = Engine_Api::_()->getDbtable('ordercourses', 'courses')->coursesOrders($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }
  
  //Start custom work 
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Seo();
    $form->populate($course->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('courses', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
      $course->setFromArray($_POST);
      $course->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
  public function overviewAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Ecoupon_Form_Course_Dashboard_Overview();
    $form->populate($course->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('courses', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
      $course->setFromArray($_POST);
      $course->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }
  public function advertiseCourseAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = Engine_Api::_()->core()->getSubject();
  }
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
      $likeMembers = Engine_Api::_()->courses()->getMemberByLike($attachment->getIdentity(),'courses');
      foreach ($likeMembers as $likeMember) {
        $likeMemberIds[] = $likeMember['poster_id'];
      }
    }
    if (in_array('followed', $values['type'])) {
      $followMembers = Engine_Api::_()->courses()->getMemberFollow($attachment->getIdentity(),'courses');
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
  
  public function announcementAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('courses', $this->view->viewer(), 'auth_announce'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'courses')
            ->getCourseAnnouncementPaginator(array('course_id' => $course->course_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
   public function postAnnouncementAction() {
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Postannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcementTable = Engine_Api::_()->getDbTable('announcements', 'courses');
    $db = $announcementTable->getAdapter();
    $db->beginTransaction();
    try {
      $announcement = $announcementTable->createRow();
      $announcement->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'course_id' => $course->course_id), $form->getValues()));
      $announcement->save();
      $db->commit();
      // Redirect
      $this->_redirectCustom(array('route' => 'courses_dashboard', 'action' => 'announcement', 'course_id' => $course->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editAnnouncementAction() {
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('courses_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Editannouncement();
    $form->title->setValue($announcement->title);
    $form->body->setValue($announcement->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->title = $_POST['title'];
    $announcement->body = $_POST['body'];
    $announcement->save();
    $this->_redirectCustom(array('route' => 'courses_dashboard', 'action' => 'announcement', 'course_id' => $course->custom_url));
  }
  public function deleteAnnouncementAction() {
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
     $this->view->form = $form = new Eclassroom_Form_Dashboard_Deleteannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if($this->_getParam('id')) {
        $announcement = Engine_Api::_()->getItem('courses_announcement', $this->_getParam('id'));
         $announcement->delete();
    } else if(isset($_POST['ids']) && !empty($_POST['ids'])) {
        $ids = explode(",",$_POST['ids']);
        foreach($ids as $id){

             $announcement = Engine_Api::_()->getItem('courses_announcement',$id);
             if(!empty($announcement)) {
                 $announcement->delete();
             }
        }
    } else {
      $this->_redirectCustom(array('route' => 'courses_dashboard', 'action' => 'announcement', 'course_id' => $course->custom_url));
    }
    $this->_redirectCustom(array('route' => 'courses_dashboard', 'action' => 'announcement', 'course_id' => $course->custom_url));
  }
   public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    $users = array();
    $roleTable = Engine_Api::_()->getDbTable('courseroles', 'courses');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('course_id =?', $this->_getParam('course_id', null))->query()->fetchAll();
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
  
  public function courseRolesAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    if (!Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'bs_allow_roles'))
      return $this->_forward('requireauth', 'error', 'core');
    $this->view->courseRoles = Engine_Api::_()->getDbTable('memberroles', 'courses')->getLevels(array('status' => true));
    $roleTable = Engine_Api::_()->getDbTable('courseroles', 'courses');
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('course_id =?', $course->getIdentity())->order('memberrole_id ASC')->query()->fetchAll();
  }
  public function addCourseAdminAction() {
    if (!count($_POST)) {
      echo 0;
      die;
    }
    $user_id = $this->_getParam('user_id', '');
    $course_id = $this->_getParam('course_id', '');
    $roleId = $this->_getParam('roleId', '');
    $roleTable = Engine_Api::_()->getDbTable('courseroles', 'courses');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('course_id =?', $this->_getParam('course_id', null))->where('user_id =?', $user_id)->query()->fetchAll();
    if (count($roleIds)) {
      echo 0;
      die;
    }
    $courseRoleTable = Engine_Api::_()->getDbTable('courseroles', 'courses');
    $courseRole = $courseRoleTable->createRow();
    $courseRole->user_id = $user_id;
    $courseRole->course_id = $course_id;
    $courseRole->memberrole_id = $roleId;
    $courseRole->save();
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->classroom = $course = Engine_Api::_()->getItem('courses', $course_id);
    $courseRole = Engine_Api::_()->getItem('courses_memberrole', $roleId);
    $title = array('roletitle' => $courseRole->title);
    //notification
//     Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $course->getOwner(), $course, 'courses_classroomroll_ctbs', $title);

    //mail
//     Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_courses_classroomroll_creatcourses', array('classroom_name' => $course->getTitle(), 'sender_title' => $course->getOwner()->getTitle(), 'object_link' => $course->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'role_title' => $courseRole->title));

    $this->view->is_ajax = 1;
    $this->view->classroomRoles = Engine_Api::_()->getDbTable('memberroles', 'courses')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('course_id =?', $course->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/course-roles.tpl');
  }
  public function manageCourseappsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $getManagecourseId = Engine_Api::_()->getDbTable('managecourseapps', 'courses')->getManageCourseId(array('course_id' => $course->course_id));
    $this->view->managecourseapps = Engine_Api::_()->getItem('courses_managecourseapps', $getManagecourseId);
    $viewer = Engine_Api::_()->user()->getViewer();
  }
  public function managecourseonoffappsAction() {
    $courseType = $this->_getParam('type', 'photos');
    $courseId = $this->_getParam('course_id', null); 
    if (empty($courseId))
      return;
    $isCheck = Engine_Api::_()->getDbTable('managecourseapps', 'courses')->isCheck(array('course_id' => $courseId, 'columnname' => $courseType));
    $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
    if ($isCheck) {
      $dbGetInsert->update('engine4_courses_managecourseapps', array($courseType => 0), array('course_id =?' => $courseId));
    } else {
      $dbGetInsert->update('engine4_courses_managecourseapps', array($courseType => 1), array('course_id =?' => $courseId));
    }
    echo true;
    die;
  }
  public function manageLocationAction() {
//     if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.enable.location', 1) || !Engine_Api::_()->authorization()->isAllowed('courses', $viewer, 'allow_mlocation'))
//       return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('locations', 'courses')
            ->getCourseLocationPaginator(array('course_id' => $course->course_id));
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
  public function addLocationAction() {
    $course = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Addlocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_courses_locations', array('is_default' => 0), array('course_id =?' => $course->course_id));
      }
      $dbGetInsert->query('INSERT INTO engine4_courses_locations (course_id,title,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $course->course_id . '","' . $_POST['title'] . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '","' . $_POST['is_default'] . '") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $course->course_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "courses")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $course->location = $_POST['location'];
        $course->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'course_id' => $course->custom_url), "courses_dashboard", true);
  }
  public function editLocationAction() {
    $course = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Editlocation();
    $location = Engine_Api::_()->getItem('courses_location', $this->_getParam('location_id'));
    $form->title->setValue($location->title);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && !empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_courses_locations', array('is_default' => 0), array('course_id =?' => $course->course_id));
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
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $course->course_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "courses")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $course->location = $_POST['location'];
        $course->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'course_id' => $course->custom_url), "courses_dashboard", true);
  }
  public function deleteLocationAction() {
    $course = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Eclassroom_Form_Dashboard_Deletelocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $location = Engine_Api::_()->getItem('courses_location', $this->_getParam('location_id'));
    $location->delete();

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'course_id' => $course->custom_url), "courses_dashboard", true);
  }
   public function addPhotosAction() {
    $this->view->course = $course = Engine_Api::_()->core()->getSubject();
    $this->view->location = $location = Engine_Api::_()->getItem('courses_location', $this->_getParam('location_id'));
  }
   public function composeUploadAction() {
    if (!Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->_redirect('login');
      return;
    }
    $location = Engine_Api::_()->getItem('courses_location', $this->_getParam('location_id'));
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
    $photoTable = Engine_Api::_()->getItemTable('courses_locationphoto');
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
      $photo->course_id = $location->course_id;
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
    $photo = Engine_Api::_()->getItem('courses_locationphoto', $photo_id);
    $db = Engine_Api::_()->getItemTable('courses_locationphoto')->getAdapter();
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
    $course = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('courses', 'courses')->getAdapter();
    $db->beginTransaction();
    try {
      $course->photo_id = '';
      $course->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'course_id' => $course->custom_url), "courses_dashboard", true);
  }
}
