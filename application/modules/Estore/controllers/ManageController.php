<?php
class Estore_ManageController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('stores', null, 'view')->isValid())
      return;
  }
 public function myStoreAction(){
     $this->_helper->content->setEnabled();
    if (!$this->_helper->requireUser()->isValid())
      return;

    // Render
    $this->_helper->content->setEnabled();
    $this->view->canCreate = $this->_helper->requireAuth()->setAuthParams('estore', null, 'create')->checkRequire();


  }
  public function billingAction()
  {
  $this->_helper->content->setEnabled();
   $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!$this->_helper->requireUser()->isValid() ) return;
    $addressTable = Engine_Api::_()->getDbTable('addresses','sesproduct');
    $billingAddressArray = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>0));
    $this->view->form = $form = new Estore_Form_Billing();
    if(count($billingAddressArray)){
        $this->view->country_id = $billingAddressArray[0]->country;
        $this->view->state_id = $billingAddressArray[0]->state;
        $form->populate($billingAddressArray[0]->toArray());
    }
     $form->setTitle('Billing form');
        $form->setAttrib('id', 'estore_billing_form');
    if($this->getRequest()->isPost())
    {
        if(!count($billingAddressArray)){
            $billing = $addressTable->createRow();
            $billing->setFromArray($_POST);
            $billing->type = 0;
            $billing->user_id = $viewer_id;
            $billing->save();
        }
        else{
            $billing = $billingAddressArray[0];
            $billing->setFromArray($_POST);
            $billing->type = 0;
            $billing->user_id = $viewer_id;
            $billing->save();
        }
         $this->_redirect('/estore/manage/billing');
    }

  }
  public function shippingAction()
  {
    $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!$this->_helper->requireUser()->isValid() ) return;
    $addressTable = Engine_Api::_()->getDbTable('addresses','sesproduct');
    $shippingAddressArray = $addressTable->getAddress(array('user_id'=>$viewer_id,'type'=>1));
    $this->view->form = $form = new Estore_Form_Billing();
    if(count($shippingAddressArray))
        $form->populate($shippingAddressArray[0]->toArray());
    $form->setTitle('Shipping form');
    $form->setAttrib('id', 'estore_shipping_form');

    if($this->getRequest()->isPost() )
    {
      if(!count($shippingAddressArray)){
            $shipping = $addressTable->createRow();
            $shipping->setFromArray($_POST);
            $shipping->type = 1;
            $shipping->user_id = $viewer_id;
            $shipping->save();
       } else{
            $shipping = $shippingAddressArray[0];
            $shipping->setFromArray($_POST);
            $shipping->type = 1;
            $shipping->user_id = $viewer_id;
            $shipping->save();
        }
        $this->_redirect('/estore/manage/shipping');
    }

  }
 public function myOrderAction()
  {


   $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
    if(!$this->_helper->requireUser()->isValid() ) return;
       $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      if($this->_getParam('is_ajax',null) && $this->_getParam('order_id',null))
        {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $order = Engine_Api::_()->getItem('sesproduct_order', $this->_getParam('order_id'))->delete();
            $db->commit();
             echo json_encode(array('status'=>1));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
         echo json_encode(array('status'=>0));die;
     }
    if ($this->getRequest()->isPost()) {
      $deleteOrder = $this->getRequest()->getPost();
      foreach ($deleteOrder as $key => $order) {
        if ($key == 'delete_' . $order) {
         if($order)
          $productOrder = Engine_Api::_()->getItem('sesproduct_order', $order)->delete();
        }
      }
    }

    $viewer = $this->view->viewer();
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    if(isset($_POST['searchParams']) && $_POST['searchParams']){
      parse_str($_POST['searchParams'], $searchArray);

    }

    $this->view->searchForm = $searchForm = new Estore_Form_Searchorder();
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
    $value['user_id'] = $viewer_id;

    $this->view->orders = $orders = Engine_Api::_()->getDbtable('orders', 'sesproduct')->manageOrders($value);

    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);

  }
  public function myWishlistsAction()
  {
        $viewer = $this->view->viewer();
        $viewer_id = $viewer->getIdentity();
        if(!$this->_helper->requireUser()->isValid() ) return;
        $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
        $this->_helper->content->setEnabled();
        $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_Wishlist();
      if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $value);
                        $wishlist->delete();
                }
            }
        }
        if($this->_getParam('is_ajax',null) && $this->_getParam('wishlist_id'))
        {

                $counter = $this->_getParam('data_count');
                $db = Engine_Db_Table::getDefaultAdapter();
                $db->beginTransaction();
                try {
                    $order = Engine_Api::_()->getItem('sesproduct_wishlist', $this->_getParam('wishlist_id'))->delete();
                    $db->commit();
                    echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Wishlist found.', '%s Wishlists found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
                } catch (Exception $e) {
                    $db->rollBack();
                    throw $e;
                }
            echo json_encode(array('status' => 0));die;
        }
        $values = array();
        if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
        $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
        ), $values);

        if (isset($_POST['searchParams']) && $_POST['searchParams'])
            parse_str($_POST['searchParams'], $searchArray);

        $this->view->assign($values);

        $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
        $productTable = Engine_Api::_()->getDbTable('wishlists', 'sesproduct');
        $productTableName = $productTable->info('name');
        $select = $productTable->select()
        ->setIntegrityCheck(false)
        ->from($productTableName)
        ->where($productTableName.'.owner_id = ?',$viewer_id)
        ->joinLeft($tableUserName, "$productTableName.owner_id = $tableUserName.user_id", 'username')
        ->order((!empty($_GET['order']) ? $_GET['order'] : 'wishlist_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

        if (!empty($searchArray['name']))
            $select->where($productTableName . '.title LIKE ?', '%' . $searchArray['name'] . '%');

        if (!empty($searchArray['owner_name']))
            $select->where($tableUserName . '.displayname LIKE ?', '%' . $searchArray['owner_name'] . '%');

        if (isset($searchArray['is_featured']) && $searchArray['is_featured'] != '')
            $select->where($productTableName . '.is_featured = ?', $searchArray['is_featured']);

        if (isset($searchArray['is_sponsored']) && $searchArray['is_sponsored'] != '')
            $select->where($productTableName . '.is_sponsored = ?', $searchArray['is_sponsored']);

        if (isset($searchArray['package_id']) && $searchArray['package_id'] != '')
            $select->where($productTableName . '.package_id = ?', $searchArray['package_id']);

        if (isset($searchArray['offtheday']) && $searchArray['offtheday'] != '')
            $select->where($productTableName . '.offtheday = ?', $searchArray['offtheday']);

        if (isset($searchArray['rating']) && $searchArray['rating'] != '') {
            if ($searchArray['rating'] == 1):
                $select->where($productTableName . '.rating <> ?', 0);
            elseif ($searchArray['rating'] == 0 && $searchArray['rating'] != ''):
                $select->where($productTableName . '.rating = ?', $searchArray['rating']);
            endif;
        }

        if (!empty($searchArray['order_max']))
				$select->having("$productTableName . '.creation_date <=?", $searchArray['order_max']);
		if (!empty($searchArray['order_min']))
				$select->having("$productTableName . '.creation_date >=?", $searchArray['order_min']);

        if (isset($searchArray['subcat_id'])) {
                $formFilter->subcat_id->setValue($searchArray['subcat_id']);
                $this->view->category_id = $searchArray['category_id'];
        }
        if (isset($searchArray['subsubcat_id'])) {
                $formFilter->subsubcat_id->setValue($searchArray['subsubcat_id']);
                $this->view->subcat_id = $searchArray['subcat_id'];
        }

        $urlParams = array();
        foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
        if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
            continue;
            $urlParams['query'][$urlParamsKey] = $urlParamsVal;
        }
        $this->view->urlParams = $urlParams;
        $paginator = Zend_Paginator::factory($select);
        $this->view->paginator = $paginator;
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  public function deleteWishlistAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('default-simple');
    $wishlist_id = $this->_getParam('wishlist_id');
    $this->view->wishlist_id = $wishlist_id;
    // Check post
    if( $this->getRequest()->isPost() )
    {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try
      {
        $sesproduct = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
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
    $this->renderScript('manage/delete.tpl');
  }
   public function myDownloadsAction()
  {
  }
  public function storeReviewsAction()
  {
    $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
    $viewer_id = $viewer->getIdentity();
     if(!$this->_helper->requireUser()->isValid() ) return;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

     $this->view->reviewFormFilter = $reviewFormFilter = new Estore_Form_Admin_Review_Filter();

    $reviewFormFilter->removeElement('product_title');

    //Process form
    $values = array();
    if ($reviewFormFilter->isValid($this->_getAllParams())) {
      $values = $reviewFormFilter->getValues();
    }

    foreach ($_GET as $key => $value) {
      if ('' === $value) {
        unset($_GET[$key]);
      } else
        $values[$key] = $value;
    }

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $video = Engine_Api::_()->getItem('estore_review', $value)->delete();
        }
      }
    }
    if($this->_getParam('is_ajax',null) && $this->_getParam('review_id'))
    {
        $counter = $this->_getParam('data_count');
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
           Engine_Api::_()->getItem('estore_review', $this->_getParam('review_id'))->delete();
            $db->commit();
             echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Review found.', '%s Reviews found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
         echo json_encode(array('status'=>0));die;
    }

    if (isset($_GET['searchParams']) && $_GET['searchParams'])
            parse_str($_GET['searchParams'], $searchArray);

     $storeTable = Engine_Api::_()->getDbTable('stores', 'estore');
     $storeTableName = $storeTable->info('name');
    $table = Engine_Api::_()->getDbtable('reviews', 'estore');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->where($tableName.'.owner_id = ?',$viewer_id)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
            ->joinLeft($storeTableName, "$storeTableName.store_id = $tableName.store_id", '*')
            ->order($tableName.'.review_id DESC');


    if (!empty($searchArray['title']))
        $select->where($tableName . '.title LIKE ?', '%' . $searchArray['title'] . '%');

    if (!empty($searchArray['rating_star']))
        $select->where($tableName . '.rating  = ?',  $searchArray['rating_star']);

    if (!empty($searchArray['store_title']))
        $select->where($storeTableName . '.title LIKE ?', '%' . $searchArray['store_title'] . '%');

    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);

  }
  public function productReviewsAction()
  {
     $this->_helper->content->setEnabled();
    $viewer = $this->view->viewer();
     $viewer_id = $viewer->getIdentity();
     if(!$this->_helper->requireUser()->isValid() ) return;
     $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

     $this->view->reviewFormFilter = $reviewFormFilter = new Estore_Form_Admin_Review_Filter();

    $reviewFormFilter->removeElement('store_title');
    //Process form
    $values = array();
    if ($reviewFormFilter->isValid($this->_getAllParams())) {
      $values = $reviewFormFilter->getValues();
    }

    foreach ($_GET as $key => $value) {
      if ('' === $value) {
        unset($_GET[$key]);
      } else
        $values[$key] = $value;
    }

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $review = Engine_Api::_()->getItem('sesproductreview', $value)->delete();
        }
      }
    }

    if($this->_getParam('is_ajax',null) && $this->_getParam('review_id'))
    {
        $counter = $this->_getParam('data_count');
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            Engine_Api::_()->getItem('sesproductreview', $this->_getParam('review_id'))->delete();
            $db->commit();
            echo json_encode(array('status' => 1,'data_count'=>$counter-1,'label'=>$this->view->translate(array('%s Review found.', '%s Reviews found.', $counter-1), $this->view->locale()->toNumber($counter-1))));die;
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        echo json_encode(array('status' => 0));die;
    }

    if (isset($_GET['searchParams']) && $_GET['searchParams'])
            parse_str($_GET['searchParams'], $searchArray);

    $productTable = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
    $productTableName = $productTable->info('name');
    $table = Engine_Api::_()->getDbtable('sesproductreviews', 'sesproduct');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
            ->from($tableName)
            ->where($tableName.'.owner_id = ?',$viewer_id)
            ->setIntegrityCheck(false)
            ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')
            ->joinLeft($productTableName, "$productTableName.product_id = $tableName.product_id", '*')
            ->order($tableName.'.review_id DESC');

    if (!empty($searchArray['title']))
        $select->where($tableName . '.title LIKE ?', '%' . $searchArray['title'] . '%');

    if (!empty($searchArray['rating_star']))
        $select->where($tableName . '.rating  = ?',  $searchArray['rating_star']);

     if (!empty($searchArray['product_title']))
        $select->where($productTableName . '.title LIKE ?', '%' . $searchArray['product_title'] . '%');

    $page = $this->_getParam('page', 1);
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);
  }
    public function deleteReviewAction() {

    $this->_helper->layout->setLayout('default-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete Review');
    $form->setDescription('Are you sure that you want to delete this review? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $review = Engine_Api::_()->getItem('estore_review', $this->_getParam('review_id'));
        $review->delete();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_forward('success', 'utility', 'core', array(
                  'smoothboxClose' => 10,
                  'parentRefresh' => 10,
                  'messages' => array('You have successfully delete entry.')
      ));
    }
  }

}
