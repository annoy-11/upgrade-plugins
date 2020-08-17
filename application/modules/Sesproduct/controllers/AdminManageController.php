<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_manage');

    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main_manage', array(), 'sesproduct_admin_main_manage');

    $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_Filter();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $sesproduct = Engine_Api::_()->getItem('sesproduct', $value);
            Engine_Api::_()->sesproduct()->deleteProduct($sesproduct);
        }
      }
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $storesTable = Engine_Api::_()->getItemTable('stores')->info('name');
    $productTable = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct');
    $productTableName = $productTable->info('name');
    $select = $productTable->select()
                        ->setIntegrityCheck(false)
                        ->from($productTableName)
                        ->joinLeft($tableUserName, "$productTableName.owner_id = $tableUserName.user_id", null)
                        ->joinLeft($storesTable, "$productTableName.store_id = $storesTable.store_id",null)
                        ->order((!empty($_GET['order']) ? $_GET['order'] : 'product_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
        $select->where($productTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
        $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (!empty($_GET['store_name']))
        $select->where($storesTable . '.title LIKE ?', '%' . $_GET['store_name'] . '%');

    if (!empty($_GET['sku']))
        $select->where($productTableName . '.sku LIKE ?', '%' . $_GET['sku'] . '%');

    if (isset($_GET['stock']) && $_GET['stock'] == '1') {
         $select->where("CASE
    WHEN (".$productTableName . ".manage_stock = 1".") THEN (".$productTableName . ".stock_quatity > 0) ElSE (".$productTableName . ".manage_stock = 0)"." END");
   } else if(isset($_GET['stock']) && $_GET['stock'] == '0') {
         $select->where("CASE
    WHEN (".$productTableName . ".manage_stock = 1".") THEN (".$productTableName . ".stock_quatity < 1) AND (".$productTableName . ".manage_stock = 1) END");

    }

    if (!empty($_GET['discount']))
        $select->where($productTableName . '.discount =?', $_GET['discount']);

    if (!empty($_GET['price']['price_max']))
        $select->having($productTableName.".price <=?", $_GET['price']['price_max']);

    if (!empty($_GET['price']['price_min']))
        $select->having($productTableName.".price >=?", $_GET['price']['price_min']);

    if (!empty($_GET['brand_name']))
        $select->where($productTableName . '.brand LIKE ?', '%' . $_GET['brand_name'] . '%');

    if (!empty($_GET['product_type']))
        $select->where($productTableName . '.type LIKE ?', '%' . $_GET['product_type'] . '%');

    if (!empty($_GET['category_id']))
      $select->where($productTableName . '.category_id =?', $_GET['category_id']);

    if (!empty($_GET['subcat_id']))
      $select->where($productTableName . '.subcat_id =?', $_GET['subcat_id']);

    if (!empty($_GET['subsubcat_id']))
      $select->where($productTableName . '.subsubcat_id =?', $_GET['subsubcat_id']);

    if (isset($_GET['featured']) && $_GET['featured'] != '')
    $select->where($productTableName . '.featured = ?', $_GET['featured']);

    if (isset($_GET['sponsored']) && $_GET['sponsored'] != '')
    $select->where($productTableName . '.sponsored = ?', $_GET['sponsored']);

		if (isset($_GET['package_id']) && $_GET['package_id'] != '')
    $select->where($productTableName . '.package_id = ?', $_GET['package_id']);

    if (isset($_GET['status']) && $_GET['status'] != '')
    $select->where($productTableName . '.draft = ?', $_GET['status']);

    if (isset($_GET['enable_product']) && $_GET['enable_product'] != '')
      $select->where($productTableName . '.enable_product = ?', $_GET['enable_product']);

    if (isset($_GET['is_approved']) && $_GET['is_approved'] != '')
    	$select->where($productTableName . '.is_approved = ?', $_GET['is_approved']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
    $select->where($productTableName . '.verified = ?', $_GET['verified']);

    if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
    $select->where($productTableName . '.offtheday = ?', $_GET['offtheday']);

    if (isset($_GET['rating']) && $_GET['rating'] != '') {
      if ($_GET['rating'] == 1):
      $select->where($productTableName . '.rating <> ?', 0);
      elseif ($_GET['rating'] == 0 && $_GET['rating'] != ''):
      $select->where($productTableName . '.rating = ?', $_GET['rating']);
      endif;
    }

    if (!empty($_GET['creation_date']))
        $select->where($productTableName . '.creation_date LIKE ?', $_GET['creation_date'] . '%');

    if (isset($_GET['subcat_id'])) {
        $formFilter->subcat_id->setValue($_GET['subcat_id']);
        $this->view->category_id = $_GET['category_id'];
    }

    if (isset($_GET['subsubcat_id'])) {
        $formFilter->subsubcat_id->setValue($_GET['subsubcat_id']);
        $this->view->subcat_id = $_GET['subcat_id'];
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

  public function wishlistAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'estore_admin_main_managewishlists');

    $this->view->formFilter = $formFilter = new Sesproduct_Form_Admin_Wishlist();
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
            $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $value);
            $wishlist->delete();
        }
      }
      $this->_redirect('admin/sesproduct/manage/wishlist');
    }

    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();
    $values = array_merge(array(
        'order' => isset($_GET['order']) ? $_GET['order'] :'',
        'order_direction' => isset($_GET['order_direction']) ? $_GET['order_direction'] : '',
    ), $values);
    $this->view->assign($values);

    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $productTable = Engine_Api::_()->getDbTable('wishlists', 'sesproduct');
    $productTableName = $productTable->info('name');
    $select = $productTable->select()
        ->setIntegrityCheck(false)
        ->from($productTableName)
        ->joinLeft($tableUserName, "$productTableName.owner_id = $tableUserName.user_id", 'username')
        ->order((!empty($_GET['order']) ? $_GET['order'] : 'product_id' ) . ' ' . (!empty($_GET['order_direction']) ? $_GET['order_direction'] : 'DESC' ));

    if (!empty($_GET['name']))
    $select->where($productTableName . '.title LIKE ?', '%' . $_GET['name'] . '%');

    if (!empty($_GET['owner_name']))
    $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['is_featured']) && $_GET['is_featured'] != '')
    $select->where($productTableName . '.is_featured = ?', $_GET['is_featured']);

    if (isset($_GET['is_sponsored']) && $_GET['is_sponsored'] != '')
    $select->where($productTableName . '.is_sponsored = ?', $_GET['is_sponsored']);

		if (isset($_GET['package_id']) && $_GET['package_id'] != '')
    $select->where($productTableName . '.package_id = ?', $_GET['package_id']);

    if (isset($_GET['is_private']) && $_GET['is_private'] != '')
     $select->where($productTableName . '.is_private = ?', $_GET['is_private']);

     if (isset($_GET['offtheday']) && $_GET['offtheday'] != '')
     $select->where($productTableName . '.offtheday = ?', $_GET['offtheday']);

    if (!empty($_GET['date']['date_from']))
        $select->having($productTableName . '.creation_date <=?', $_GET['date']['date_from']);

    if (!empty($_GET['date']['date_to']))
            $select->having($productTableName . '.creation_date >=?', $_GET['date']['date_to']);

    $urlParams = array();
    foreach (Zend_Controller_Front::getInstance()->getRequest()->getParams() as $urlParamsKey=>$urlParamsVal){
      if($urlParamsKey == 'module' || $urlParamsKey == 'controller' || $urlParamsKey == 'action' || $urlParamsKey == 'rewrite')
      continue;
      $urlParams['query'][$urlParamsKey] = $urlParamsVal;
    }
    $this->view->urlParams = $urlParams;
    $paginator = Zend_Paginator::factory($select);
    $this->view->paginator = $paginator;
    $paginator->setItemCountPerPage(20);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }

  public function deleteWishlistAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $wishlist_id = $this->_getParam('wishlist_id');
    $this->view->wishlist_id = $wishlist_id;
    // Check post
    if( $this->getRequest()->isPost() ) {
        $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
        $db = $wishlist->getTable()->getAdapter();
        $db->beginTransaction();
        try {
            Engine_Api::_()->getDbtable('playlistproducts', 'sesproduct')->delete(array('wishlist_id =?' => $this->_getParam('wishlist_id')));
            $wishlist->delete();
            $db->commit();
        } catch(Exception $e) {
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
    $this->renderScript('admin-manage/delete.tpl');
  }

  public function deleteAction()
  {
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->product_id=$id;
    // Check post
    if( $this->getRequest()->isPost() )
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
    $this->renderScript('admin-manage/delete.tpl');
  }

  //Approved Action
  public function approvedAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $product_id = $this->_getParam('id');
    if (!empty($product_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);

      $product->is_approved = !$product->is_approved;
      $product->save();
      if($product->is_approved) {
        Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($product->getOwner(), $viewer, $product, 'sesproduct_product_approve');

         Engine_Api::_()->getApi('mail', 'core')->sendSystem($product->getOwner()->email, 'sesproduct_product_approved', array('host' => $_SERVER['HTTP_HOST'],'product_name' => $product->getTitle(),'member_name'=>$product->getOwner()->getTitle(),'object_link'=>$product->getHref()));
      } else {
         Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($product->getOwner(), $viewer, $product, 'sesproduct_product_disapproved');

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($product->getOwner()->email, 'sesproduct_product_disapproved', array('host' => $_SERVER['HTTP_HOST'],'product_name' => $product->getTitle(),'member_name'=>$product->getOwner()->getTitle(),'object_link'=>$product->getHref()));
      }
    }
    $this->_redirect('admin/sesproduct/manage');
  }
//open/closed Action
    public function enabledAction() {

        $product_id = $this->_getParam('id');
        if (!empty($product_id)) {
            $product = Engine_Api::_()->getItem('sesproduct', $product_id);
            $product->enable_product = !$product->enable_product;
            $product->save();
        }
        $this->_redirect('admin/sesproduct/manage');
    }

  //Featured Action
  public function featuredAction() {
    $wishlist_id = $this->_getParam('wishlist_id',null);
    $product_id = $this->_getParam('id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      $product->featured = !$product->featured;
      $product->save();
      $this->_redirect('admin/sesproduct/manage');
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
    $product_id = $this->_getParam('id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      $product->sponsored = !$product->sponsored;
      $product->save();
      $this->_redirect('admin/sesproduct/manage');
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
    $product_id = $this->_getParam('id',null);
    if (!empty($product_id) && empty($wishlist_id)) {
      $product = Engine_Api::_()->getItem('sesproduct', $product_id);
      $product->verified = !$product->verified;
      $product->save();
      $this->_redirect('admin/sesproduct/manage');
    }else if(empty($product_id) && !empty($wishlist_id)){
        $wishlist = Engine_Api::_()->getItem('sesproduct_wishlist', $wishlist_id);
        $wishlist->is_private = !$wishlist->is_private;
        $wishlist->save();
        $this->_redirect('admin/sesproduct/manage/wishlist');
    }

  }

  public function ofthedayAction() {
    $wishlist_id = $this->_getParam('wishlist_id',null);
    $product_id = $this->_getParam('id',null);
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

  public function showDetailAction() {
    $claimId = $this->_getParam('id');
    $this->view->claimItem = Engine_Api::_()->getItem('sesproduct_claim', $claimId);
  }

  //view item function
  public function viewAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('sesproduct', $id);
    $this->view->item = $item;
  }
    public function viewWishlistAction() {
    $id = $this->_getParam('id', 1);
    $item = Engine_Api::_()->getItem('sesproduct_wishlist', $id);
    $this->view->item = $item;
  }

   // Manage Reviews & Ratings Settings
  public function reviewSettingsAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'sesproduct_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesproduct_admin_main_reviewsettings', array(), 'sesproduct_admin_main_storereviewsettings');
    $this->view->form = $form = new Sesmember_Form_Admin_Manage_ReviewSettings();
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
    public function manageReviewsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main', array(), 'sesmember_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main_review', array(), 'sesmember_admin_main_managereview');

    $this->view->formFilter = $formFilter = new Sesmember_Form_Admin_Manage_Review_Filter();

    //Process form
    $values = array();
    if ($formFilter->isValid($this->_getAllParams()))
      $values = $formFilter->getValues();

    foreach ($_GET as $key => $value) {
      if ('' === $value)
        unset($_GET[$key]);
      else
        $values[$key] = $value;
    }

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          Engine_Api::_()->getItem('sesmember_review', $value)->delete();
        }
      }
    }

    $table = Engine_Api::_()->getDbtable('sesproductreviews', 'sesmember');
    $tableName = $table->info('name');
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');
    $select = $table->select()
                    ->from($tableName)
                    ->setIntegrityCheck(false)
                    ->joinLeft($tableUserName, "$tableUserName.user_id = $tableName.owner_id", 'username')->order('review_id DESC');

    // Set up select info
    if (!empty($_GET['title']))
      $select->where($tableName . '.title LIKE ?', '%' . $values['title'] . '%');

    if (isset($_GET['featured']) && $_GET['featured'] != '')
      $select->where($tableName . '.featured = ?', $values['featured']);

    if (isset($_GET['new']) && $_GET['new'] != '')
      $select->where('new = ?', $values['new']);

    if (isset($_GET['verified']) && $_GET['verified'] != '')
      $select->where($tableName . '.verified = ?', $values['verified']);

    if (!empty($values['creation_date']))
      $select->where('date(' . $tableName . '.creation_date) = ?', $values['creation_date']);

    if (!empty($_GET['owner_name']))
      $select->where($tableUserName . '.displayname LIKE ?', '%' . $_GET['owner_name'] . '%');

    if (isset($_GET['oftheday']) && $_GET['oftheday'] != '')
      $select->where($tableName . '.oftheday =?', $values['oftheday']);

    $page = $this->_getParam('page', 1);

    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(100);
    $paginator->setCurrentPageNumber($page);
  }

   public function levelSettingsAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main', array(), 'sesmember_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main_review', array(), 'sesmember_admin_main_levelsettings');

    //Get level id
    if (null !== ($id = $this->_getParam('level_id', $this->_getParam('id'))))
      $level = Engine_Api::_()->getItem('authorization_level', $id);
    else
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();

    if (!$level instanceof Authorization_Model_Level)
      throw new Engine_Exception('missing level');

    $id = $level->level_id;

    //Make form
    $this->view->form = $form = new Sesmember_Form_Admin_Manage_Level(array(
        'public' => ( in_array($level->type, array('public')) ),
        'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));
    $form->level_id->setValue($id);

    $content_type = 'sesmember_review';
    $module_name = $this->_getParam('module_name', null);

    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');
    $form->populate($permissionsTable->getAllowed($content_type, $id, array_keys($form->getValues())));

    //Check post
    if (!$this->getRequest()->isPost())
      return;

    //Check validitiy
    if (!$form->isValid($this->getRequest()->getPost()))
      return;

    //Process
    $values = $form->getValues();

    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();
    try {
      //Set permissions
      $permissionsTable->setAllowed($content_type, $id, $values);
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $form->addNotice('Your changes have been saved.');
  }

  public function reviewParameterAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('estore_admin_main', array(), 'sesmember_admin_main_reviewsettings');
    $this->view->subNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmember_admin_main_review', array(), 'sesmember_admin_main_reviewparameter');

    //START PROFILE TYPE WORK
    $optionsData = Engine_Api::_()->getApi('core', 'fields')->getFieldsOptions('user');
    $mapData = Engine_Api::_()->getApi('core', 'fields')->getFieldsMaps('user');
    // Get top level fields
    $topLevelMaps = $mapData->getRowsMatching(array('field_id' => 0, 'option_id' => 0));
    $topLevelFields = array();
    foreach ($topLevelMaps as $map) {
      $field = $map->getChild();
      $topLevelFields[$field->field_id] = $field;
    }
    $topLevelField = array_shift($topLevelFields);
    $topLevelOptions = array();
    foreach ($optionsData->getRowsMatching('field_id', $topLevelField->field_id) as $option) {
      $topLevelOptions[$option->option_id] = $option->label;
    }
    $this->view->topLevelOptions = $topLevelOptions;

    //END PROFILE TYPE WORK
  }
}
