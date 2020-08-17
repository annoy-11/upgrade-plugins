<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesproduct_IndexController extends Core_Controller_Action_Standard
{
  public function init() {
		// only show to member_level if authorized
    if(!$this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'view')->isValid() ) return;
    $id = $this->_getParam('product_id', $this->_getParam('id', null));
    $product_id = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getProductId($id);
    if ($product_id) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      if(!$product->is_approved)
        return;
      if ($product) {
		Engine_Api::_()->core()->setSubject($product);
      }
    }
  }
  function compareProductAction(){
      $product_id = $this->_getParam('product_id');
      $catgeory_id = $this->_getParam('category_id');
      $type = $this->_getParam('type');
      if($type == "add")
        $_SESSION['sesproduct_add_to_compare'][$catgeory_id][$product_id] = $product_id;
      else if($type == "all"){
          unset($_SESSION["sesproduct_add_to_compare"]);
      }else{
          if(!empty($_SESSION['sesproduct_add_to_compare'][$catgeory_id][$product_id])){
              unset($_SESSION['sesproduct_add_to_compare'][$catgeory_id][$product_id]);
          }
      }
      echo 1;die;
  }
  function compareAction(){
      // Render
      $this->_helper->content->setEnabled();
  }
  public function quickViewAction(){
      $this->view->product_id = $product_id = $this->_getParam('product_id');
      $this->view->product = $product = Engine_Api::_()->getItem('sesproduct',$product_id);

      //fetch slideshow images
      $photoTable = Engine_Api::_()->getDbTable('slides','sesproduct');
      $this->view->paginator = $paginator = $photoTable->fetchAll($photoTable->select()->where('product_id =?',$product->getIdentity())->where('enabled =?',1));

  }
  public function searchAction() {
    $text = $this->_getParam('text', null);
    $actonType = $this->_getParam('actonType', null);
    $sesvideo_commonsearch = $this->_getParam('search_type', 'sesproduct');
    if ($sesvideo_commonsearch && $actonType == 'browse') {
      $type = $sesvideo_commonsearch;
    } else {
      if (isset($_COOKIE['sesvideo_commonsearch']))
        $type = $_COOKIE['sesvideo_commonsearch'];
      else
        $type = 'sesproduct';
    }
    if(empty($type) || $type == '') {
      $type = 'sesproduct';
    }
    if ($type == 'sesproduct') {
      $table = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
      $tableName = $table->info('name');
      $id = 'product_id';
      $route = 'sesproduct_entry_view';
      $label = 'title';
    } elseif ($type == 'sesproduct_wishlist') {
      $table = Engine_Api::_()->getDbTable('wishlists', 'sesproduct');
      $tableName = $table->info('name');
      $id = 'wishlist_id';
      $route = 'sesproduct_wishlist_view';
      $label = 'title';
    }
    $data = array();
    $select = $table->select()->from($tableName);

      $select->where('title  LIKE ? ', '%' . $text . '%')->order('title ASC');

    if ($type == 'sesproduct')
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
  public function upsellProductAction(){
    $content_title = $this->_getParam('text', null);
    $table = Engine_Api::_()->getItemTable('sesproduct');
    $productTableName = $table->info('name');
    $product_id = $this->_getParam('product_id');
    $select = $table->select()
                    ->from($productTableName)
                    ->where("{$productTableName}.search = ?", 1)
                    ->where("{$productTableName}.draft != ?", 1)

                    ->where("{$productTableName}.owner_id = ?", $this->view->viewer()->user_id)
                    ->where("(`{$productTableName}`.`title` LIKE ?)", "%{$content_title}%");
    if($product_id)
        $select->where("{$productTableName}.product_id !=?",$product_id);
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
  //fetch user like item as per given item id .
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

  public function browseProductsAction() {

    $integrateothermodule_id = $this->_getParam('integrateothermodule_id', null);
    $page = 'sesproduct_index_' . $integrateothermodule_id;
    //Render
    $this->_helper->content->setContentName($page)->setEnabled();
  }

  public function indexAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  //Browse Product Contributors
  public function contributorsAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function browseAction() {
    // Render
    $this->_helper->content->setEnabled();
  }

  public function locationsAction() {
    //Render
    $this->_helper->content->setEnabled();
  }

  public function tagsAction() {
    //if (!$this->_helper->requireAuth()->setAuthParams('album', null, 'view')->isValid())
   // return;
    //Render
    $this->_helper->content->setEnabled();
  }
  public function homeAction() {
   	//Render
    $this->_helper->content->setEnabled();
  }
  public function viewAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();
    $id = $this->_getParam('product_id', null);
    $this->view->product_id = $product_id = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getProductId($id);
    if(!Engine_Api::_()->core()->hasSubject())
      $sesproduct = Engine_Api::_()->getItem('sesproduct', $product_id);
    else
      $sesproduct = Engine_Api::_()->core()->getSubject();

    if( !$this->_helper->requireSubject()->isValid() )
      return;

    if( !$this->_helper->requireAuth()->setAuthParams($sesproduct, $viewer, 'view')->isValid() )
      return;

    if( !$sesproduct || !$sesproduct->getIdentity() || ($sesproduct->draft && !$sesproduct->isOwner($viewer)) )
      return $this->_helper->requireSubject->forward();

    //Privacy: networks and member level based
    if (Engine_Api::_()->authorization()->isAllowed('sesproduct', $sesproduct->getOwner(), 'allow_levels') || Engine_Api::_()->authorization()->isAllowed('sesproduct', $sesproduct->getOwner(), 'allow_networks')) {
        $returnValue = Engine_Api::_()->sesproduct()->checkPrivacySetting($sesproduct->getIdentity());
        if ($returnValue == false) {
            return $this->_forward('requireauth', 'error', 'core');
        }
    }

    // Get styles
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', $sesproduct->getType())
            ->where('id = ?', $sesproduct->getIdentity())
            ->limit();
    $row = $table->fetchRow($select);
    if (null !== $row && !empty($row->style)) {
      $this->view->headStyle()->appendStyle($row->style);
    }

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
		if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0) {
			$view->doctype('XHTML1_RDFA');
			if($sesproduct->seo_title)
        $view->headTitle($sesproduct->seo_title, 'SET');
			if($sesproduct->seo_keywords)
        $view->headMeta()->appendName('keywords', $sesproduct->seo_keywords);
			if($sesproduct->seo_description)
        $view->headMeta()->appendName('description', $sesproduct->seo_description);
		}
    if($sesproduct->style == 2)
        $page = 'sesproduct_index_view_2';
    elseif($sesproduct->style == 3)
        $page = 'sesproduct_index_view_3';
    elseif($sesproduct->style == 4)
        $page = 'sesproduct_index_view_4';
    else 
      $page = 'sesproduct_index_view_1';
    $this->_helper->content->setContentName($page)->setEnabled();
  }

  // USER SPECIFIC METHODS
  public function manageAction() {

    if( !$this->_helper->requireUser()->isValid() ) return;

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;

    // Prepare data
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Sesproduct_Form_Search();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'create')->checkRequire();

    $form->removeElement('show');

    // Populate form
    $categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategoriesAssoc();
    if( !empty($categories) && is_array($categories) && $form->getElement('category') ) {
      $form->getElement('category')->addMultiOptions($categories);
    }
  }

  public function listAction() {

    // Preload info
    $this->view->viewer = Engine_Api::_()->user()->getViewer();
    $this->view->owner = $owner = Engine_Api::_()->getItem('user', $this->_getParam('user_id'));
    Engine_Api::_()->core()->setSubject($owner);

    if( !$this->_helper->requireSubject()->isValid() )
    return;

    // Make form
    $form = new Sesproduct_Form_Search();
    $form->populate($this->getRequest()->getParams());
    $values = $form->getValues();
    $this->view->formValues = array_filter($form->getValues());
    $values['user_id'] = $owner->getIdentity();
    $sesproduct_profileproducts = Zend_Registry::isRegistered('sesproduct_profileproducts') ? Zend_Registry::get('sesproduct_profileproducts') : null;
    if (empty($sesproduct_profileproducts))
      return $this->_forward('notfound', 'error', 'core');    // Prepare data
    $sesproductTable = Engine_Api::_()->getDbtable('sesproducts'
, 'sesproduct');

    // Get paginator
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsPaginator($values);
    $items_per_page = Engine_Api::_()->getApi('settings', 'core')->sesproduct_page;
    $paginator->setItemCountPerPage($items_per_page);
    $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );

    // Render
    $this->_helper->content
        //->setNoRender()
        ->setEnabled()
        ;
  }

  public function createAction() {
    if(!$this->_helper->requireUser()->isValid()) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'create')->isValid()) return;
        $this->view->storeId = $storeId = $this->_getParam('store_id',false);
    $store = Engine_Api::_()->getItem('stores', $storeId);
		$sessmoothbox = $this->view->typesmoothbox = false;
		if($this->_getParam('typesmoothbox',false)){
      // Render
			$sessmoothbox = true;
			$this->view->typesmoothbox = true;
			$this->_helper->layout->setLayout('default-simple');
			$layoutOri = $this->view->layout()->orientation;
      if($layoutOri == 'right-to-left'){
        $this->view->direction = 'rtl';
      }else{
        $this->view->direction = 'ltr';
      }
      $language = explode('_', $this->view->locale()->getLocale()->__toString());
      $this->view->language = $language[0];
		} else {
			$this->_helper->content->setEnabled();
		}

    //get all allowed types product
    $viewer = Engine_Api::_()->user()->getViewer();
    $allowed_types = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $viewer, 'allowed_types');
    $this->view->allowedTypes = $allowed_types;
		if(!$this->_getParam('type')){
      $this->view->showType = true;
    }

    $session = new Zend_Session_Namespace();
		if(empty($_POST))
		  unset($session->album_id);
    $this->view->defaultProfileId = $defaultProfileId = Engine_Api::_()->getDbTable('metas', 'sesproduct')->profileFieldId();
    if (isset($sesproduct->category_id) && $sesproduct->category_id != 0) {
      $this->view->category_id = $sesproduct->category_id;
    } else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
      $this->view->category_id = $_POST['category_id'];
    else
      $this->view->category_id = 0;
    if (isset($sesproduct->subsubcat_id) && $sesproduct->subsubcat_id != 0) {
      $this->view->subsubcat_id = $sesproduct->subsubcat_id;
    } else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
      $this->view->subsubcat_id = $_POST['subsubcat_id'];
    else
      $this->view->subsubcat_id = 0;
    if (isset($sesproduct->subcat_id) && $sesproduct->subcat_id != 0) {
      $this->view->subcat_id = $sesproduct->subcat_id;
    } else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
      $this->view->subcat_id = $_POST['subcat_id'];
    else
      $this->view->subcat_id = 0;


    $resource_id = $this->_getParam('resource_id', null);
    $resource_type = $this->_getParam('resource_type', null);

    $parentId = $this->_getParam('parent_id', 0);
		if($parentId && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.enable.subproduct', 1)){
			return $this->_forward('notfound', 'error', 'core');
		}

    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsPaginator($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesproduct', 'max');
    if (ESTOREPACKAGE == 1) {
      if (isset($store)) {
        $package = Engine_Api::_()->getItem('estorepackage_package', $store->package_id);
      }
      if (!isset($package)) {
        $packageId = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getDefaultPackage();
        $package = Engine_Api::_()->getItem('estorepackage_package', $packageId);
      }
      $params = json_decode($package->params, true);
      $this->view->quota = $quota = $params['product_count'];
    }

    $this->view->current_count = $paginator->getTotalItemCount();

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesproduct')->getCategoriesAssoc();

    // Prepare form
    $this->view->form = $form = new Sesproduct_Form_Create(array('defaultProfileId' => $defaultProfileId,'smoothboxType'=>$sessmoothbox,));

    // If not post or form not valid, return
    if( !$this->getRequest()->isPost() )
      return;



    if( !$form->isValid($_POST) || $this->_getParam('is_ajax')){

      if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
        $custom_url = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->checkCustomUrl($_POST['custom_url']);
        if ($custom_url) {
          $form->addError($this->view->translate("Custom URL is not available. Please select another URL."));
        }
      }
        if (isset($_POST['sku']) && !empty($_POST['sku'])) {
            $sku = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->checkSKU($_POST['sku']);
            if ($sku) {
                $form->addError($this->view->translate("SKU is not available. Please select another SKU."));
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
    //check custom url
    if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
      $custom_url = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->checkCustomUrl($_POST['custom_url']);
      if ($custom_url) {
				$form->addError($this->view->translate("Custom URL is not available. Please select another URL."));
				return;
      }
    }

    // Process
    $table = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
    $db = $table->getAdapter();
    $db->beginTransaction();
    try {
        // $defaultMeter;die;
      // Create sesproduct
      $viewer = Engine_Api::_()->user()->getViewer();
      $values = array_merge($form->getValues(), array(
        'owner_type' => $viewer->getType(),
        'owner_id' => $viewer->getIdentity(),
      ));

      if(isset($values['levels']))
         $values['levels'] = implode(',',$values['levels']);
      if(isset($values['networks']))
         $values['networks'] = implode(',',$values['networks']);
      if(isset($_POST['Height']))
        $values['height'] = $_POST['Height'];
      if(isset($_POST['Width']))
       $values['width'] = $_POST['Width'];
      if(isset($_POST['Length']))
        $values['length'] = $_POST['Length'];
      $values['ip_address'] = $_SERVER['REMOTE_ADDR'];
      $sesproduct = $table->createRow();

      if (is_null($values['subsubcat_id']))
        $values['subsubcat_id'] = 0;
      if (is_null($values['subcat_id']))
        $values['subcat_id'] = 0;
      if(!isset($values['style'])){
        $values['style'] = 1;
      }
      $sesproduct->setFromArray($values);
			//Upload Main Image
        if(isset($_FILES['photo_file']) && $_FILES['photo_file']['name'] != ''){
            $sesproduct->photo_id = Engine_Api::_()->sesbasic()->setPhoto($form->photo_file, false,false,'sesproduct','sesproduct','',$sesproduct,true);
        }

      if(empty($_POST['show_start_time'])){
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

      //discount
      //if(!empty($_POST['show_end_time'])){
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
      //}

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

      $sesproduct->parent_id = $parentId;
      $sesproduct->save();

      $product_id = $sesproduct->product_id;
      $store->product_count++;
      $store->save();

      if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
        $sesproduct->custom_url = $_POST['custom_url'];
      else
        $sesproduct->custom_url = $sesproduct->product_id;

      $sesproduct->store_id = $storeId;
      $sesproduct->save();

    if(Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $viewer, 'product_approve')) {
        $sesproduct->is_approved  = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $viewer, 'product_approve');
         $sesproduct->save();
        } else {
        $product = Engine_Api::_()->getItem('sesproduct',$sesproduct->product_id);
        $sesproduct->is_approved = Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesproduct', $viewer, 'product_approve');
        $getAdminnSuperAdmins = Engine_Api::_()->sesproduct()->getAdminnSuperAdmins();
        foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
            $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $product, 'sesproduct_product_waitApprove');
        }
        $sesproduct->save();
    }

      $product_id = $sesproduct->product_id;

      $roleTable = Engine_Api::_()->getDbtable('roles', 'sesproduct');
			$row = $roleTable->createRow();
			$row->product_id = $product_id;
			$row->user_id = $viewer->getIdentity();
			$row->save();

			// Other module work
      if(!empty($resource_type) && !empty($resource_id)) {
        $sesproduct->resource_id = $resource_id;
        $sesproduct->resource_type = $resource_type;
        $sesproduct->save();
      }
      
      if (isset($_POST['lat']) && isset($_POST['lng']) && $_POST['lat'] != '' && $_POST['lng'] != '') {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type) VALUES ("' . $product_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesproduct")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      } else {
        Engine_Db_Table::getDefaultAdapter()->query('INSERT INTO engine4_sesbasic_locations (resource_id, lat, lng , resource_type, country, state, city, zip) VALUES ("' . $product_id . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","sesproduct", "' . $_POST['country'] . '", "' . $_POST['state'] . '", "' . $_POST['city'] . '", "' . $_POST['zip'] . '")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '"');
      }

      if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
				$sesproduct->photo_id = $_POST['cover'];
				$sesproduct->save();
      }

      //upsell
      if(!empty($_POST['upsell_id'])){
        $upsell = trim($_POST['upsell_id'],',');
        $upsells = explode(',',$upsell);
        foreach($upsells as $item){
          $params['product_id'] = $sesproduct->getIdentity();
          $params['resource_id'] = $item;
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
          Engine_Api::_()->getDbTable('crosssells','sesproduct')->create($params);
        }
      }
      $customfieldform = $form->getSubForm('fields');
      if (!is_null($customfieldform)) {
				$customfieldform->setItem($sesproduct);
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
      $videoMax = array_search(isset($values['auth_video']) ? $values['auth_video']: '', $roles);
      $musicMax = array_search(isset($values['auth_music']) ? $values['auth_music']: '', $roles);

      foreach( $roles as $i => $role ) {
        $auth->setAllowed($sesproduct, $role, 'view', ($i <= $viewMax));
        $auth->setAllowed($sesproduct, $role, 'comment', ($i <= $commentMax));
        $auth->setAllowed($sesproduct, $role, 'video', ($i <= $videoMax));
        $auth->setAllowed($sesproduct, $role, 'music', ($i <= $musicMax));
      }

      // Add tags
      $tags = preg_split('/[,]+/', $values['tags']);
     // $sesproduct->seo_keywords = implode(',',$tags);
      //$sesproduct->seo_title = $sesproduct->title;
      $sesproduct->save();
      $sesproduct->tags()->addTagMaps($viewer, $tags);

      $session = new Zend_Session_Namespace();
      if(!empty($session->album_id)){
				$album_id = $session->album_id;
				if(isset($product_id) && isset($sesproduct->title)){
					Engine_Api::_()->getDbTable('albums', 'sesproduct')->update(array('product_id' => $product_id,'owner_id' => $viewer->getIdentity(),'title' => $sesproduct->title), array('album_id = ?' => $album_id));
					if(isset ($_POST['cover']) && !empty($_POST['cover'])) {
						Engine_Api::_()->getDbTable('albums', 'sesproduct')->update(array('photo_id' => $_POST['cover']), array('album_id = ?' => $album_id));
					}
					Engine_Api::_()->getDbTable('photos', 'sesproduct')->update(array('product_id' => $product_id), array('album_id = ?' => $album_id));
					unset($session->album_id);
				}
      }

      // Add activity only if sesproduct is published
    if( $values['draft'] == 0 && $values['is_approved'] == 1 && $values['enable_product'] == 1 && (!$sesproduct->starttime || strtotime($sesproduct->starttime) <= time())) {

        $action = Engine_Api::_()->getDbtable('actions', 'activity')->addActivity($viewer, $sesproduct, 'sesproduct_create_product');
        // make sure action exists before attaching the sesproduct to the activity
        if( $action ) {
          Engine_Api::_()->getDbtable('actions', 'activity')->attachActivity($action, $sesproduct);
        }

        if($action && Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
            if($sesproduct->store_id){
                $store = Engine_Api::_()->getItem('stores',$sesproduct->store_id);
                $activity = $store;
            }
            $isRowExists = Engine_Api::_()->getDbTable('details', 'sesadvancedactivity')->isRowExists($action->action_id);
            if($isRowExists) {
                $details = Engine_Api::_()->getItem('sesadvancedactivity_detail', $isRowExists);
                $details->sesresource_id = $store->getIdentity();
                $details->sesresource_type = $store->getType();
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
        $followers = Engine_Api::_()->getDbtable('followers', 'estore')->getFollowers($sesproduct->store_id);
        $favourites = Engine_Api::_()->getDbtable('favourites', 'estore')->getAllFavMembers($sesproduct->store_id);
        $likes = Engine_Api::_()->getDbtable('likes', 'core')->getAllLikes($sesproduct);
        $followerStore = array();
        $favouriteStore = array();
        $likesStore = array();

        foreach($favourites as $favourite){
            $favouriteStore[$favourite->owner_id] = $favourite->owner_id;
        }
        foreach($followers as $follower){
            $followerStore[$follower->owner_id] = $follower->owner_id;

        }
         foreach($likes as $like){
             $likesStore[$likes->owner_id] =  $likes->owner_id;

        }
        $users = array_unique(array_merge($likesStore ,$followerStore, $favouriteStore), SORT_REGULAR);

        foreach($users as $user){
            $usersOject = Engine_Api::_()->getItem('user', $user);
            $productname = '<a href="'.$sesproduct->getHref().'">'.$sesproduct->getTitle().'</a>';
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($usersOject, $viewer, $store, 'sesproduct_product_creation', array('productname' => $productname));

            Engine_Api::_()->getApi('mail', 'core')->sendSystem($usersOject->email, 'sesproduct_product_creation', array('host' => $_SERVER['HTTP_HOST'], 'product_name' => $productname,'object_link'=>$sesproduct->getHref()));

        }


        //Send notifications for subscribers
      	Engine_Api::_()->getDbtable('subscriptions', 'sesproduct')->sendNotifications($sesproduct);
      	$sesproduct->is_publish = 1;
      	$sesproduct->save();
     }
        $emails = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.emailalert', null);
        if(!empty($emails)) {
            $emailArray = explode(",",$emails);
            foreach($emailArray as $email) {
                $email = str_replace(' ', '', $email);
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'sesproduct_product_creation', array('host' => $_SERVER['HTTP_HOST'], 'product_name' => $productname,'object_link'=>$sesproduct->getHref()));
            }
        }
      // Commit
      $db->commit();
        //insert into attribute table
        Engine_Api::_()->getDbTable('cartoptions','sesproduct')->checkProduct($sesproduct);
    }

    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
     $autoOpenSharePopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.autoopenpopup', 1);
      if ($autoOpenSharePopup) {
        $_SESSION['newProduct'] = true;
      }

    $redirect = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct.redirect.creation', 1);
    if(!empty($resource_id) && !empty($resource_type)) {
      // Other module work
      $resource = Engine_Api::_()->getItem($resource_type, $resource_id);
        header('location:' . $resource->getHref());
      die;
    } else if($redirect) {
   	 	return $this->_helper->redirector->gotoRoute(array('action' => 'dashboard','action'=>'edit','product_id'=>$sesproduct->custom_url),'sesproduct_dashboard',true);
    } else {
		 	return $this->_helper->redirector->gotoRoute(array('action' => 'view','product_id'=>$sesproduct->custom_url),'sesproduct_entry_view',true);
    }
  }

  function likeAction() {

    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login'));
      die;
    }

    $type = 'sesproduct';
    $dbTable = 'sesproducts';
    $resorces_id = 'product_id';
    $notificationType = 'liked';
    $actionType = 'sesproduct_like_product';

		if($this->_getParam('type',false) && $this->_getParam('type') == 'sesproduct_album'){
			$type = 'sesproduct_album';
	    $dbTable = 'albums';
	    $resorces_id = 'album_id';
	    $actionType = 'sesproduct_album_like';
		} else if($this->_getParam('type',false) && $this->_getParam('type') == 'sesproduct_photo') {
			$type = 'sesproduct_photo';
	    $dbTable = 'photos';
	    $resorces_id = 'photo_id';
	    $actionType = 'sesproduct_photo_like';
		}else if($this->_getParam('type',false) && $this->_getParam('type') == 'sesproduct_wishlist'){
      $type = 'sesproduct_wishlist';
	    $dbTable = 'wishlists';
	    $resorces_id = 'wishlist_id';
	    $actionType = 'liked';
    }

    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));
      die;
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $itemTable = Engine_Api::_()->getDbtable($dbTable, 'sesproduct');
    $tableLike = Engine_Api::_()->getDbtable('likes', 'core');
    $tableMainLike = $tableLike->info('name');

    $select = $tableLike->select()
            ->from($tableMainLike)
            ->where('resource_type = ?', $type)
            ->where('poster_id = ?', $viewer_id)
            ->where('poster_type = ?', 'user')
            ->where('resource_id = ?', $item_id);
    $result = $tableLike->fetchRow($select);

    if (count($result) > 0) {
      //delete
      $db = $result->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $result->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $item = Engine_Api::_()->getItem($type, $item_id);
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->like_count));
      die;
    } else {

      //update
      $db = Engine_Api::_()->getDbTable('likes', 'core')->getAdapter();
      $db->beginTransaction();
      try {

        $like = $tableLike->createRow();
        $like->poster_id = $viewer_id;
        $like->resource_type = $type;
        $like->resource_id = $item_id;
        $like->poster_type = 'user';
        $like->save();

        $itemTable->update(array('like_count' => new Zend_Db_Expr('like_count + 1')), array($resorces_id . '= ?' => $item_id));

        //Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      //Send notification and activity feed work.
      $item = Engine_Api::_()->getItem($type, $item_id);
      $subject = $item;
      $owner = $subject->getOwner();
	     if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity()) {
	       $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
	       Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	       Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
	       $result = $activityTable->fetchRow(array('type =?' => $actionType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));

	       if (!$result) {
          if($subject && empty($subject->title) && $this->_getParam('type') == 'sesproduct_photo') {
            $album_id = $subject->album_id;
            $subject = Engine_Api::_()->getItem('sesproduct_album', $album_id);
          }
	        $action = $activityTable->addActivity($viewer, $subject, $actionType);
	        if ($action)
	          $activityTable->attachActivity($action, $subject);
	       }
	     }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->like_count));
      die;
    }
  }



  //item favourite as per item tye given
  function favouriteAction() {
    if (Engine_Api::_()->user()->getViewer()->getIdentity() == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Login')); die;
    }
    if($this->_getParam('type') == 'sesproduct') {
      $type = 'sesproduct';
      $dbTable = 'sesproducts';
      $resorces_id = 'product_id';
      $notificationType = 'sesproduct_favourite_product';
    } else if ($this->_getParam('type') == 'sesproduct_photo') {
      $type = 'sesproduct_photo';
      $dbTable = 'photos';
      $resorces_id = 'photo_id';
     // $notificationType = 'sesproduct_favourite_playlist';
    }elseif ($this->_getParam('type') == 'sesproduct_wishlist') {
      $type = 'sesproduct_wishlist';
      $dbTable = 'wishlists';
      $resorces_id = 'wishlist_id';
      $notificationType = 'sesproduct_wishlist_favourite';
    }
     else if ($this->_getParam('type') == 'sesproduct_album') {
      $type = 'sesproduct_album';
      $dbTable = 'albums';
      $resorces_id = 'album_id';
     // $notificationType = 'sesproduct_favourite_playlist';
    }
    $item_id = $this->_getParam('id');
    if (intval($item_id) == 0) {
      echo json_encode(array('status' => 'false', 'error' => 'Invalid argument supplied.'));die;
    }
    $viewer = Engine_Api::_()->user()->getViewer();
    $Fav = Engine_Api::_()->getDbTable('favourites', 'sesproduct')->getItemfav($type, $item_id);

    $favItem = Engine_Api::_()->getDbtable($dbTable, 'sesproduct');
    if (count($Fav) > 0) {
      //delete
      $db = $Fav->getTable()->getAdapter();
      $db->beginTransaction();
      try {
        $Fav->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count - 1')), array($resorces_id . ' = ?' => $item_id));
      $item = Engine_Api::_()->getItem($type, $item_id);
      if(@$notificationType) {
	      Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
	      Engine_Api::_()->getDbtable('actions', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $item->getType(), "object_id = ?" => $item->getIdentity()));
	      Engine_Api::_()->getDbtable('actions', 'activity')->detachFromActivity($item);
      }
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'reduced', 'count' => $item->favourite_count));
      $this->view->favourite_id = 0;
      die;
    } else {
      //update
      $db = Engine_Api::_()->getDbTable('favourites', 'sesproduct')->getAdapter();
      $db->beginTransaction();
      try {
        $fav = Engine_Api::_()->getDbTable('favourites', 'sesproduct')->createRow();
        $fav->user_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $fav->resource_type = $type;
        $fav->resource_id = $item_id;
        $fav->save();
        $favItem->update(array('favourite_count' => new Zend_Db_Expr('favourite_count + 1'),
                ), array(
            $resorces_id . '= ?' => $item_id,
        ));
        // Commit
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      //send notification and activity feed work.
      $item = Engine_Api::_()->getItem(@$type, @$item_id);
      if(@$notificationType) {
	      $subject = $item;
	      $owner = $subject->getOwner();
	      if ($owner->getType() == 'user' && $owner->getIdentity() != $viewer->getIdentity() && @$notificationType) {
	        $activityTable = Engine_Api::_()->getDbtable('actions', 'activity');
	        Engine_Api::_()->getDbtable('notifications', 'activity')->delete(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner, $viewer, $subject, $notificationType);
	        $result = $activityTable->fetchRow(array('type =?' => $notificationType, "subject_id =?" => $viewer->getIdentity(), "object_type =? " => $subject->getType(), "object_id = ?" => $subject->getIdentity()));
	        if (!$result) {
	          $action = $activityTable->addActivity($viewer, $subject, $notificationType);
	          if ($action)
	            $activityTable->attachActivity($action, $subject);
	        }
	      }
      }
      $this->view->favourite_id = 1;
      echo json_encode(array('status' => 'true', 'error' => '', 'condition' => 'increment', 'count' => $item->favourite_count, 'favourite_id' => 1));
      die;
    }
  }

  public function deleteAction() {
    $sesproduct = Engine_Api::_()->getItem('sesproduct', $this->getRequest()->getParam('product_id'));
    if( !$this->_helper->requireAuth()->setAuthParams($sesproduct, null, 'delete')->isValid()) return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $this->view->form = $form = new Sesproduct_Form_Delete();
    if( !$sesproduct ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_("product entry doesn't exist or not authorized to delete");
      return;
    }
    if( !$this->getRequest()->isPost() ) {
      $this->view->status = false;
      $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
      return;
    }
    $db = $sesproduct->getTable()->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->sesproduct()->deleteProduct($sesproduct);;
      $db->commit();
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $this->view->status = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your product entry has been deleted.');
    return $this->_forward('success' ,'utility', 'core', array(
      'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'sesproduct_general', true),
      'messages' => array($this->view->message)
    ));
  }

  public function styleAction() {
    if( !$this->_helper->requireUser()->isValid() ) return;
    if( !$this->_helper->requireAuth()->setAuthParams('sesproduct', null, 'style')->isValid()) return;
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    // Require user
    if( !$this->_helper->requireUser()->isValid() ) return;
    $user = Engine_Api::_()->user()->getViewer();
    // Make form
    $this->view->form = $form = new Sesproduct_Form_Style();
    // Get current row
    $table = Engine_Api::_()->getDbtable('styles', 'core');
    $select = $table->select()
      ->where('type = ?', 'user_sesproduct') // @todo this is not a real type
      ->where('id = ?', $user->getIdentity())
      ->limit(1);
    $row = $table->fetchRow($select);
    // Check post
    if( !$this->getRequest()->isPost() )
    {
      $form->populate(array(
        'style' => ( null === $row ? '' : $row->style )
      ));
      return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) return;
    // Cool! Process
    $style = $form->getValue('style');
    // Save
    if( null == $row ) {
      $row = $table->createRow();
      $row->type = 'user_sesproduct'; // @todo this is not a real type
      $row->id = $user->getIdentity();
    }
    $row->style = $style;
    $row->save();
    $this->view->draft = true;
    $this->view->message = Zend_Registry::get('Zend_Translate')->_("Your changes have been saved.");
    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => false,
        'messages' => array($this->view->message)
    ));
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
      throw new User_Model_Exception('invalid argument passed to setPhoto');
    }
    if (!$fileName) {
      $fileName = $file;
    }
    $name = basename($file);
    $extension = ltrim(strrchr($fileName, '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';
    $params = array(
        'parent_type' => 'sesproduct',
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
        throw new Sesproduct_Model_Exception($e->getMessage(), $e->getCode());
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
  public function subcategoryAction() {

    $category_id = $this->_getParam('category_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesproduct');
      $category_select = $categoryTable->select()
              ->from($categoryTable->info('name'))
              ->where('subcat_id = ?', $category_id);
      $subcategory = $categoryTable->fetchAll($category_select);
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
        if($CategoryType == 'search') {
          $data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
	  foreach ($subcategory as $category) {
	    $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
	  }
        }
        else {
          //$data .= '<option value="0">' . Zend_Registry::get('Zend_Translate')->_("Choose 2nd Level Category") . '</option>';
	    $data .= '<option value=""></option>';
	    foreach ($subcategory as $category) {
	      $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '" >' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
	    }

        }
      }
    } else
      $data = '';
    echo $data;
    die;
  }
  public function subsubcategoryAction() {

    $category_id = $this->_getParam('subcategory_id', null);
    $CategoryType = $this->_getParam('type', null);
    if ($category_id) {
      $categoryTable = Engine_Api::_()->getDbtable('categories', 'sesproduct');
      $category_select = $categoryTable->select()
              ->from($categoryTable->info('name'))
              ->where('subsubcat_id = ?', $category_id);
      $subcategory = $categoryTable->fetchAll($category_select);
      $count_subcat = count($subcategory->toarray());
      if (isset($_POST['selected']))
        $selected = $_POST['selected'];
      else
        $selected = '';
      $data = '';
      if ($subcategory && $count_subcat) {
	  $data .= '<option value=""></option>';
	  foreach ($subcategory as $category) {
	    $data .= '<option ' . ($selected == $category['category_id'] ? 'selected = "selected"' : '') . ' value="' . $category["category_id"] . '">' . Zend_Registry::get('Zend_Translate')->_($category["category_name"]) . '</option>';
	  }

      }
    } else
      $data = '';
    echo $data;
    die;
  }

  public function editPhotoAction() {
    $this->view->photo_id = $photo_id = $this->_getParam('photo_id');
    $this->view->photo = Engine_Api::_()->getItem('sesproduct_photo', $photo_id);
  }

  public function saveInformationAction() {

    $photo_id = $this->_getParam('photo_id');
    $title = $this->_getParam('title', null);
    $description = $this->_getParam('description', null);
    Engine_Api::_()->getDbTable('photos', 'sesproduct')->update(array('title' => $title, 'description' => $description), array('photo_id = ?' => $photo_id));
  }

  public function removeAction() {

    if(empty($_POST['photo_id']))die('error');
    $photo_id = (int) $this->_getParam('photo_id');
    $photo = Engine_Api::_()->getItem('sesproduct_photo', $photo_id);
    $db = Engine_Api::_()->getDbTable('photos', 'sesproduct')->getAdapter();
    $db->beginTransaction();
    try {
      Engine_Api::_()->getDbtable('photos', 'sesproduct')->delete(array('photo_id =?' => $photo_id));
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
  }

  public function getProductAction() {
    $sesdata = array();
    $value['textSearch'] = $this->_getParam('text', null);
    $value['search'] = 1;
		$value['fetchAll'] = true;
		$value['getproduct'] = true;
    $products = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsSelect($value);
    foreach ($products as $product) {
      $video_icon = $this->view->itemPhoto($product, 'thumb.icon');
      $sesdata[] = array(
          'id' => $product->product_id,
          'product_id' => $product->product_id,
          'label' => $product->title,
          'photo' => $video_icon
      );
    }
    return $this->_helper->json($sesdata);
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
    $typeItem = ucwords(str_replace(array('sesproduct_'), '', $attachment->getType()));
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

  public function locationAction() {

    $this->view->type = $this->_getParam('type', 'product');
    $this->view->product_id = $product_id = $this->_getParam('product_id');
    $this->view->product = $product = Engine_Api::_()->getItem('sesproduct', $product_id);
    if (!$product)
      return;
    $this->view->form = $form = new Sesproduct_Form_Location();
    $form->populate($product->toArray());
  }

  public function customUrlCheckAction(){
    $value = $this->sanitize($this->_getParam('value', null));
    if(!$value) {
      echo json_encode(array('error'=>true));die;
    }
    $product_id = $this->_getParam('product_id',null);
    $custom_url = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->checkCustomUrl($value,$product_id);
    if($custom_url){
      echo json_encode(array('error'=>true,'value'=>$value));die;
    }else{
      echo json_encode(array('error'=>false,'value'=>$value));die;
    }
  }

  function sanitize($string, $force_lowercase = true, $anal = false) {
    $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
    "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
    "â€”", "â€“", ",", "<", ".", ">", "/", "?");
    $clean = trim(str_replace($strip, "", strip_tags($string)));
    $clean = preg_replace('/\s+/', "-", $clean);
    $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
    return ($force_lowercase) ?
    (function_exists('mb_strtolower')) ?
    mb_strtolower($clean, 'UTF-8') :
    strtolower($clean) :
    $clean;
  }

	public function getProductsAction() {
		$sesdata = array();
		$viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
		$productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
		$productTableName = $productTable->info('name');
		$productClaimTable = Engine_Api::_()->getDbtable('claims', 'sesproduct');
		$productClaimTableName = $productClaimTable->info('name');
		$text = $this->_getParam('text', null);
		$selectClaimTable = $productClaimTable->select()
                                          ->from($productClaimTableName, 'product_id')
                                          ->where('user_id =?', $viewerId);
		$claimedProducts = $productClaimTable->fetchAll($selectClaimTable);

		$currentTime = date('Y-m-d H:i:s');
		$select = $productTable->select()
		->where('draft =?', 0)
		->where("publish_date <= '$currentTime' OR publish_date = ''")
		->where('owner_id !=?', $viewerId)
		->where($productTableName .'.title  LIKE ? ', '%' .$text. '%');
		if(count($claimedProducts) > 0)
		$select->where('product_id NOT IN(?)', $selectClaimTable);
		$select->order('product_id ASC')->limit('20');
		$products = $productTable->fetchAll($select);
		foreach ($products as $product) {
			$product_icon_photo = $this->view->itemPhoto($product, 'thumb.icon');
			$sesdata[] = array(
			'id' => $product->product_id,
			'label' => $product->title,
			'photo' => $product_icon_photo
			);
		}
		return $this->_helper->json($sesdata);
	}
    public function YoutubeVideoInfo($uri) {
      $video_id = explode("?v=", $uri);
      $video_id = $video_id[1];
      $key = Engine_Api::_()->getApi('settings', 'core')->getSetting('video.youtube.apikey');
      if(empty($key)){
          return;
      }
      $url = 'https://www.googleapis.com/youtube/v3/videos?id='.$video_id.'&key='.$key.'&part=snippet,player,contentDetails';
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      $response = curl_exec($ch);
      curl_close($ch);
      $response_a = json_decode($response,TRUE);    
      $iframely =  $response_a['items'][0];
      if (!in_array('player', array_keys($iframely))) {
          return;
      }
      $information = array('thumbnail' => '', 'title' => '', 'description' => '', 'duration' => '');
      if (!empty($iframely['snippet']['thumbnails'])) {
          $information['thumbnail'] = $iframely['snippet']['thumbnails']['high']['url'];
          if (parse_url($information['thumbnail'], PHP_URL_SCHEME) === null) {
              $information['thumbnail'] = str_replace(array('://', '//'), '', $information['thumbnail']);
              $information['thumbnail'] = "http://" . $information['thumbnail'];
          }
      }
      if (!empty($iframely['snippet']['title'])) {
          $information['title'] = $iframely['snippet']['title'];
      }
      if (!empty($iframely['snippet']['description'])) {
          $information['description'] = $iframely['snippet']['description'];
      }
      if (!empty($iframely['contentDetails']['duration'])) {
          $information['duration'] =  Engine_Date::convertISO8601IntoSeconds($iframely['contentDetails']['duration']);
      }
      $information['code'] = $iframely['player']['embedHtml'];
      return $information; 
  }
  public function handleIframelyInformation($uri) {
    $iframelyDisallowHost = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesproduct_iframely_disallow');
    if (parse_url($uri, PHP_URL_SCHEME) === null) {
        $uri = "http://" . $uri;
    }
    $uriHost = Zend_Uri::factory($uri)->getHost();
    if ($iframelyDisallowHost && in_array($uriHost, $iframelyDisallowHost)) {
        return;
    }
    if(in_array($uriHost, array('youtube.com','www.youtube.com','youtube'))){
        return $this->YoutubeVideoInfo($uri);
    } else {
        $config = Engine_Api::_()->getApi('settings', 'core')->core_iframely;
        $iframely = Engine_Iframely::factory($config)->get($uri);
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

  public function validationAction() {
    $url = trim(strip_tags($this->_getParam('uri')));
    $ajax = $this->_getParam('ajax', false);
    $information = $this->handleIframelyInformation($url);
    $this->view->ajax = $ajax;
    $this->view->valid = !empty($information['code']);
    $this->view->iframely = $information;
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
        $itemTable = Engine_Api::_()->getItemTable('sesproductreview');
        $tableVotes = Engine_Api::_()->getDbtable('reviewvotes', 'sesproduct');
        $tableMainVotes = $tableVotes->info('name');

        $review = Engine_Api::_()->getItem('sesproductreview',$item_id);
        $product = Engine_Api::_()->getItem('sesproduct',$review->product_id);


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
            $db = Engine_Api::_()->getDbTable('reviewvotes', 'sesproduct')->getAdapter();
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
    public function notifyAction()
    {
        $viewer = $this->view->viewer();
        $viewer_id = $viewer->getIdentity();
       $product_id = $this->_getParam('product_id',null);
       $gmail = $this->_getParam('gmail',null);
       if(!isset($gmail))
       {
            $this->view->nullGmail = true;
       }
       if(isset($product_id) && isset($gmail)){
            $product = Engine_Api::_()->getItem('sesproduct',$product_id);
           $notifyMeTable = Engine_Api::_()->getDbtable('notify','sesproduct');

           $notify = $notifyMeTable->createRow();
           $notify->product_id = $product_id;
           $notify->store_id = $product->store_id;
           $notify->gmail = $gmail;
           $notify->user_id = $viewer_id;
           $notify->save();

       }
    }

}
