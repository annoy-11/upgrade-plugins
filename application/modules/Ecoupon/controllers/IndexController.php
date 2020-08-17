<?php

class Ecoupon_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }
  public function browseAction() {
      $this->_helper->content->setEnabled();
  }
  public function createAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    $resource_type = $this->_getParam('subject',false);
    $resource_id = $this->_getParam('resource_id',false);
    if(empty($resource_id) || empty($resource_type))
      return;
    $this->view->form = $form = new Ecoupon_Form_Create();
    $this->view->subject = $subjectType = Engine_Api::_()->getItem($resource_type, $resource_id);
    if(empty($subjectType))
        return false;
    $viewer = $this->view->viewer();
    $sessmoothbox = $this->view->typesmoothbox = false;
    if ($this->_getParam('typesmoothbox', false)) {
      $sessmoothbox = true;
      $this->view->typesmoothbox = true;
    } else {
    
    }    
    $this->view->resource_type  = $resource_type;
    $this->view->resource_id  = $resource_id;
    if (!$this->getRequest()->isPost()) {
       return;
    }
    if(!$form->isValid($_POST) || $this->_getParam('is_ajax')){
        if (isset($_POST['coupon_code']) && !empty($_POST['coupon_code'])) {
            $couponTable = Engine_Api::_()->getDbtable('coupons', 'ecoupon');
            $values = $form->getValues();
            $result = $couponTable->isAvailable($values['coupon_code']);
            if($result){
              $form->addError('Coupon Code is not available');
            }
        }
      //discount_type check
      if(!empty($_POST['discount_end_type'])){
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
      $couponTable = Engine_Api::_()->getDbtable('coupons', 'ecoupon');
      $values = $form->getValues();
      $result = $couponTable->isAvailable($values['coupon_code']);
      if($result){
        return $form->addError('Coupon Code is not available');
      } 
      $db = $couponTable->getAdapter();
      $db->beginTransaction();
      try {
        $couponsRow = $couponTable->createRow();
        $couponsRow->setFromArray($values);
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
        if (!Engine_Api::_()->authorization()->getPermission($viewer, 'ecoupon', 'auto_approve'))
            $couponsRow->is_approved = 0;
        else
            $couponsRow->is_approved = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'ecoupon', 'bs_featured'))
            $couponsRow->featured = 1;
        if (Engine_Api::_()->authorization()->getPermission($viewer, 'ecoupon', 'bs_hot'))
            $couponsRow->hot = 1;
        $couponsRow->remaining_coupon = $values['count_per_coupon'];
        $couponsRow->enabled = $values['enable'];
        $couponsRow->resource_type = $resource_type;
        $couponsRow->resource_id = $resource_id;
        $couponsRow->item_type = $resource_type;
        $couponsRow->owner_id = $subjectType->getOwner()->getIdentity();
        if (!empty($values['photo'])) {
          $couponsRow->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo, false,false,$resource_type,$resource_type,'',$subjectType,true);
        }
        $couponsRow->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    return $this->_redirectCustom($subjectType->getHref(), array('prependBase' => false));
  }
  public function editAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    $coupon_id = $this->_getParam('coupon_id',false);
    $this->view->subject = $coupon = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $subjectType = null;
    if(!$coupon->is_package) {
      $subjectType = Engine_Api::_()->getItem($coupon->resource_type, $coupon->resource_id);
      if(empty($coupon) || empty($subjectType))
        return false;
    }
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
            $result = $couponTable->isAvailable($_POST['coupon_code']);
            if($result && $result != $coupon_id){
                $form->addError('Coupon Code is not available');
            }
        }
      //discount_type check
      if(!empty($_POST['discount_end_type'])){
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
      if(!empty($subjectType)) {
        return $this->_redirectCustom($subjectType->getHref(), array('prependBase' => false));
      } else {
        return $this->_redirectCustom($coupon->getHref(), array('prependBase' => false));
      }
  }
  public function checkAvailabilityAction(){
    $coupon_code = $this->_getParam('coupon_code', null);
    $result = Engine_Api::_()->getDbtable('coupons', 'ecoupon')->isAvailable($coupon_code);
    if ($result) {
      echo json_encode(array('error' => true, 'coupon_code' => $coupon_code));
      die;
    } else {
      echo json_encode(array('error' => false, 'coupon_code' => $coupon_code));
      die;
    }
  }
  public function viewAction(){
    $coupon_id = $this->_getParam('coupon_id', null);
    if(empty($coupon_id))
      return false;
    $this->view->coupon = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
  }
  public function printAction(){
    $coupon_id = $this->_getParam('coupon_id', null);
    if(empty($coupon_id))
      return false;
    $this->view->coupon = Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
  }
  public function deleteAction(){
    $this->_helper->layout->setLayout('admin-simple');
    $coupon_id = $this->_getParam('coupon_id', null);
    if(empty($coupon_id))
      return false;
    $coupon=  Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Coupon?');
    $form->setDescription('Are you sure that you want to delete this Coupon? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');
    // Check post
    if($this->getRequest()->isPost())
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
        $coupon->delete();
        $db->commit();
      }
      catch( Exception $e )
      { 
        $db->rollBack();
        throw $e;
      } 
      return $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => $this->_helper->redirector->gotoRoute(array('action' => 'browse','subject'=>'coupon'), 'ecoupon_general', true),
            'messages' => array('Your Courses has been  Deleted successfully')
      ));
    }
  }
  public function enableAction() {
    $coupon_id = $this->_getParam('coupon_id',false);
    if(!$coupon_id)
        return;
    $coupon=  Engine_Api::_()->getItem('ecoupon_coupon', $coupon_id);
    $subjectType = null;
    $this->view->form = $form = new Ecoupon_Form_Enable();
    if($this->getRequest()->isPost())
    {
      $coupon->enabled = !$coupon->enabled;
      $coupon->save();
      return $this->_redirectCustom($coupon->getHref(), array('prependBase' => false));
    }
  }
  function applyCouponAction(){
    $coupon_code = $this->_getParam('coupon_code');
    $params = json_decode($this->_getParam('params','{}'),true);
    $itemAmount = isset($params['item_amount']) ? $params['item_amount'] : 0; 
    if(@isset($params['is_package']) && !empty($params['is_package'])){
      $package = Engine_Api::_()->getItem($params['package_type'], $params['package_id']);
      if(empty($package)) {
        echo json_encode(array('status'=>0,'message'=>''));die;
      }
      $itemAmount = @round($package->price ,2);
    } elseif (!$itemAmount) {
      $itemAmount = $this->_getParam('item_amount',0);
    }
    $sessionCode = @$params['package_type'].'-'.$params['package_id'].'-'.$params['resource_type'].'-'.$params['resource_id'].'-'.$params['is_package'];
    $responseData = array();
    $requestData = array();
    $requestData['coupon_code'] = $coupon_code; 
    $requestData['item_amount'] = $itemAmount;
    $requestData['resource_type'] = @$params['resource_type']; 
    $requestData['resource_id'] = @$params['resource_id'];
    $requestData['package_type'] = @$params['package_type']; 
    $requestData['package_id'] = @$params['package_id'];
    $requestData['is_package'] = @$params['is_package'];
    $responseData =  Engine_Api::_()->ecoupon()->applyCoupon($requestData);
    if($responseData['status']) {
      if(isset($_SESSION[$sessionCode]))
        unset($_SESSION[$sessionCode]);
      $_SESSION[$sessionCode] = $responseData;
      echo json_encode($responseData);die;
    } else {
      if(isset($_SESSION[$sessionCode]))
        unset($_SESSION[$sessionCode]);
      echo json_encode(array('status'=>$responseData['status'],'message'=>$responseData['error_msg']));die;
    }
  }
  public function selectedPackageAction(){
    $content_title = $this->_getParam('text', null);
    $item_type = $this->_getParam('item_type', null);
    if(!$item_type)
      return false;
    $table = Engine_Api::_()->getItemTable($item_type);
    $itemTableName = $table->info('name');
    $package_id = $this->_getParam('package_id');
    $select = $table->select()
                    ->from($itemTableName)
                    ->where("(`{$itemTableName}`.`title` LIKE ?)", "%{$content_title}%");
    if($package_id)
        $select->where("{$itemTableName}.package_id !=?",$package_id);
    $results = Zend_Paginator::factory($select);
      $data = array();
    foreach ($results as $result) {
      $data[] = array(
        'id' => $result->getIdentity(),
        'label' => $result->getTitle(),
      );
    }
    return $this->_helper->json($data);
  }
  
  public function couponFaqsAction() {
    $this->_helper->content->setEnabled();
  }
  public function manageAction() {
    $this->_helper->content->setEnabled();
  }
}
