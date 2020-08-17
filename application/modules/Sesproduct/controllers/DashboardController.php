<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_DashboardController extends Core_Controller_Action_Standard {
  public function init() {

    if (!$this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'view')->isValid())
      return;
    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('product_id', null);
    $product_id = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getProductId($id);
    if ($product_id) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      if ($product && !Engine_Api::_()->core()->hasSubject())
        Engine_Api::_()->core()->setSubject($product);
    } else
      return $this->_forward('requireauth', 'error', 'core');
    $isProductAdmin = Engine_Api::_()->sesproduct()->isProductAdmin($product, 'edit');

		if (!$isProductAdmin)
    return $this->_forward('requireauth', 'error', 'core');

  }
	public function fieldsAction(){
		if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->product = $sesproduct = Engine_Api::_()->core()->getSubject();
		$package_id = $sesproduct->package_id;
		$package = Engine_Api::_()->getItem('sesproductpackage_package',$package_id);
		$module = json_decode($package->params,true);
		if(empty($module['custom_fields']) || ($package->custom_fields_params == '[]'))
			 return $this->_forward('notfound', 'error', 'core');

		$this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesproduct')->profileFieldId();
		$this->view->form = $form = new Sesproduct_Form_Custom_Dashboardfields(array('item' => $sesproduct,'topLevelValue'=>0,'topLevelId'=>0));
		 // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
		$form->saveValues();

	}
  public function editAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->product = $sesproduct = Engine_Api::_()->core()->getSubject();
    //if (isset($sesproduct->category_id) && $sesproduct->category_id != 0)
    if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
        $this->view->category_id = $_POST['category_id'];
    else
        $this->view->category_id = $sesproduct->category_id;
    if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
        $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
        $this->view->subsubcat_id = $sesproduct->subsubcat_id;
    if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
        $this->view->subcat_id = $_POST['subcat_id'];
    else
        $this->view->subcat_id = $sesproduct->subcat_id;
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesproduct')->profileFieldId();
    if( !Engine_Api::_()->core()->hasSubject('sesproduct') )
    Engine_Api::_()->core()->setSubject($sesproduct);

    if( !$this->_helper->requireSubject()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesproduct', $viewer, 'edit')->isValid() ) return;


    // Get navigation
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesproduct_main');

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $this->view->sesproductform = $form = new Sesproduct_Form_Edit(array('defaultProfileId' => $defaultProfileId));
    // Populate form
    $form->populate($sesproduct->toArray());
    $form->populate(array(
        'networks' => explode(",",$sesproduct->networks),
        'levels' => explode(",",$sesproduct->levels)
    ));
    if($form->getElement('productstyle'))
    $form->getElement('productstyle')->setValue($sesproduct->style);
    $latLng = Engine_Api::_()->getDbTable('locations', 'sesbasic')->getLocationData('sesproduct',$sesproduct->product_id);
    if($latLng){
      if($form->getElement('lat'))
      $form->getElement('lat')->setValue($latLng->lat);
      if($form->getElement('lng'))
      $form->getElement('lng')->setValue($latLng->lng);
      if($form->getElement('country'))
      $form->getElement('country')->setValue($latLng->country);
      if($form->getElement('state'))
      $form->getElement('state')->setValue($latLng->state);
      if($form->getElement('city'))
      $form->getElement('city')->setValue($latLng->city);
      if($form->getElement('zip'))
      $form->getElement('zip')->setValue($latLng->zip);
    }
    if($form->getElement('location'))
    $form->getElement('location')->setValue($sesproduct->location);
		if($form->getElement('category_id'))
    $form->getElement('category_id')->setValue($sesproduct->category_id);

    $tagStr = '';
    foreach( $sesproduct->tags()->getTagMaps() as $tagMap ) {
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
        if( $auth->isAllowed($sesproduct, $role, 'view') ) {
         $form->auth_view->setValue($role);
        }
      }

      if ($form->auth_comment){
        if( $auth->isAllowed($sesproduct, $role, 'comment') ) {
          $form->auth_comment->setValue($role);
        }
      }

      if ($form->auth_video){
        if( $auth->isAllowed($sesproduct, $role, 'video') ) {
          $form->auth_video->setValue($role);
        }
      }

      if ($form->auth_music){
        if( $auth->isAllowed($sesproduct, $role, 'music') ) {
          $form->auth_music->setValue($role);
        }
      }
    }

    //hide status change if it has been already published
    if( $sesproduct->draft == 0 )
      $form->removeElement('draft');
    $this->view->edit = true;


    $upsells = Engine_Api::_()->getDbTable('upsells','sesproduct')->getSells(array('product_id'=>$sesproduct->getIdentity()));
    if(count($upsells)){
      $content = "";
      $upsellsArray = array();
      foreach($upsells as $upsell){
        $resource = Engine_Api::_()->getItem('sesproduct',$upsell->resource_id);
        if(!$resource)
          continue;
          $upsellsArray[] = $resource->getIdentity();
        $content .='<span id="upsell_remove_'.$resource->getIdentity().'" class="sesproduct_tag tag">'.$resource->getTitle().' <a href="javascript:void(0);" onclick="removeFromToValueUpsell('.$resource->getIdentity().');">x</a></span>';
      }
      $form->upsell_id->setValue(implode(',',$upsellsArray));
      $this->view->upsells = $content;
    }
    $crosssells = Engine_Api::_()->getDbTable('crosssells','sesproduct')->getSells(array('product_id'=>$sesproduct->getIdentity()));
    if(count($crosssells)){
      $content = "";
      $crosssellsArray = array();
      foreach($crosssells as $crosssell){
        $resource = Engine_Api::_()->getItem('sesproduct',$crosssell->resource_id);
        if(!$resource)
          continue;
        $crosssellsArray[] = $resource->getIdentity();
        $content .='<span id="crosssell_remove_'.$resource->getIdentity().'" class="sesproduct_tag tag">'.$resource->getTitle().' <a href="javascript:void(0);" onclick="removeFromToValueCrossSell('.$resource->getIdentity().');">x</a></span>';
      }
      $form->crosssell_id->setValue(implode(',',$crosssellsArray));
      $this->view->crosssells = $content;
    }

    //get all allowed types product
    $viewer = Engine_Api::_()->user()->getViewer();
    $allowed_types = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $viewer, 'allowed_types');
    $this->view->allowedTypes = $allowed_types;


    $this->renderScript('index/create.tpl');

    // Check post/form
    if( !$this->getRequest()->isPost() ) return;
    if( !$form->isValid($this->getRequest()->getPost()) || $this->_getParam('is_ajax') ) {


      if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
        $custom_url = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->checkCustomUrl($_POST['custom_url'],$sesproduct->getIdentity());
        if ($custom_url) {
          $form->addError($this->view->translate("Custom URL is not available. Please select another URL."));
        }
      }
        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enablesku',1)) {
            if (isset($_POST['sku']) && !empty($_POST['sku'])) {
                $sku = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->checkSKU($_POST['sku'], $sesproduct->getIdentity());
                if ($sku) {
                    $form->addError($this->view->translate("SKU is not available. Please select another SKU."));
                }
            }
        }else{
            $_POST['sku'] = "";
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
            $preciousstart = strtotime($sesproduct->discount_start_date);
            date_default_timezone_set($oldTz);
            if($start < time() && $preciousstart != $start){
               $timeDiscountError = true;
               $form->addError($this->view->translate('Discount Start Date field value must be greater than Current Time.'));
            }
         }
         if(!empty($_POST['discount_end_date'])){
            $time = $_POST['discount_end_date'].' '.(!empty($_POST['discount_end_date_time']) ? $_POST['discount_end_date_time'] : "00:00:00");
            $oldTz = date_default_timezone_get();
            date_default_timezone_set($this->view->viewer()->timezone);
            $start = strtotime($time);
            $preciousend = strtotime($sesproduct->discount_end_date);
            date_default_timezone_set($oldTz);
            if($start < time() && $preciousend != $start){
               $timeDiscountError = true;
               $form->addError($this->view->translate('Discount End Date field value must be greater than Current Time.'));
            }
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
                  date_default_timezone_set($oldTz);
                  if($start > $end){
                      $form->addError($this->view->translate('Discount Start Date value must be less than Discount End Date field value.'));
                  }
               }
            }
         }
      }
      //inventory check
      if(!empty($_POST['manage_stock']) && empty($_POST['stock_quatity'])){
         $form->addError($this->view->translate('Stock Quantity is required.'));
      }
      if(!empty($_POST['manage_stock']) && !empty($_POST['stock_quatity'])){
        if($_POST['stock_quatity'] < $_POST['min_quantity'] || $_POST['stock_quatity'] < $_POST['max_quatity']){
            $form->addError($this->view->translate('Minimum Order Quantity / Maximum Order Quantity must be less than Stock Quantity.'));
        }else if(!empty($_POST['max_quatity']) && $_POST['min_quantity'] > $_POST['max_quatity']){
            $form->addError($this->view->translate('Minimum Order Quantity must be less than Maximum Order Quantity.'));
        }
      }else if(!empty($_POST['max_quatity']) && $_POST['min_quantity'] > $_POST['max_quatity']){
            $form->addError($this->view->translate('Minimum Order Quantity must be less than Maximum Order Quantity.'));
      }
      //avalability check
      if(empty($_POST['show_start_time'])){
        if(empty($_POST['start_date'])){
            $form->addError($this->view->translate('Start Time is required.'));
        }else{
          $time = $_POST['start_date'].' '.(!empty($_POST['start_date_time']) ? $_POST['start_date_time'] : "00:00:00");
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($this->view->viewer()->timezone);
          $start = strtotime($time);
          date_default_timezone_set($oldTz);
          if($start < time()){
             $timeError = true;
             $form->addError($this->view->translate('Start Time must be greater than Current Time.'));
          }
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
          date_default_timezone_set($oldTz);
          if($end < time()){
             $timeError = true;
             $form->addError($this->view->translate('End Time must be greater than Current Time.'));
          }
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
              date_default_timezone_set($oldTz);
              if($end < $start){
                  $form->addError($this->view->translate('End Time must be greater than Start Time.'));
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

    // Process
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try
    {
      $values = $form->getValues();

        if($_POST['productstyle'])
            $values['style'] = $_POST['productstyle'];

        $sesproduct->setFromArray($values);

        $sesproduct->modified_date = date('Y-m-d H:i:s');
        if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
            $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_time'])) : '';
            $sesproduct->publish_date =$starttime;
			}
			//else{
			//	$sesproduct->publish_date = '';
			//}

        if(isset($values['levels']))
            $values['levels'] = implode(',',$values['levels']);
        if(isset($values['networks']))
            $values['networks'] = implode(',',$values['networks']);
        if(isset($values['height']))
            $values['height'] = $values['height'];
        if(isset($values['width']))
            $values['width'] = $values['width'];
        if(isset($values['length']))
            $values['length'] = $values['length'];
        if(isset($values['levels']))
            $sesproduct->levels = $values['levels'];

        if(isset($values['networks']))
            $sesproduct->networks = implode(',',$values['networks']);

        if(isset($_POST['Height']))
            $values['height'] = $_POST['Height'];
        if(isset($_POST['Width']))
            $values['width'] = $_POST['Width'];
        if(isset($_POST['Length']))
            $values['length'] = $_POST['Length'];
            $values['ip_address'] = $_SERVER['REMOTE_ADDR'];

      $sesproduct->save();
      unset($_POST['title']);
      unset($_POST['tags']);
      unset($_POST['category_id']);
      unset($_POST['subcat_id']);
      unset($_POST['MAX_FILE_SIZE']);
      unset($_POST['body']);
      unset($_POST['search']);
      unset($_POST['execute']);
      unset($_POST['token']);
      unset($_POST['submit']);
      $values['fields'] = $_POST;
      $values['fields']['0_0_1'] = '2';

      if(!empty($_POST['show_end_time'])){
        if(isset($_POST['start_date']) && $_POST['start_date'] != ''){
          $starttime = isset($_POST['start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['start_date'].' '.$_POST['start_date_time'])) : '';
          $sesproduct->starttime =$starttime;
        }
        if(isset($_POST['start_date']) && $viewer->timezone && $_POST['start_date'] != ''){
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($viewer->timezone);
          $start = strtotime($_POST['start_date'].' '.(!empty($_POST['start_date_time']) ? $_POST['start_date_time'] : "00:00:00"));
          $sesproduct->starttime = date('Y-m-d H:i:s', $start);
			date_default_timezone_set($oldTz);
        }
      }

      if(!empty($_POST['show_end_time'])){
        if(isset($_POST['end_date']) && $_POST['end_date'] != ''){
          $starttime = isset($_POST['end_date']) ? date('Y-m-d H:i:s',strtotime($_POST['end_date'].' '.$_POST['end_date_time'])) : '';
          $sesproduct->endtime =$starttime;
        }
        if(isset($_POST['end_date']) && $viewer->timezone && $_POST['end_date'] != ''){
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($viewer->timezone);
          $start = strtotime($_POST['end_date'].' '.(!empty($_POST['end_date_time']) ? $_POST['end_date_time'] : "00:00:00"));
          $sesproduct->endtime = date('Y-m-d H:i:s', $start);
			date_default_timezone_set($oldTz);
        }
      }
      //check attribute
       // Engine_Api::_()->getDbTable('cartoptions','sesproduct')->checkProduct($sesproduct);
      //discount
      if(!empty($_POST['show_end_time'])){
        if(isset($_POST['discount_start_date']) && $_POST['discount_start_date'] != ''){
          $starttime = isset($_POST['discount_start_date']) ? date('Y-m-d H:i:s',strtotime($_POST['discount_start_date'].' '.$_POST['discount_start_date_time'])) : '';
          $sesproduct->discount_start_date =$starttime;
        }
        if(isset($_POST['discount_start_date']) && $viewer->timezone && $_POST['discount_start_date'] != ''){
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($viewer->timezone);
          $start = strtotime($_POST['discount_start_date'].' '.(!empty($_POST['discount_start_date_time']) ? $_POST['discount_start_date_time'] : "00:00:00"));

          $sesproduct->discount_start_date = date('Y-m-d H:i:s', $start);
			date_default_timezone_set($oldTz);
        }
      }

      if(!empty($_POST['discount_end_date'])){
        if(isset($_POST['discount_end_date']) && $_POST['discount_end_date'] != ''){
          $starttime = isset($_POST['discount_end_date']) ? date('Y-m-d H:i:s',strtotime($_POST['discount_end_date'].' '.$_POST['discount_end_date_time'])) : '';
          $sesproduct->discount_end_date =$starttime;
        }
        if(isset($_POST['discount_end_date']) && $viewer->timezone && $_POST['discount_end_date'] != ''){
          //Convert Time Zone
          $oldTz = date_default_timezone_get();
          date_default_timezone_set($viewer->timezone);
          $start = strtotime($_POST['discount_end_date'].' '.(!empty($_POST['discount_end_date_time']) ? $_POST['discount_end_date_time'] : "00:00:00"));
          $sesproduct->discount_end_date = date('Y-m-d H:i:s', $start);
			date_default_timezone_set($oldTz);
        }
      }
      
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '' && $_POST['location'] && Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $sesproduct->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesproduct") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else if($_POST['location']) {
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "sesproduct" AND `engine4_sesbasic_locations`.`resource_id` = "'.$sesproduct->getIdentity().'";');
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type, country, state, city, zip) VALUES ("' . $sesproduct->getIdentity() . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesproduct", "' . $_POST['country'] . '", "' . $_POST['state'] . '", "' . $_POST['city'] . '", "' . $_POST['zip'] . '")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else if(empty($_POST['location'])) {
        $sesproduct->location = '';
        $sesproduct->save();
        $dbInsert = Engine_Db_Table::getDefaultAdapter();
        $dbInsert->query('DELETE FROM `engine4_sesbasic_locations` WHERE `engine4_sesbasic_locations`.`resource_type` = "sesproduct" AND `engine4_sesbasic_locations`.`resource_id` = "'.$sesproduct->getIdentity().'";');
      }

      if(isset($values['draft']) && !$values['draft']) {
        $currentDate = date('Y-m-d H:i:s');
        if($sesproduct->publish_date < $currentDate) {
          $sesproduct->publish_date = $currentDate;
          $sesproduct->save();
        }
      }

      // Add fields
      $customfieldform = $form->getSubForm('fields');

      if (!is_null($customfieldform)) {
        $customfieldform->setItem($sesproduct);
        $customfieldform->saveValues($values['fields']);
      }
      // Auth
      if( empty($values['auth_view']) ) {
        $values['auth_view'] = 'everyone';
      }

      if( empty($values['auth_comment']) ) {
        $values['auth_comment'] = 'everyone';
      }

      $viewMax = array_search($values['auth_view'], $roles);
      $commentMax = array_search($values['auth_comment'], $roles);
      $videoMax = array_search($values['auth_video'], $roles);
      $musicMax = array_search($values['auth_music'], $roles);
      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sesproduct, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesproduct, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesproduct, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesproduct, $role, 'music', ($i <= $musicMax));
      }

      // handle tags
      $tags = preg_split('/[,]+/', $values['tags']);
      $sesproduct->tags()->setTagMaps($viewer, $tags);

			//upload main image
			if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
				$photo_id = 	$sesproduct->setPhoto($form->photo_file,'direct');
			}

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $sesproduct->custom_url = $_POST['custom_url'];
      else
        $sesproduct->custom_url = $sesproduct->product_id;
      $sesproduct->save();

      $db->commit();
      $upsellcrosssell = Engine_Db_Table::getDefaultAdapter();
      $upsellcrosssell->query('DELETE FROM `engine4_sesproduct_upsells` WHERE product_id = '.$sesproduct->getIdentity());
      $upsellcrosssell->query('DELETE FROM `engine4_sesproduct_crosssells` WHERE product_id = '.$sesproduct->getIdentity());
      //upsell
      if(!empty($_POST['upsell_id'])){
        $upsell = trim($_POST['upsell_id'],',');
        $upsells = explode(',',$upsell);
        foreach($upsells as $item){
          $params['product_id'] = $sesproduct->getIdentity();
          $params['resource_id'] = $item;
          $params['creation_date'] = date('Y-m-d H:i:s');
          Engine_Api::_()->getDbTable('upsells','sesproduct')->create($params);
        }
      }
      //crosssell
      if(!empty($_POST['crosssell_id'])){
        $crosssell = trim($_POST['crosssell_id'],',');
        $crosssells = explode(',',$crosssell);
        foreach($crosssells as $item){
          $params['product_id'] = $sesproduct->getIdentity();
          $params['resource_id'] = $item;
          $params['creation_date'] = date('Y-m-d H:i:s');
          Engine_Api::_()->getDbTable('crosssells','sesproduct')->create($params);
        }
      }
      // insert new activity if sesproduct is just getting published
      $action = Engine_Api::_()->getDbtable('actions', 'activity')->getActionsByObject($sesproduct);
      if( count($action->toArray()) <= 0 && $values['draft'] == '0' && (!$sesproduct->publish_date || strtotime($sesproduct->publish_date) <= time())) {
        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesproduct, 'sesproduct_new');
          // make sure action exists before attaching the sesproduct to the activity
        if( $action != null ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesproduct);
        }
        $sesproduct->is_publish = 1;
      	$sesproduct->save();
      }

      // Rebuild privacy
      $actionTable = Engine_Api::_()->getDbtable('actions', 'activity');
      foreach( $actionTable->getActionsByObject($sesproduct) as $action ) {
        $actionTable->resetActivityBindings($action);
      }

    }
    catch( Exception $e )
    {
      $db->rollBack();
      throw $e;
    }

     $this->_redirectCustom(array('route' => 'sesproduct_dashboard', 'action' => 'edit', 'product_id' => $sesproduct->custom_url));
  }



	 public function removeMainphotoAction() {
      //GET Product ID AND ITEM
	    $product = Engine_Api::_()->core()->getSubject();
			$db = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct')->getAdapter();
      $db->beginTransaction();
      try {
        $product->photo_id = '';
				$product->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
			return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'product_id' => $product->custom_url), "sesproduct_dashboard", true);
  }
	public function mainphotoAction(){
		$is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $product->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesproduct_Form_Dashboard_Mainphoto();
    $form->populate($product->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getAdapter();
    $db->beginTransaction();
    try {
      $product->setPhoto($_FILES['background']);
      $product->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
		 return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'product_id' => $product->custom_url), "sesproduct_dashboard", true);
	}

	 //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $product->isOwner($viewer) || $this->_helper->requireAuth()->setAuthParams(null, null, 'style')->isValid()))
      return;
		// Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'sesproduct')
            ->where('id = ?', $product->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Sesproduct_Form_Dashboard_Style();
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
      $row->type = 'sesproduct';
      $row->id = $product->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

    //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $product->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesproduct_Form_Dashboard_Seo();

    $form->populate($product->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getAdapter();
    $db->beginTransaction();
    try {
      $product->setFromArray($_POST);
      $product->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editPhotoAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $this->view->product = $product = Engine_Api::_()->core()->getSubject();

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Sesproduct_Form_Edit_Photo();

    if( empty($product->photo_id) ) {
      $form->removeElement('remove');
    }

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    // Uploading a new photo
    if( $form->Filedata->getValue() !== null ) {
      $db = $product->getTable()->getAdapter();
      $db->beginTransaction();

      try {

        $fileElement = $form->Filedata;

       // $product->setPhoto($fileElement);
        $photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false,false,'sesproduct','sesproduct','',$product,true);
        $product->photo_id = $photo_id;
        $product->save();
        $db->commit();
      }

      // If an exception occurred within the image adapter, it's probably an invalid image
      catch( Engine_Image_Adapter_Exception $e )
      {
        $db->rollBack();
        $form->addError(Zend_Registry::get('Zend_Translate')->_('The uploaded file is not supported or is corrupt.'));
      }

      // Otherwise it's probably a problem with the database or the storage system (just throw it)
      catch( Exception $e )
      {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function removePhotoAction() {

    //Get form
    $this->view->form = $form = new Sesproduct_Form_Edit_RemovePhoto();

    if( !$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $product = Engine_Api::_()->core()->getSubject();
    $product->photo_id = 0;
    $product->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => true,
      'parentRefresh' => true,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }

  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $sesproduct_edit = Zend_Registry::isRegistered('sesproduct_edit') ? Zend_Registry::get('sesproduct_edit') : null;
    if (empty($sesproduct_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $product->isOwner($viewer)))
      return;
    // Create form
    $this->view->form = $form = new Sesproduct_Form_Dashboard_Contactinformation();

    $form->populate($product->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    $db = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getAdapter();
    $db->beginTransaction();
    try {
      $product->product_contact_name = isset($_POST['product_contact_name']) ? $_POST['product_contact_name'] : '';
      $product->product_contact_email = isset($_POST['product_contact_email']) ? $_POST['product_contact_email'] : '';
      $product->product_contact_phone = isset($_POST['product_contact_phone']) ? $_POST['product_contact_phone'] : '';
      $product->product_contact_website = isset($_POST['product_contact_website']) ? $_POST['product_contact_website'] : '';
      $product->product_contact_facebook = isset($_POST['product_contact_facebook']) ? $_POST['product_contact_facebook'] : '';
      $product->save();
      $db->commit();
      $form->addNotice('Your changes have been saved.');
    } catch (Exception $e) {
      $db->rollBack();
      echo false;
    }
  }

  public function editLocationAction() {

    $this->view->product = $sesproduct = Engine_Api::_()->core()->getSubject();
    $userLocation = $sesproduct->location;

    $this->view->locationLatLng = $locationLatLng = Engine_Api::_()->getDbtable('locations', 'sesbasic')->getLocationData($sesproduct->getType(), $sesproduct->getIdentity());

    $this->view->form = $form = new Sesproduct_Form_Locationedit();
    $form->populate(array(
        'ses_edit_location' => $userLocation,
        'ses_lat' => $locationLatLng['lat'],
        'ses_lng' => $locationLatLng['lng'],
        'ses_zip' => $locationLatLng['zip'],
        'ses_city' => $locationLatLng['city'],
        'ses_state' => $locationLatLng['state'],
        'ses_country' => $locationLatLng['country'],
    ));
    if ($this->getRequest()->getPost()) {
      Engine_Api::_()->getItemTable('sesproduct')->update(array(
          'location' => $_POST['ses_edit_location'],
              ), array(
          'product_id = ?' => $sesproduct->getIdentity(),
      ));
      if (!empty($_POST['ses_edit_location'])) {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng ,city,state,zip,country, resource_type) VALUES ("' . $sesproduct->product_id . '", "' . $_POST['ses_lat'] . '","' . $_POST['ses_lng'] . '","' . $_POST['ses_city'] . '","' . $_POST['ses_state'] . '","' . $_POST['ses_zip'] . '","' . $_POST['ses_country'] . '",  "sesproduct")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['ses_lat'] . '" , lng = "' . $_POST['ses_lng'] . '",city = "' . $_POST['ses_city'] . '", state = "' . $_POST['ses_state'] . '", country = "' . $_POST['ses_country'] . '", zip = "' . $_POST['ses_zip'] . '"');
      }
      $this->_redirectCustom(array('route' => 'sesproduct_dashboard', 'action' => 'edit-location', 'product_id' => $sesproduct->custom_url));
    }
    //Render
  }
  
  public function photosAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');
  }

  function managePhotosAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $pageNumber = isset($_POST['page']) ? $_POST['page'] : 1;
    if (!$is_ajax) {
      if (!$this->_helper->requireUser()->isValid())
      return;
    }
    // Prepare data
    $album_id = $this->_getParam('album_id', null);
    $this->view->album = $album = Engine_Api::_()->getItem('sesproduct_album', $album_id);
    $this->view->content_item = Engine_Api::_()->getItem('sesproduct', $album->product_id);

    $photoTable = Engine_Api::_()->getItemTable('sesproduct_photo');
    $this->view->paginator = $paginator = $photoTable->getPhotoPaginator(array(
        'album' => $album,
        'order' => 'order ASC'
    ));
    $this->view->album_id = $album->album_id;
    $paginator->setCurrentPageNumber($pageNumber);
    $itemCount = (count($_POST) > 0 && !$is_ajax) ? count($_POST) : 10;
    $paginator->setItemCountPerPage($itemCount);
    $this->view->page = $pageNumber;
    // Get albums
    $myAlbums = Engine_Api::_()->getDbtable('albums', 'sesproduct')->editPhotos();
    $albumOptions = array('' => '');
    foreach ($myAlbums as $myAlbum) {
      $albumOptions[$myAlbum['album_id']] = $myAlbum['title'];
    }
    if (count($albumOptions) == 1) {
      $albumOptions = array();
    }
    // Make form
    $this->view->form = $form = new Sesproduct_Form_Album_Photos();
    foreach ($paginator as $photo) {
      $subform = new Sesproduct_Form_Album_EditPhoto(array('elementsBelongTo' => $photo->getGuid()));
      $subform->populate($photo->toArray());
      $form->addSubForm($subform, $photo->getGuid());
      $form->cover->addMultiOption($photo->getIdentity(), $photo->getIdentity());
      if (empty($albumOptions)) {
        $subform->removeElement('move');
      } else {
        $subform->move->setMultiOptions($albumOptions);
      }
    }
    if ($is_ajax) {
      return;
    }
    if (!$this->getRequest()->isPost()) {
      return;
    }
    $table = $album->getTable();
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $values = $_POST;
      if (!empty($values['cover'])) {
        $album->photo_id = $values['cover'];
        $album->save();
      }
      // Process
      foreach ($paginator as $photo) {
        if (isset($_POST[$photo->getGuid()])) {
          $values = $_POST[$photo->getGuid()];
        } else {
          continue;
        }
        unset($values['photo_id']);
        if (isset($values['delete']) && $values['delete'] == '1') {
          $photo->delete();
        } else if (!empty($values['move'])) {
          $nextPhoto = $photo->getNextPhoto();
          $old_album_id = $photo->album_id;
          $photo->album_id = $values['move'];
          $photo->save();
          // Change album cover if necessary
          if (($nextPhoto instanceof Sesproduct_Model_Photo) &&
                  (int) $album->photo_id == (int) $photo->getIdentity()) {
            $album->photo_id = $nextPhoto->getIdentity();
            $album->save();
          }
          // Remove activity attachments for this photo
          Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($photo);
        } else {
          $photo->setFromArray($values);
          $photo->save();
        }
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    //send to specific album view page.
    header('location:'.$this->view->url(array('product_id' => $this->view->content_item->custom_url, 'action'=>'photos'), 'sesproduct_dashboard', true));

  }
  function createAlbumAction(){
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');

    if (isset($_GET['ul']) || isset($_FILES['Filedata']))
      return $this->_forward('upload-photo', null, null, array('format' => 'json'));
     $product_id = $product->getIdentity();
    $album_id = $this->_getParam('album_id',false);
    if($album_id){
    	$album = Engine_Api::_()->getItem('sesproduct_album', $album_id);
			$this->view->product_id = $product_id = $album->product_id;
		}else{
				$this->view->product_id = $product_id = $product_id;
		}
		$product = $this->view->product = Engine_Api::_()->getItem('sesproduct', $product_id);

		$isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');


    // set up data needed to check quota
    $viewer = Engine_Api::_()->user()->getViewer();
    $values['user_id'] = $viewer->getIdentity();
    $this->view->current_count =Engine_Api::_()->getDbtable('albums', 'sesproduct')->getUserAlbumCount($values);
    $this->view->quota = $quota = 0;
    // Get form
    $this->view->form = $form = new Sesproduct_Form_Album();

    $albumTable = Engine_Api::_()->getItemTable('sesproduct_album');
    $myAlbums = $albumTable->select()
        ->from($albumTable, array('album_id', 'title'))
        ->where('product_id = ?', $product->getIdentity())
        ->query()
        ->fetchAll();
    $albumOptions = array('0' => 'Create A New Album');
    foreach( $myAlbums as $myAlbum ) {
      $albumOptions[$myAlbum['album_id']] = $myAlbum['title'];
    }
    $form->album->setMultiOptions($albumOptions);
    // Render
		if (!$this->getRequest()->isPost()) {
			if (null !== ($album_id = $this->_getParam('album_id'))) {
				$form->populate(array(
				'album' => $album_id
				));
			}
			return;
		}

    if (!$form->isValid($this->getRequest()->getPost()))
    return;

    $db = Engine_Api::_()->getItemTable('sesproduct_album')->getAdapter();
    $db->beginTransaction();
    try {
      $album = $form->saveValues();
      // Add tags
      $values = $form->getValues();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }

    header('Location:'.$this->view->url(array('product_id' => $product->custom_url, 'action'=>'photos'), 'sesproduct_dashboard', true));
  }
  public function uploadPhotoAction() {
    $product = Engine_Api::_()->core()->getSubject();
  	$product_id = $product->getIdentity();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');
    if (!$this->_helper->requireUser()->checkRequire()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Max file size limit exceeded (probably).');
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    if(empty($_GET['isURL']) || $_GET['isURL'] == 'false'){
      $isURL = false;
      $values = $this->getRequest()->getPost();
      if (empty($values['Filename']) && !isset($_FILES['Filedata'])) {
        $this->view->status = false;
        $this->view->error = Zend_Registry::get('Zend_Translate')->_('No file');
        return;
      }
      if (!isset($_FILES['Filedata']) || !is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
        $this->view->status = false;
        $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid Upload');
        return;
      }
      $uploadSource = $_FILES['Filedata'];
    }
    else{
      $uploadSource = $_POST['Filedata'];
      $isURL = true;
    }

    $db = Engine_Api::_()->getDbtable('photos', 'sesproduct')->getAdapter();
    $db->beginTransaction();
    try {
      $viewer = Engine_Api::_()->user()->getViewer();
      $photoTable = Engine_Api::_()->getDbtable('photos', 'sesproduct');
      $photo = $photoTable->createRow();
      $photo->setFromArray(array(
        'product_id' => $product->product_id,
        'user_id' => $viewer->getIdentity()
      ));

      $photo->save();
      //$photo->order = $photo->photo_id;
      $setPhoto = $photo->setAlbumPhoto($uploadSource,$isURL);
      if(!$setPhoto){
        $db->rollBack();
        $this->view->status = false;
        $this->view->error = 'An error occurred.';
        return;
      }
      $photo->save();

      $this->view->status = true;
      $this->view->photo_id = $photo->photo_id;
      $this->view->url = $photo->getAlbumPhotoUrl('thumb.normalmain');
      $db->commit();
    }catch (Sesproduct_Model_Exception $e) {
      $db->rollBack();
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('An error occurred.');
      throw $e;
      return;
    }
    if(isset($_GET['ul']))
    echo json_encode(array('status'=>$this->view->status,'name'=>'','photo_id'=> $this->view->photo_id));
  }
  function deleteAlbumAction(){
    $this->_helper->layout->setLayout('default-simple');
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!$this->_helper->requireUser()->isValid())
    return;

		$album_id = $this->_getParam('album_id',false);
    if($album_id)
    $this->view->album = $album = Engine_Api::_()->getItem('sesproduct_album', $album_id);
	  else
	  return;

		$product = Engine_Api::_()->getItem('sesproduct', $album->product_id);


     $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');

    // In smoothbox
    $this->view->form = $form = new Sesproduct_Form_Album_Delete();
    if (!$album) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("Album doesn't exists or not authorized to delete");
      return;
    }
    if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }

    $db = $album->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $album->delete();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
		$this->view->status = true;
		$this->view->message = Zend_Registry::get('Zend_Translate')->_('The selected albums have been successfully deleted.');

		return $this->_forward('success' ,'utility', 'core', array('parentRedirect' => $this->view->url(array('product_id' => $product->custom_url, 'action'=>'photos'), 'sesproduct_dashboard', true), 'messages' => Array($this->view->message)
		));

  }
      public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');
        $id = $this->_getParam('product_id');
        if($this->_getParam('is_Ajax_Delete',null) && $id) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try
            {
               $sesproduct = Engine_Api::_()->getItem('sesproduct', $id);
              //  delete the sesproduct entry into the database
                Engine_Api::_()->sesproduct()->deleteProduct($sesproduct);
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
        $this->view->form = $form = new Sesproduct_Form_Delete();
        $this->view->product_id=$id;
        // Check post
        if($this->getRequest()->isPost())
        {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try
        {
            $sesproduct = Engine_Api::_()->getItem('sesproduct', $id);
            // delete the sesproduct entry into the database
            Engine_Api::_()->sesproduct()->deleteProduct($sesproduct);
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
        // Output
        //$this->renderScript('dashboard/delete-album.tpl');
    }
  function editAlbumAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');


		$album_id = $this->_getParam('album_id',false);
    if($album_id)
    $this->view->album = $album = Engine_Api::_()->getItem('sesproduct_album', $album_id);
	  else
		return;

		$this->view->product = $product = Engine_Api::_()->getItem('sesproduct', $album->product_id);


    if (!$this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid())
    return;

    // Make form
    $this->view->form = $form = new Sesproduct_Form_Album_Edit();
		$form->populate($album->toArray());
		 if (!$this->getRequest()->isPost()) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    //is post
    if (!$form->isValid($this->getRequest()->getPost())) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid data');
      return;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    // Process
    $db = $album->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      $values = $form->getValues();
      $album->setFromArray($values);
      $album->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $db->beginTransaction();
    //send to specific album view page.
    header('location:'.$this->view->url(array('product_id' => $product->custom_url, 'action'=>'photos'), 'sesproduct_dashboard', true));

  }

  public function ordersAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $sesproduct_edit = Zend_Registry::isRegistered('sesproduct_edit') ? Zend_Registry::get('sesproduct_edit') : null;
    if (empty($sesproduct_edit))
      return $this->_forward('notfound', 'error', 'core');
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $isProductAdmin = Engine_Api::_()->sesproduct()->checkProductAdmin($product);
    if(!$isProductAdmin)
    return $this->_forward('notfound', 'error', 'core');


    $this->view->form = $form = new Sesproduct_Form_Admin_Orders();
    $value['product_id'] = $product->getIdentity();

    $this->view->orders = $orders = Engine_Api::_()->getDbtable('orderproducts', 'sesproduct')->productsOrders($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);

  }
  public function createSlideAction(){
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
     $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->form = $form = new Sesproduct_Form_Dashboard_Createslide();

    if (!$this->getRequest()->isPost()) {
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues('url');
      return;
    }
    $values = $form->getValues();
    $slideTable = Engine_Api::_()->getDbtable('slides', 'sesproduct');
    $db = $slideTable->getAdapter();
    $db->beginTransaction();
    try {
      $slide = $slideTable->createRow();
			$viewer = Engine_Api::_()->user()->getViewer();
      if($values['type'] == '1') {
        $information = $this->handleIframelyInformation($values['url']);
        if (empty($information)) {
            $form->addError('We could not find a video there - please check the URL and try again.');
            return;
        }
        $values['code'] = $information['code'];
        $values['thumbnail'] = $information['thumbnail'];
        $values['duration'] = $information['duration'];
      }
      $values['product_id'] = $product->getIdentity();
      $slide->setFromArray($values);
      $slide->save();

      $thumbnail = $values['thumbnail'];
      $ext = ltrim(strrchr($thumbnail, '.'), '.');
      $thumbnail_parsed = @parse_url($thumbnail);

      if (@GetImageSize($thumbnail)) {
          $valid_thumb = true;
      } else {
          $valid_thumb = false;
      }

      if( isset($_FILES['file']['name']) && $_FILES['file']['name'] != ''){
        $slide->file_id = $this->setPhoto($form->file, $slide->slide_id, true);
        $slide->save();
      } else if($valid_thumb && $thumbnail && $ext && $thumbnail_parsed && in_array($ext, array('jpg', 'jpeg', 'gif', 'png'))) {
        $tmp_file = APPLICATION_PATH . '/temporary/link_' . md5($thumbnail) . '.' . $ext;
        $thumb_file = APPLICATION_PATH . '/temporary/link_thumb_' . md5($thumbnail) . '.' . $ext;
        $src_fh = fopen($thumbnail, 'r');
        $tmp_fh = fopen($tmp_file, 'w');
        stream_copy_to_stream($src_fh, $tmp_fh, 1024 * 1024 * 2);
        //resize video thumbnails
        $image = Engine_Image::factory();
        $image->open($tmp_file)
                ->resize(500, 500)
                ->write($thumb_file)
                ->destroy();
        try {
          $thumbFileRow = Engine_Api::_()->storage()->create($thumb_file, array(
              'parent_type' => 'sesproduct_slide',
              'parent_id' => $slide->slide_id
          ));
          // Remove temp file
          @unlink($thumb_file);
          @unlink($tmp_file);
          $slide->file_id = $thumbFileRow->file_id;
          $slide->save();
        } catch (Exception $e){
          throw $e;
           @unlink($thumb_file);
           @unlink($tmp_file);
        }
      }
      $db->commit();

    }catch(Exception $e){
      $db->rollBack();
      throw $e;
    }

    header("Location:".$this->view->url(array('product_id' => $product->custom_url,'action'=>'slideshow'), 'sesproduct_dashboard', true));
    exit();
  }

  public function handleIframelyInformation($uri) {
        $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('video_iframely_disallow');
        if (parse_url($uri, PHP_URL_SCHEME) === null) {
            $uri = "http://" . $uri;
        }
        $uriHost = Zend_Uri::factory($uri)->getHost();
        if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
            return;
        }
        $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
        $iframely = Engine_Iframely::factory($config)->get($uri);
        if (!in_array('player', array_keys($iframely['links']))) {
            return;
        }
        $information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
        if (!empty($iframely['links']['thumbnail'])) {
            $information['thumbnail'] = $iframely['links']['thumbnail'][0]['href'];
            if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
                $information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
                $information['thumbnail'] = "http://" . $information['thumbnail'];
            }
        }
        if (!empty($iframely['meta']['title'])) {
            $information['title'] = $iframely['meta']['title'];
        }
        if (!empty($iframely['meta']['description'])) {
            $information['description'] = $iframely['meta']['description'];
        }
        if (!empty($iframely['meta']['duration'])) {
            $information['duration'] = $iframely['meta']['duration'];
        }
        $information['code'] = $iframely['html'];
        return $information;
    }


   protected function setPhoto($photo, $id) {
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
    } else {
      throw new Exception('invalid argument passed to setPhoto');
    }
    if (!$fileName) {
      $fileName = $file;
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesproduct_slide',
        'parent_id' => $id,
        'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        'name' => $fileName,
    );
    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');
    $mainPath = $path . DIRECTORY_SEPARATOR . $base . '_main.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
            ->resize(500, 500)
            ->write($mainPath)
            ->destroy();
    // Store
    try {
      $iMain = $filesTable->createFile($mainPath, $params);
    } catch (Exception $e) {
      // Remove temp files
      @unlink($mainPath);
      // Throw
      if ($e->getCode() == Storage_Model_DbTable_Files::SPACE_LIMIT_REACHED_CODE) {
        throw new Exception($e->getMessage(), $e->getCode());
      } else {
        throw $e;
      }
    }
    // Remove temp files
    @unlink($mainPath);
    // Update row
    // Delete the old file?
    if (!empty($tmpRow)) {
      $tmpRow->delete();
    }
    return $iMain->file_id;
  }
  public function slideshowAction(){
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();


    $photoTable = Engine_Api::_()->getDbTable('slides','sesproduct');
    $this->view->paginator = $paginator = $photoTable->fetchAll($photoTable->select()->where('product_id =?',$product->getIdentity()));
    // Make form
    $this->view->form = $form = new Sesproduct_Form_Album_Photos();
    foreach ($paginator as $photo) {
      $subform = new Sesproduct_Form_Dashboard_EditSlide(array('elementsBelongTo' => $photo->getGuid()));
      $subform->populate($photo->toArray());
      $form->addSubForm($subform, $photo->getGuid());
      $subform->removeElement('move');
    }
    if ($is_ajax) {
      return;
    }
    if (!$this->getRequest()->isPost()) {
      return;
    }
    $table = $photoTable;
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
      $values = $_POST;
      // Process
      foreach ($paginator as $photo) {
        if (isset($_POST[$photo->getGuid()])) {
          $values = $_POST[$photo->getGuid()];
        } else {
          continue;
        }
        unset($values['photo_id']);
        if (isset($values['delete']) && $values['delete'] == '1') {
          $photo->delete();
        } else {
          $photo->setFromArray($values);
          $photo->save();
        }
      }
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    //send to specific album view page.
    header('location:'.$this->view->url(array('product_id' => $product->custom_url, 'action'=>'slideshow'), 'sesproduct_dashboard', true));
  }
     public function viewAction() {
        $id = $this->_getParam('product_id', 1);
        $item = Engine_Api::_()->getItem('sesproduct', $id);
        $this->view->item = $item;
    }

    public function approvedAction() {

        $product_id = $this->_getParam('product_id');
        if (!empty($product_id)) {
        $product = Engine_Api::_()->getItem('sesproduct', $product_id);
        $product->is_approved = !$product->is_approved;
        $product->save();
        }
       // $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'edit', 'product_id' => $sesproduct->custom_url));
    }

    public function featuredAction() {
    $wishlist_id = $this->_getParam('wishlist_id',null);
    $product_id = $this->_getParam('product_id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      $product->featured = !$product->featured;
      $product->save();
      //$this->_redirect('admin/sesproduct/manage');
    }else if(empty($product_id) && !empty($wishlist_id)){
      $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
      $wishlist->is_featured = !$wishlist->is_featured;
      $wishlist->save();
      $this->_redirect('admin/sesproduct/manage/wishlist');
    }
  }


  //Sponsored Action
  public function sponsoredAction() {
    $wishlist_id = $this->_getParam('wishlist_id',null);
    $product_id = $this->_getParam('product_id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      $product->sponsored = !$product->sponsored;
      $product->save();
     // $this->_redirect('admin/sesproduct/manage');
    }else if(empty($product_id) && !empty($wishlist_id)){
        $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
        $wishlist->is_sponsored = !$wishlist->is_sponsored;
        $wishlist->save();
        $this->_redirect('admin/sesproduct/manage/wishlist');
    }
  }

  //Verify Action
  public function verifyAction() {
    $wishlist_id = $this->_getParam('wishlist_id',null);
    $product_id = $this->_getParam('product_id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      $product->verified = !$product->verified;
      $product->save();
     // $this->_redirect('admin/sesproduct/manage');
    }else if(empty($product_id) && !empty($wishlist_id)){
        $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
        $wishlist->is_private = !$wishlist->is_private;
        $wishlist->save();
        $this->_redirect('admin/sesproduct/manage/wishlist');
    }

  }

  public function ofthedayAction() {
    $wishlist_id = $this->_getParam('wishlist_id',null);
    $product_id = $this->_getParam('product_id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $item = Engine_Api::_()->getItem('sesproduct', $product_id);
      $id = $product_id;
      $dbTable = 'engine4_sesproduct_products';
      $fieldId = 'product_id';
    }else if(empty($product_id) && !empty($wishlist_id)){
        $item = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
        $id = $wishlist_id;
        $dbTable = 'engine4_sesproduct_wishlists';
        $fieldId = 'wishlist_id';
    }
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->_helper->layout->setLayout('admin-simple');
    //$id = $this->_getParam('id');
    $param = $this->_getParam('param');
    $this->view->form = $form = new Sesproduct_Form_Admin_Oftheday();
   // $item = Engine_Api::_()->getItem('sesproduct', $id);
    $form->setTitle("Product of the Day");
    $form->setDescription('Here, choose the start date and end date for this product to be displayed as "Product of the Day".');
    if (!$param)
      $form->remove->setLabel("Remove as Product of the Day");

    if (!empty($id))
      $form->populate($item->toArray());
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $values = $form->getValues();
      $values['starttime'] = date('Y-m-d',  strtotime($values['starttime']));
      $values['endtime'] = date('Y-m-d', strtotime($values['endtime']));
      $db->update($dbTable, array('starttime' => $values['starttime'], 'endtime' => $values['endtime']), array($fieldId." = ?" => $id));
      if (isset($values['remove']) && $values['remove']) {
        $db->update($dbTable, array('offtheday' => 0), array($fieldId." = ?" => $id));
      } else {
        $db->update($dbTable, array('offtheday' => 1), array($fieldId." = ?" => $id));
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Successfully updated the item.')
      ));
    }
  }
   public function manageOrdersAction() {
     $viewer = Engine_Api::_()->user()->getViewer();
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->product = $product = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $product->isOwner($viewer)))
      return;
  }

}
