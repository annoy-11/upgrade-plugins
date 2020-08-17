<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DashboardController.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_DashboardController extends Core_Controller_Action_Standard {

  public function init() {
    if (!$this->_helper->requireAuth()->setAuthParams('stores', null, 'view')->isValid())
      return;

    if (!$this->_helper->requireUser->isValid())
      return;
    $id = $this->_getParam('store_id', null);
    if (!isset($_POST['locationphoto_id'])) {
      $viewer = $this->view->viewer();
      $store_id = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreId($id);
      if ($store_id) {
        $store = Engine_Api::_()->getItem('stores', $store_id);
        if ($store && (($store->is_approved || $viewer->level_id == 1 || $viewer->level_id == 2 || $viewer->getIdentity() == $store->owner_id) ))
          Engine_Api::_()->core()->setSubject($store);
        else
          return $this->_forward('requireauth', 'error', 'core');
      } else
        return $this->_forward('requireauth', 'error', 'core');
      if (!Engine_Api::_()->estore()->storeRolePermission($store, Zend_Controller_Front::getInstance()->getRequest()->getActionName())) {
        return;
      }
      $levelId = Engine_Api::_()->getItem('user', $store->owner_id)->level_id;
    }
  }

    public function editAction() {

        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $settings = Engine_Api::_()->getApi('settings', 'core');

        $previousTitle = $store->getTitle();

        //Store Category and profile fileds
        $this->view->defaultProfileId = $defaultProfileId = 1;
        if (isset($store->category_id) && $store->category_id != 0)
            $this->view->category_id = $store->category_id;
        else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
            $this->view->category_id = $_POST['category_id'];
        else
            $this->view->category_id = 0;
        if (isset($store->subsubcat_id) && $store->subsubcat_id != 0)
            $this->view->subsubcat_id = $store->subsubcat_id;
        else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
            $this->view->subsubcat_id = $_POST['subsubcat_id'];
        else
            $this->view->subsubcat_id = 0;
        if (isset($store->subcat_id) && $store->subcat_id != 0)
            $this->view->subcat_id = $store->subcat_id;
        else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
            $this->view->subcat_id = $_POST['subcat_id'];
        else
            $this->view->subcat_id = 0;
        //Store category and profile fields
        $viewer = Engine_Api::_()->user()->getViewer();
        // Create form
        $this->view->form = $form = new Estore_Form_Edit(array('defaultProfileId' => $defaultProfileId));
        $this->view->category_id = $store->category_id;
        $this->view->subcat_id = $store->subcat_id;
        $this->view->subsubcat_id = $store->subsubcat_id;
        $tagStr = '';
        foreach ($store->tags()->getTagMaps() as $tagMap) {
            $tag = $tagMap->getTag();
            if (!isset($tag->text))
                continue;
            if ('' !== $tagStr)
                $tagStr .= ', ';
            $tagStr .= $tag->text;
        }
        $oldUrl = $store->custom_url;
        $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
        if (!$this->getRequest()->isPost()) {
            // Populate auth
            $auth = Engine_Api::_()->authorization()->context;
            foreach ($roles as $role) {
                if (isset($form->auth_view->options[$role]) && $auth->isAllowed($store, $role, 'view'))
                    $form->auth_view->setValue($role);
                if (isset($form->auth_comment->options[$role]) && $auth->isAllowed($store, $role, 'comment'))
                    $form->auth_comment->setValue($role);

                if (isset($form->auth_album->options[$role]) && $auth->isAllowed($store, $role, 'album'))
                    $form->auth_album->setValue($role);

                if (isset($form->auth_video->options[$role]) && $auth->isAllowed($store, $role, 'video'))
                    $form->auth_video->setValue($role);
            }
            $form->populate($store->toArray());
            $form->populate(array(
                'tags' => $tagStr,
                'networks' => explode(',', ltrim($store['networks'], ',')),
            ));
            if ($form->draft->getValue() == 1)
                $form->removeElement('draft');
            return;
        }
        if (!$form->isValid($this->getRequest()->getPost()))
            return;
        //check custom url
        if (isset($_POST['custom_url']) && !empty($_POST['custom_url'])) {
            $custom_url = Engine_Api::_()->sesbasic()->checkBannedWord($_POST['custom_url'],$store->custom_url);
            if ($custom_url) {
                $form->addError($this->view->translate("Custom URL not available. Please select other."));
                return;
            }
        }
        $values = $form->getValues();

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
            $values['approval'] = $settings->getSetting('estore.default.joinoption', 1) ? 0 : 1;
        elseif (!isset($values['approval']))
            $values['approval'] = $settings->getSetting('estore.default.approvaloption', 1) ? 0 : 1;
        // Process
        $db = Engine_Api::_()->getItemTable('stores')->getAdapter();
        $db->beginTransaction();
        try {
            if (!($values['draft']))
                unset($values['draft']);
            $store->setFromArray($values);
            $store->save();
            $tags = preg_split('/[,]+/', $values['tags']);
            $store->tags()->setTagMaps($viewer, $tags);
            if (!$values['vote_type'])
                $values['resulttime'] = '';

            if (!empty($_POST['custom_url']) && $_POST['custom_url'] != '')
                $store->custom_url = $_POST['custom_url'];

            $store->save();

            $newstoreTitle = $store->getTitle();

            // Add photo
            if (!empty($values['photo'])) {
                $store->setPhoto($form->photo);
            }
            // Add cover photo
            if (!empty($values['cover'])) {
                $store->setCover($form->cover);
            }
            // Set auth
            $auth = Engine_Api::_()->authorization()->context;
            $roles = array('owner', 'member', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');
            if (empty($values['auth_view']))
                $values['auth_view'] = 'everyone';
            $store->view_privacy = $values['auth_view'];
            if (empty($values['auth_comment']))
                $values['auth_comment'] = 'everyone';
            $viewMax = array_search($values['auth_view'], $roles);
            $commentMax = array_search($values['auth_comment'], $roles);

            $albumMax = array_search(@$values['auth_album'], $roles);
            $videoMax = array_search(@$values['auth_video'], $roles);

            foreach ($roles as $i => $role) {
                $auth->setAllowed($store, $role, 'view', ($i <= $viewMax));
                $auth->setAllowed($store, $role, 'comment', ($i <= $commentMax));

                $auth->setAllowed($store, $role, 'album', ($i <= $albumMax));
                $auth->setAllowed($store, $role, 'video', ($i <= $videoMax));
            }
            $store->save();

            if(isset($_POST['custom_url']) && $_POST['custom_url'] != $oldUrl) {
                Zend_Db_Table_Abstract::getDefaultAdapter()->update('engine4_sesbasic_bannedwords', array("word" => $_POST['custom_url']),array("word = ?" => $oldUrl,"resource_type = ?" => store,"resource_id = ?" => $store->store_id));
            }

            $db->commit();
            //Start Activity Feed Work
            if (isset($values['draft']) && $store->draft == 1 && $store->is_approved == 1) {
                $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
                //$action = $activityApi->addActivity($viewer, $store, 'estore_create');
                // if ($action) {
                // $activityApi->attachActivity($action, $store);
                //}
                $getCategoryFollowers = Engine_Api::_()->getDbTable('followers','estore')->getCategoryFollowers($store->category_id);
                if(count($getCategoryFollowers) > 0) {
                    foreach ($getCategoryFollowers as $getCategoryFollower) {
                        if($getCategoryFollower['owner_id'] == $viewer->getIdentity())
                            continue;
                        $categoryTitle = Engine_Api::_()->getDbTable('categories','estore')->getColumnName(array('category_id' => $store->category_id, 'column_name' => 'category_name'));
                        $user = Engine_Api::_()->getItem('user', $getCategoryFollower['owner_id']);
                        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $viewer, $store, 'estore_follow_category',array('category_title' => $categoryTitle));
                        Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_estore_follow_category', array('sender_title' => $store->getOwner()->getTitle(), 'object_title' => $categoryTitle, 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
                    }
                }
            }
            //End Activity Feed Work

            if ($previousTitle != $newstoreTitle) {
                //Send to all joined members
                $joinedMembers = Engine_Api::_()->estore()->getallJoinedMembers($store);
                foreach ($joinedMembers as $joinedMember) {
                    if ($joinedMember->user_id == $store->owner_id)
                        continue;
                    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $store, 'estore_storejoinednamechange', array('old_store_title' => $previousTitle, 'new_store_link' => $newstoreTitle));
                }

                //Send to all followed members
                $followerMembers = Engine_Api::_()->getDbTable('followers', 'estore')->getFollowers($store->getIdentity());
                foreach ($followerMembers as $followerMember) {
                    if ($followerMember->owner_id == $store->owner_id)
                        continue;
                    $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
                    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $store, 'estore_storefollowednamechange', array('old_store_title' => $previousTitle, 'new_store_link' => $newstoreTitle));

                    Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_estore_store_storenamechanged', array('store_title' => $store->getTitle(), 'sender_title' => $viewer->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
                }

                //Send to all favourites members
                $followerMembers = Engine_Api::_()->getDbTable('favourites', 'estore')->getAllFavMembers($store->getIdentity());
                foreach ($followerMembers as $followerMember) {
                    if ($followerMember->owner_id == $store->owner_id)
                        continue;
                    $followerMember = Engine_Api::_()->getItem('user', $followerMember->owner_id);
                    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($joinedMember, Engine_Api::_()->user()->getViewer(), $store, 'estore_storefavouritednamechange', array('old_store_title' => $previousTitle, 'new_store_link' => $newstoreTitle));
                }
            }
        } catch (Engine_Image_Exception $e) {
            $db->rollBack();
            $form->addError(Zend_Registry::get('Zend_Translate')->_('The image you selected was too large.'));
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
        $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'edit', 'store_id' => $store->custom_url));
    }

    public function profileFieldAction() {
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        //Store Category and profile fileds
        $this->view->defaultProfileId = $defaultProfileId = 1;
        if (isset($store->category_id) && $store->category_id != 0)
            $this->view->category_id = $store->category_id;
        else if (isset($_POST['category_id']) && $_POST['category_id'] != 0)
            $this->view->category_id = $_POST['category_id'];
        else
            $this->view->category_id = 0;
        if (isset($store->subsubcat_id) && $store->subsubcat_id != 0)
            $this->view->subsubcat_id = $store->subsubcat_id;
        else if (isset($_POST['subsubcat_id']) && $_POST['subsubcat_id'] != 0)
            $this->view->subsubcat_id = $_POST['subsubcat_id'];
        else
            $this->view->subsubcat_id = 0;
        if (isset($store->subcat_id) && $store->subcat_id != 0)
            $this->view->subcat_id = $store->subcat_id;
        else if (isset($_POST['subcat_id']) && $_POST['subcat_id'] != 0)
            $this->view->subcat_id = $_POST['subcat_id'];
        else
            $this->view->subcat_id = 0;

        //Store category and profile fields
        $viewer = Engine_Api::_()->user()->getViewer();
        // Create form
        $this->view->form = $form = new Estore_Form_Dashboard_Profilefield(array('defaultProfileId' => $defaultProfileId));
        $this->view->category_id = $store->category_id;
        $this->view->subcat_id = $store->subcat_id;
        $this->view->subsubcat_id = $store->subsubcat_id;
        $form->populate($store->toArray());

        if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
            return;
        // Process
        $db = Engine_Api::_()->getItemTable('stores')->getAdapter();
        $db->beginTransaction();
        try {
            //Add fields
            $customfieldform = $form->getSubForm('fields');
            if ($customfieldform) {
                $customfieldform->setItem($store);
                $customfieldform->saveValues();
            }
            $store->save();
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
        $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'profile-field', 'store_id' => $store->custom_url));
    }
    function createShippingAction(){
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = $this->view->viewer();

        $this->view->form = $form = new Estore_Form_Dashboard_Shippingmethods();

        $id = $this->_getParam('id',0);
        if($id){
            $this->view->shipping = $shipping = Engine_Api::_()->getItem('estore_shippingmethod',$id);
            $form->populate($shipping->toArray());
            $form->country->setAttrib('disabled','disabled');
            $form->removeElement('location_type');
            $form->removeElement('state_id');
            if($shipping->state_id){
                $state = Engine_Api::_()->getItem('estore_state',$shipping->state_id);
                if($state) {
                    $stateTitle = $state->name;
                    $form->state->addMultiOptions(array(0 => $stateTitle));
                }
            }else{
                $form->removeElement('state');
            }

            if($shipping->price_type == 0){
                $form->fixed_price->setValue($shipping->price);
            }else{
                $form->percentage_price->setValue($shipping->price);
            }

        }else{
            $form->removeElement('state');
        }

        if (!empty($_POST['submit_form']) && $this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $values = $form->getValues();
            $country_id = $values['country'];
            $type = $values['location_type'];
            if(!empty($country_id) && $type == 0 && empty($values['state_id'])){
                $form->addError("Add States to enable Shipping Method.");
                return;
            }
            $error = false;
            $methodType = $values['types'];
            $costMin = isset($_POST['cost_min']) ? $_POST['cost_min'] : '';
            $costMax = isset($_POST['cost_max']) ? $_POST['cost_max'] : '';
            $weightMin = isset($_POST['weight_min']) ? $_POST['weight_min'] : '';
            $weightMax = isset($_POST['weight_max']) ? $_POST['weight_max'] : '';
            $productMin = isset($_POST['product_min']) ? $_POST['product_min'] : '';
            $productMax = isset($_POST['product_max']) ? $_POST['product_max'] : '';

            if($weightMin == ""){
                $form->addError('Enter Weight Matrix value - it is required.');
                $error = true;
            }else{
                if(!Engine_Api::_()->estore()->isValidFloatAndIntegerValue($weightMin)){
                    $form->addError('Enter valid Weight Matrix value.');
                    $error = true;
                }
            }
            if($weightMax){
                if(!Engine_Api::_()->estore()->isValidFloatAndIntegerValue($weightMax)){
                    $form->addError('Enter valid Weight Matrix value.');
                    $error = true;
                }
            }
            if($_POST['price_type'] == 0 || $_POST['price_type'] == 2){
                if($_POST['fixed_price'] < ($store->minimum_shipping_cost) && Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.minimum.shippingcost')){
                    $form->addError('Entered Shipping Cost is less than the minimum shipping cost. Please enter shipping cost greator than store\'s minimum shipping cost');
                    $error = true;
                }
            }
            if($methodType == 0){
                //cost and weight
                if($costMin == ""){
                    $form->addError('Enter Cost Range value - it is required.');
                    $error = true;
                }else{
                    if(!Engine_Api::_()->estore()->isValidFloatAndIntegerValue($costMin)){
                        $form->addError('Enter valid Cost Range value.'.$costMin);
                        $error = true;
                    }
                }
                if($costMax){
                    if(!Engine_Api::_()->estore()->isValidFloatAndIntegerValue($costMax)){
                        $form->addError('Enter valid Cost Range value.');
                        $error = true;
                    }
                }
            }else if($methodType == 1){
                //weight only

            }else{
                //product quantity and weight
                if($productMin == ""){
                    $form->addError('Enter Product Quatitiy value - it is required.');
                    $error = true;
                }else{
                    if(!Engine_Api::_()->estore()->checkIntegerValue($productMin)){
                        $form->addError('Enter valid Product Quatitiy value.');
                        $error = true;
                    }
                }
                if($productMax){
                    if(!Engine_Api::_()->estore()->checkIntegerValue($productMax)){
                        $form->addError('Enter valid Product Quatitiy value.');
                        $error = true;
                    }
                }
            }
            if($error){
                return;
            }

            $error = false;

            if($weightMax && $weightMax < $weightMin){
                $form->addError('Weight min value must be less than Weight max value.');
                $error = true;
            }

            if($methodType == 2 && $productMin && $productMax < $productMin){
                $form->addError('Product Quatity min value must be less than Product Quatity max value.');
                $error = true;
            }

            if($methodType == 1 && $costMax && $costMax < $costMin){
                $form->addError('Cost min value must be less than Cost max value.');
                $error = true;
            }



            if($error){
                return;
            }

            //save values
            $table = Engine_Api::_()->getDbTable('shippingmethods','estore');
            $shippingMethod = $table->createRow();

            $values['title'] = $_POST['title'];
            $values['delivery_time'] = $_POST['delivery_time'];

            $values['country'] = $_POST['country'];
            if(empty($shipping)) {
                if (!$values['country']) {
                    $states = array(0);
                } else {
                    if ($_POST['location_type'] == 1)
                        $states = array(0);
                    else
                        $states = $_POST['state_id'];
                }
            }else{
                $states = array(0);
            }
            $values['country_id'] = $_POST['country'];
            $values['types'] = $_POST['types'];
            $values['weight_min'] = $_POST['weight_min'];
            $values['weight_max'] = $_POST['weight_max'];
            $values['store_id'] = $store->getIdentity();
            if($methodType == 0){
                //cost and weight
                $values['cost_min'] = $_POST['cost_min'];
                $values['cost_max'] = $_POST['cost_max'];
            }else if($methodType == 2){
                //weight & product
                $values['product_min'] = $_POST['product_min'];
                $values['product_max'] = $_POST['product_max'];
                $values['deduction_type'] = $_POST['deduction_type'];
            }
            if($_POST['price_type'] == 0 || $_POST['price_type'] == 2){
                $values['price'] = $_POST['fixed_price'];
            }else{
                $values['price'] = $_POST['percentage_price'];
            }
            $values['price_type'] = $_POST['price_type'];
            foreach ($states as $state){
                if(empty($shipping)) {
                    $values['state_id'] = $state;
                    $row = $table->createRow();
                }else
                    $row = $shipping;

                $row->setFromArray($values);
                $row->save();
            }
            echo "1";die;
        }
     }
    function enableShippingAction(){
        $id = $this->_getParam('id');
        $shipping = Engine_Api::_()->getItem('estore_shippingmethod',$id);
        $shipping->status = !$shipping->status;
        $shipping->save();

        if(Engine_Api::_()->getItem('estore_shippingmethod',$id)->status){
            echo 1;die;
        }else{
            echo 0;die;
        }
    }
    public function deleteShippingAction(){
        $id = $this->_getParam('id');
        $shipping = Engine_Api::_()->getItem('estore_shippingmethod',$id);

        if (!$this->getRequest()->isPost()) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $db = $shipping->getTable()->getAdapter();
        $db->beginTransaction();

        try {
            $shipping->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
        echo 1;die;
    }
    function minimumShippingCostAction(){
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = $this->view->viewer();
        $this->_helper->layout->setLayout('default-simple');
        $this->view->form = $form = new Estore_Form_Dashboard_Minimumshippingcost();
        $form->minimum_shipping_cost->setValue($store->minimum_shipping_cost);
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $store->minimum_shipping_cost = $_POST['minimum_shipping_cost'];
            $store->save();
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('Minimum Shipping Cost updated successfully.'))
            ));
        }
    }
    function shippingsAction(){
        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                    Engine_Api::_()->getDbtable('shippingmethods', 'estore')->delete(array('shippingmethod_id = ?' => $value));
                }
            }
        }
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = $this->view->viewer();
        $params["store_id"] = $store->getIdentity();
        $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('shippingmethods','estore')->getShippingmethods($params);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    }
    public function manageProductsAction(){
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
       parse_str($_POST['searchParams'], $searchArray);
       if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $valueProduct) {
                if ($key == 'delete_' . $valueProduct) {
                    $product = Engine_Api::_()->getItem('sesproduct', $valueProduct);
                    if(count($product))
                        $product->delete();
                }
            }
        }

        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $value['title'] = isset($searchArray['title']) ? $searchArray['title'] : '';
        $value['owner_name'] = isset($searchArray['owner_name']) ? $searchArray['owner_name'] : '';
        $value['date_from'] = isset($searchArray['date']['date_from']) ? $searchArray['date']['date_from'] : '';
        $value['date_to'] = isset($searchArray['date']['date_to']) ? $searchArray['date']['date_to'] : '';
        $value['category_id'] = isset($searchArray['category_id']) ? $searchArray['category_id'] : '';
        $value['store_id'] = $store->getIdentity();

        $this->view->formFilter = $formFilter = new Estore_Form_Dashboard_ManageProduct();
        if($value)
        $formFilter->populate($value);
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $user_id = $this->view->user_id = $this->_getParam('user_id', null);

        $store_id = $store->getIdentity();

        $this->view->shippingMethods = $shippingMethdodTable = Engine_Api::_()->getDbtable('shippingmethods', 'estore')->getShippingmethods(array('store_id' => $store_id));
        $viewer = $this->view->viewer();
        // Create form

        $this->view->products = $paginator = Engine_Api::_()->getDbTable('sesproducts', 'sesproduct')->getSesproductsPaginator($value);
        $paginator->setItemCountPerPage(100);
        $paginator->setCurrentPageNumber($this->_getparam('page',1));
  }

    public function deleteAction()
    {
        // In smoothbox
        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('id');
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
        //$this->renderScript('admin-manage/delete.tpl');
    }

  public function manageOrdersAction(){

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $viewer = $this->view->viewer();
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $is_search_ajax = $this->view->is_search_ajax = $this->_getParam('is_search_ajax', null) ? $this->_getParam('is_search_ajax') : false;

    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);



    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
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
    $value['store_id'] = $store->getIdentity();

    $this->view->orders = $orders = Engine_Api::_()->getDbtable('orders', 'sesproduct')->manageOrders($value);
    $this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
    $this->view->page = $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($orders);
    $paginator->setCurrentPageNumber($page);
    $paginator->setItemCountPerPage(10);
  }

public function paymentRequestsAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $store->isOwner($viewer)))
      return;
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->userGateway = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array('store_id' => $store->getIdentity()));
    $this->view->orderDetails = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getProductStats(array('store_id' => $store->getIdentity()));

        $this->view->thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'estore_threshold');


    //get ramaining amount
    $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'estore')->getStoreRemainingAmount(array('store_id' => $store->store_id));
    if (!$remainingAmount) {
      $this->view->remainingAmount = 0;
    } else
    $this->view->remainingAmount = $remainingAmount->remaining_payment;
    $this->view->isAlreadyRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct')->getPaymentRequests(array('store_id' => $store->store_id,'isPending'=>true));
    $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct')->getPaymentRequests(array('store_id' => $store->store_id,'isPending'=>true));

  }
    //get paymnet detail
    public function detailPaymentAction() {
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $this->view->item = $paymnetReq = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->getRequest()->getParam('id'));
        $this->view->viewer = Engine_Api::_()->user()->getViewer();
        if (!$this->_helper->requireAuth()->setAuthParams($store, null, 'edit')->isValid())
            return;

        if (!$paymnetReq) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Paymnet request doesn't exists or not authorized to delete");
            return;
        }
    }
    public function paymentTransactionAction() {

        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

        $this->view->store = $store = Engine_Api::_()->core()->getSubject();

        $viewer = Engine_Api::_()->user()->getViewer();

        if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $store->isOwner($viewer)))
            return;

        $this->view->paymentRequests = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct')->getPaymentRequests(array('store_id' => $store->store_id, 'state' => 'complete'));
    }

    public function paymentRequestAction() {
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $store->isOwner($viewer)))
            return;
        $viewer = Engine_Api::_()->user()->getViewer();
        $this->view->thresholdAmount = $thresholdAmount = Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'estore_threshold');
        //get remaining amount
        $remainingAmount = Engine_Api::_()->getDbtable('remainingpayments', 'estore')->getStoreRemainingAmount(array('store_id' => $store->store_id));
        if (!$remainingAmount) {
            $this->view->remainingAmount = 0;
        } else {
            $this->view->remainingAmount = $remainingAmount->remaining_payment;
        }
        $defaultCurrency = Engine_Api::_()->estore()->defaultCurrency();
        $orderDetails = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getProductStats(array('store_id' => $store->store_id));
        $this->view->form = $form = new Estore_Form_Dashboard_Paymentrequest();
        $value = array();

        $value['total_tax_amount'] = Engine_Api::_()->estore()->getCurrencyPrice($orderDetails['total_billingtax_cost'], $defaultCurrency);
        $value['total_shipping_amount'] = Engine_Api::_()->estore()->getCurrencyPrice($orderDetails['total_shippingtax_cost'], $defaultCurrency);
        $value['total_admin_amount'] = Engine_Api::_()->estore()->getCurrencyPrice($orderDetails['total_admintax_cost'], $defaultCurrency);
        $value['total_amount'] = Engine_Api::_()->estore()->getCurrencyPrice($orderDetails['total_amount'], $defaultCurrency);
        $value['total_commission_amount'] = Engine_Api::_()->estore()->getCurrencyPrice($orderDetails['commission_amount'], $defaultCurrency);

        $value['remaining_amount'] = Engine_Api::_()->estore()->getCurrencyPrice($remainingAmount->remaining_payment, $defaultCurrency);
        $value['requested_amount'] = round($remainingAmount->remaining_payment,2);
        //set value to form
        if ($this->_getParam('id', false)) {
            $item = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->_getParam('id'));
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

        $db = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct')->getAdapter();
        $db->beginTransaction();
        try {
            $tableOrder = Engine_Api::_()->getDbtable('userpayrequests', 'sesproduct');
            if (isset($itemValue))
                $order = $item;
            else
                $order = $tableOrder->createRow();
            $order->requested_amount = round($_POST['requested_amount'],2);
            $order->user_message = $_POST['user_message'];
            $order->store_id = $store->store_id;
            $order->owner_id = $viewer->getIdentity();
            $order->user_message = $_POST['user_message'];
            $order->creation_date = date('Y-m-d h:i:s');
            $order->currency_symbol = $defaultCurrency;
            $settings = Engine_Api::_()->getApi('settings', 'core');
            $userGatewayEnable = $settings->getSetting('store.userGateway', 'paypal');
            $order->save();
            $db->commit();

            //Notification work
            $owner_admin = Engine_Api::_()->getItem('user', 1);
            Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($owner_admin, $viewer, $store, 'estore_event_paymentrequest', array('requestAmount' => round($_POST['requested_amount'],2)));

            //Payment request mail send to admin
            $storeowner = Engine_Api::_()->getItem('user', $store->owner_id);
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($owner_admin, 'estore_ticketpayment_requestadmin', array('store_title' => $store->title, 'object_link' => $store->getHref(), 'event_owner' => $storeowner->getTitle(), 'host' => $_SERVER['HTTP_HOST']));

            $this->view->status = true;
            $this->view->message = Zend_Registry::get('Zend_Translate')->_('Payment request send successfully.');
            $getAdminnSuperAdmins = Engine_Api::_()->sesproduct()->getAdminnSuperAdmins();
            foreach ($getAdminnSuperAdmins as $getAdminnSuperAdmin) {
                $user = Engine_Api::_()->getItem('user', $getAdminnSuperAdmin['user_id']);
                Engine_Api::_()->getDbtable('notifications', 'activity')->addNotification($user, $viewer, $store, 'estore_payment_request');

                Engine_Api::_()->getApi('mail', 'core')->sendSystem($user->email, 'estore_payment_request', array('host' => $_SERVER['HTTP_HOST'],'store_name' => $store->getTitle(),'object_link'=>$store->getHref()));
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

    //delete payment request
    public function deletePaymentAction() {

        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $paymnetReq = Engine_Api::_()->getItem('sesproduct_userpayrequest', $this->getRequest()->getParam('id'));

        $viewer = Engine_Api::_()->user()->getViewer();
        if (!$this->_helper->requireAuth()->setAuthParams($store, null, 'delete')->isValid())
            return;

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
    public function accountDetailsAction() {
     $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $gateway_type = $this->view->gateway_type = $this->_getParam('gateway_type', "paypal");
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $store->isOwner($viewer)))
      return;
    $userGateway = Engine_Api::_()->getDbtable('usergateways', 'sesproduct')->getUserGateway(array('store_id' => $store->store_id,'gateway_type'=>$gateway_type,'user_id'=>$viewer->getIdentity()));
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $userGatewayEnable = $settings->getSetting('sesproduct.userGateway', 'paypal');
    $this->view->form = $form = new Sesproduct_Form_PayPal();
    if($gateway_type == "paypal") {
        $userGatewayEnable = 'paypal';
        $this->view->form = $form = new Sesbasic_Form_PayPal();
        $gatewayTitle = 'Paypal';
        $gatewayClass= 'Sesproduct_Plugin_Gateway_PayPal';
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
    $userGatewayTable = Engine_Api::_()->getDbtable('usergateways', 'sesproduct');
    // insert data to table if not exists
    try {
      if (!count($userGateway)) {
        $gatewayObject = $userGatewayTable->createRow();
        $gatewayObject->store_id = $store->store_id;
        $gatewayObject->user_id = $viewer->getIdentity();
        $gatewayObject->title = $gatewayTitle;
        $gatewayObject->plugin = $gatewayClass;
        $gatewayObject->gateway_type = $gateway_type;
        $gatewayObject->save();
      } else {
        $gatewayObject = Engine_Api::_()->getItem("sesproduct_usergateway", $userGateway['usergateway_id']);
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
    function editTaxAction(){
        if (!$this->_helper->requireUser()->isValid())
            return;

        $this->_helper->layout->setLayout('default-simple');
        $id = $this->_getParam('tax_id');
        $tax = Engine_Api::_()->getItem('estore_taxes',$id);
        $this->view->form = $form = new Estore_Form_Admin_Taxes_Addtaxes();
        $form->populate($tax->toArray());
        $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
        $form->setTitle('Edit Tax');
        $form->submit->setLabel('Edit Tax');
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

            $values = $form->getValues();

            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();

            try {
                $table = Engine_Api::_()->getDbTable('taxes','estore');
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


    public function salesStatsAction() {
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $store->isOwner($viewer)))
            return;

        $this->view->todaySale = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getSaleStats(array('stats' => 'today', 'store_id' => $store->store_id));

        $this->view->weekSale = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getSaleStats(array('stats' => 'week', 'store_id' => $store->store_id));
        $this->view->monthSale = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getSaleStats(array('stats' => 'month', 'store_id' => $store->store_id));

        //get getStoreStats
        $this->view->storeStatsSale = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getProductStats(array('store_id' => $store->store_id));
    }
    //get sales report
    public function salesReportsAction() {
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = Engine_Api::_()->user()->getViewer();
        if (!($this->_helper->requireAuth()->setAuthParams(null, null, 'edit')->isValid() || $store->isOwner($viewer)))
            return;

        $this->view->form = $form = new Estore_Form_Dashboard_Searchsalereport();
        $value = array();
        if (isset($_GET['product_id']))
            $value['product_id'] = $_GET['product_id'];
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
        $value['store_id'] = $store->getIdentity();

        $this->view->storeSaleData = $data = Engine_Api::_()->getDbtable('orders', 'sesproduct')->getStoreReportData($value);

        if(isset($value['download'])){
            $name = str_replace(' ','_',$store->getTitle()).'_'.time();
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
                $valueVal['Shipping Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['total_shippingtax_cost'],$defaultCurrency);
                $valueVal['Total Tax Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['total_billingtax_cost'],$defaultCurrency);
                $valueVal['Commission Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['commission_amount'],$defaultCurrency);
                $valueVal['Total Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['total_amount'],$defaultCurrency);
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
        $defaultCurrency = Engine_Api::_()->sesevent()->defaultCurrency();
        if(!empty($records))
            foreach($records as $row) {
                $valueVal['S.No'] = $counter;
                $valueVal['Date of Purchase'] = ($row['creation_date']);
                $valueVal['Quatity'] = $row['total_orders'];
                $valueVal['Shipping Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['total_shippingtax_cost'],$defaultCurrency);
                $valueVal['Total Tax Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['total_billingtax_cost'],$defaultCurrency);
                $valueVal['Commission Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['commission_amount'],$defaultCurrency);
                $valueVal['Total Amount'] = Engine_Api::_()->estore()->getCurrencyPrice($row['total_amount'],$defaultCurrency);
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


    public function deleteTaxAction(){
        $id = $this->_getParam('tax_id');
        $tax = Engine_Api::_()->getItem('estore_taxes',$id);

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
  public function createTaxAction(){
      if (!$this->_helper->requireUser()->isValid())
          return;
      $this->_helper->layout->setLayout('default-simple');
      $this->view->form = $form = new Estore_Form_Admin_Taxes_Addtaxes();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));
      $this->view->store = $store = Engine_Api::_()->core()->getSubject();
      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

          $values = $form->getValues();

          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();

          try {
              $table = Engine_Api::_()->getDbTable('taxes','estore');
              $row = $table->createRow();
              $values = $form->getValues();
              $values['is_admin'] = 0;
              $values['store_id'] = $store->getIdentity();
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
  function enableTaxAction(){
      $id = $this->_getParam('tax_id');
      $tax = Engine_Api::_()->getItem('estore_taxes',$id);
      $tax->status = !$tax->status;
      $tax->save();

      if(Engine_Api::_()->getItem('estore_taxes',$id)->status){
          echo 1;die;
      }else{
          echo 0;die;
      }
  }

    public function generalTaxesAction()
    {
        $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
        $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
        $this->view->store = $store = Engine_Api::_()->core()->getSubject();
        $viewer = $this->view->viewer();
        //fetch Store taxes
        $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
        $params['is_admin'] = 1;
        $this->view->taxes = $paginator = Engine_Api::_()->getDbTable('taxes', 'estore')->getTaxes($params);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
    }


  public function taxesAction(){
      if ($this->getRequest()->isPost()) {
          $values = $this->getRequest()->getPost();
          foreach ($values as $key => $value) {
              if ($key == 'delete_' . $value) {
                  Engine_Api::_()->getDbtable('taxes', 'estore')->delete(array('tax_id = ?' => $value));
              }
          }
      }
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->store = $store = Engine_Api::_()->core()->getSubject();
      $viewer = $this->view->viewer();
      //fetch Store taxes
      $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
      $params['is_admin'] = 0;
      $params['store_id'] = $store->getIdentity();
      $this->view->taxes = $paginator = Engine_Api::_()->getDbTable('taxes','estore')->getTaxes($params);
      $paginator->setItemCountPerPage(10);
      $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }
    function enableLocationTaxAction(){
        $id = $this->_getParam('tax_id');
        $tax = Engine_Api::_()->getItem('estore_taxstate',$id);
        $tax->status = !$tax->status;
        $tax->save();

        if(Engine_Api::_()->getItem('estore_taxstate',$id)->status){
            echo 1;die;
        }else{
            echo 0;die;
        }
    }
    public function deleteLocationTaxAction(){
        $id = $this->_getParam('tax_id');
        $tax = Engine_Api::_()->getItem('estore_taxstate',$id);
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

  function manageLocationsAction(){
      if ($this->getRequest()->isPost()) {
          $values = $this->getRequest()->getPost();
          foreach ($values as $key => $value) {
              if ($key == 'delete_' . $value) {
                  Engine_Api::_()->getDbtable('taxstates', 'estore')->delete(array('taxstate_id = ?' => $value));
              }
          }
      }

      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->store = $store = Engine_Api::_()->core()->getSubject();
      $viewer = $this->view->viewer();
      //fetch Store taxes
      $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
      $this->view->tax_id = $tax_id = $this->_getParam('tax_id');
      $params = array();
      $this->view->is_admin = $is_admin = $this->_getParam('is_admin');

      $tax = Engine_Api::_()->getItem('estore_taxes',$tax_id);
      if(!$is_admin){
          if($tax->is_admin){
              $this->view->isreturn = true;
              return;
          }
      }else{
          if(!$tax->is_admin){
              $this->view->isreturn = true;
              return;
          }
      }

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
      $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('taxstates','estore')->getStates($params);

      $paginator->setItemCountPerPage(10);
      $paginator->setCurrentPageNumber ($this->_getParam('page', 1));

  }
    function statesAction(){
        $country_id = $this->_getParam('country_id');
        $stateTable = Engine_Api::_()->getDbTable('states','estore');
        $select = $stateTable->select()->where('status =?',1)->where('country_id =?',$country_id);
        $states = $stateTable->fetchAll($select);
        $statesString = '';

        foreach($states as $state){
            $statesString .= '<option value="'.$state->getIdentity().'">'.$state->name.'</option>';
        }
        echo $statesString;die;
    }
  function createLocationAction(){
      $id = $this->_getParam('id',0);
      if (!$this->_helper->requireUser()->isValid())
          return;
      $this->view->store = $store = Engine_Api::_()->core()->getSubject();

      $this->_helper->layout->setLayout('default-simple');

      $this->view->form = $form = new Estore_Form_Admin_Taxes_AddLocation();
      $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

      //get all countries
      $countries = Engine_Api::_()->getDbTable('countries','estore')->fetchAll(Engine_Api::_()->getDbTable('countries','estore')->select()->where('status =?',1));

      $countriesArray = array('0'=>'All Countries');
      foreach($countries as $country){
          $countriesArray[$country->getIdentity()] = $country['name'];
      }
      $form->country_id->setMultiOptions($countriesArray);
      if($id){
          $form->removeElement('country_id');
          $form->removeElement('state_id');
          $form->removeElement('location_type');
          $row = Engine_Api::_()->getItem('estore_taxstate',$id);
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
          if(!Engine_Api::_()->estore()->isValidPriceValue($price)){
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

          //$db = Engine_Db_Table::getDefaultAdapter();
          //$db->beginTransaction();
          try {
              $table = Engine_Api::_()->getDbTable('taxstates','estore');
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

  public function managestoreonoffappsAction() {
    $storeType = $this->_getParam('type', 'photos');
    $storeId = $this->_getParam('store_id', null);
    if (empty($storeId))
      return;
    $isCheck = Engine_Api::_()->getDbTable('managestoreapps', 'estore')->isCheck(array('store_id' => $storeId, 'columnname' => $storeType));
    $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
    if ($isCheck) {
      $dbGetInsert->update('engine4_estore_managestoreapps', array($storeType => 0), array('store_id =?' => $storeId));
    } else {
      $dbGetInsert->update('engine4_estore_managestoreapps', array($storeType => 1), array('store_id =?' => $storeId));
    }
    echo true;
    die;
  }

  public function changeOwnerAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('stores', $this->view->viewer(), 'auth_changeowner'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    if (!$this->getRequest()->isPost())
      return;
    Engine_Api::_()->estore()->updateNewOwnerId(array('newuser_id' => $_POST['user_id'], 'olduser_id' => $this->view->viewer()->getIdentity(), 'store_id' => $store->store_id));
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'), 'estore_general', true);
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

  public function manageStoreappsAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->store = $store = Engine_Api::_()->core()->getSubject();

    $getManagestoreId = Engine_Api::_()->getDbTable('managestoreapps', 'estore')->getManagestoreId(array('store_id' => $store->store_id));

    $this->view->managestoreapps = Engine_Api::_()->getItem('estore_managestoreapp', $getManagestoreId);

    $viewer = Engine_Api::_()->user()->getViewer();
  }

  public function manageServiceAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->store = $store = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableService = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'store_service');
    if (empty($enableService)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    $estore_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.service', 1);
    if(empty($estore_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('services', 'estore')->getServiceMemers(array('store_id' => $store->store_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function addserviceAction() {

    $estore_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.service', 1);
    if(empty($estore_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->store_id = $store_id = $this->_getParam('store_id', null);
    $this->view->type = $type = $this->_getParam('type', 'sitemember');
    $store = Engine_Api::_()->getItem('stores', $store_id);

    if (!$is_ajax) {
      //Render Form
      $this->view->form = $form = new Estore_Form_Service_Add();
      $form->setTitle('Add New Service');
      $form->setDescription("Here, you can enter your service details.");
    }

    if ($is_ajax) {
      // Process
      $table = Engine_Api::_()->getDbTable('services', 'estore');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {

        $values = $_POST;
        $values['store_id'] = $store_id;
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
              'parent_type' => 'estore_service',
              'user_id' => $viewer_id,
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $row->photo_id = $filename->file_id;
          $row->save();
        }

        $db->commit();
        $paginator = Engine_Api::_()->getDbTable('services', 'estore')->getServiceMemers(array('store_id' => $store->store_id));
        $showData = $this->view->partial('_services.tpl', 'estore', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'store_id' => $store->store_id, 'is_ajax' => true));
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

    $estore_allow_service = Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.service', 1);
    if(empty($estore_allow_service))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->is_ajax = $is_ajax = $this->_getParam('is_ajax', 0);
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer_id = $viewer->getIdentity();

    $this->view->store_id = $store_id = $this->_getParam('store_id', null);

    $store = Engine_Api::_()->getItem('stores', $store_id);

    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $this->view->service = $service = Engine_Api::_()->getItem('estore_service', $service_id);

    if (!$is_ajax) {
      // Prepare form
      $this->view->form = $form = new Estore_Form_Service_Edit();
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
              'parent_type' => 'estore_service',
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

        $paginator = Engine_Api::_()->getDbTable('services', 'estore')->getServiceMemers(array('store_id' => $store->store_id));
        $showData = $this->view->partial('_services.tpl', 'estore', array('paginator' => $paginator, 'viewer_id' => $viewer_id, 'store_id' => $store->store_id, 'is_ajax' => true));
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
    $this->view->store_id = $store_id = $this->_getParam('store_id', null);
    $this->view->service_id = $service_id = $this->_getParam('service_id');
    $item = Engine_Api::_()->getItem('estore_service', $service_id);
    if (!$is_ajax) {
      $this->view->form = $form = new Estore_Form_Service_Delete();
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

  public function manageTeamAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;

    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;

    $this->view->store = $store = Engine_Api::_()->core()->getSubject();

    $viewer = Engine_Api::_()->user()->getViewer();

    // Permission check
    $enableTeam = Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'store_team');
    if (empty($enableTeam)) {
      return $this->_forward('requireauth', 'error', 'core');
    }

    // Designations
    $this->view->designations = Engine_Api::_()->getDbTable('designations', 'estoreteam')->getAllDesignations(array('store_id' => $store->store_id));

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('teams', 'estoreteam')->getTeamMemers(array('store_id' => $store->store_id));

    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function manageLocationAction() {
    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.enable.location', 1) || !Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'allow_mlocation'))
      return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('locations', 'estore')
            ->getStoreLocationPaginator(array('store_id' => $store->store_id));
    $paginator->setItemCountPerPage(5);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function manageMemberAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $value = array();
    $this->view->is_search_ajax = $is_search_ajax = isset($_POST['is_search_ajax']) ? $_POST['is_search_ajax'] : false;
    if (!$is_search_ajax) {
      $this->view->searchForm = $searchForm = new Estore_Form_Dashboard_ManageMembers();
    }
    if (isset($_POST['searchParams']) && $_POST['searchParams'])
      parse_str($_POST['searchParams'], $searchArray);

    $value['name'] = isset($searchArray['name']) ? $searchArray['name'] : '';
    $value['email'] = isset($searchArray['email']) ? $searchArray['email'] : '';
    $value['status'] = isset($searchArray['status']) ? $searchArray['status'] : '';

    $table = Engine_Api::_()->getDbTable('users', 'user');
    $subtable = Engine_Api::_()->getDbTable('membership', 'estore');
    $tableName = $table->info('name');
    $subtableName = $subtable->info('name');
    $select = $table->select()
            ->from($tableName, array('user_id', 'displayname', 'email', 'photo_id'))
            ->setIntegrityCheck(false)
            ->joinRight($subtableName, '`' . $subtableName . '`.`user_id` = `' . $tableName . '`.`user_id`', array('resource_approved', 'user_approved', 'active'))
            ->where('`' . $subtableName . '`.`resource_id` = ?', $store->getIdentity());
    if (isset($value['name']) && $value['name'])
      $select->where($tableName . '.displayname LIKE ?', '%' . $value['name'] . '%');
    if (isset($value['email']) && $value['email'])
      $select->where($tableName . '.email LIKE ?', '%' . $value['email'] . '%');
    if (isset($value['status']) && $value['status'])
      $select->where($subtableName . '.active =?', $value['status']);
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($page);
  }

  public function announcementAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('stores', $this->view->viewer(), 'auth_announce'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('announcements', 'estore')
            ->getStoreAnnouncementPaginator(array('store_id' => $store->store_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber ($this->_getParam('page', 1));
  }

  public function postAnnouncementAction() {
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Estore_Form_Dashboard_Postannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcementTable = Engine_Api::_()->getDbTable('announcements', 'estore');
    $db = $announcementTable->getAdapter();
    $db->beginTransaction();
    try {
      $announcement = $announcementTable->createRow();
      $announcement->setFromArray(array_merge(array(
          'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          'store_id' => $store->store_id), $form->getValues()));
      $announcement->save();
      $db->commit();

      $getAllStoreMembers = Engine_Api::_()->estore()->getAllStoreMembers($store);
      foreach ($getAllStoreMembers as $user) {
        $user = Engine_Api::_()->getItem('user', $user);
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, Engine_Api::_()->user()->getViewer(), $store, 'estore_store_newanc');

        //mail
        //Engine_Api::_()->getApi('mail', 'core')->sendSystem($followerMember, 'notify_estore_storeroll_createstore', array('store_title' => $store->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST']));
      }

      // Redirect
      $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'announcement', 'store_id' => $store->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function editAnnouncementAction() {
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $announcement = Engine_Api::_()->getItem('estore_announcement', $this->_getParam('id'));
    $this->view->form = $form = new Estore_Form_Dashboard_Editannouncement();
    $form->title->setValue($announcement->title);
    $form->body->setValue($announcement->body);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $announcement->title = $_POST['title'];
    $announcement->body = $_POST['body'];
    $announcement->save();
    $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'announcement', 'store_id' => $store->custom_url));
  }

  public function deleteAnnouncementAction() {
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
     $this->view->form = $form = new Estore_Form_Dashboard_Deleteannouncement();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if($this->_getParam('id')) {
        $announcement = Engine_Api::_()->getItem('estore_announcement', $this->_getParam('id'));
         $announcement->delete();
    } else if(isset($_POST['ids']) && !empty($_POST['ids'])) {
        $ids = explode(",",$_POST['ids']);
        foreach($ids as $id){

             $announcement = Engine_Api::_()->getItem('estore_announcement',$id);
             if(!empty($announcement)) {
                 $announcement->delete();
             }
        }
    } else {
      $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'announcement', 'store_id' => $store->custom_url));
    }

    $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'announcement', 'store_id' => $store->custom_url));

  }

  public function addLocationAction() {
    $store = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Estore_Form_Dashboard_Addlocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    if (!empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_estore_locations', array('is_default' => 0), array('store_id =?' => $store->store_id));
      }
      $dbGetInsert->query('INSERT INTO engine4_estore_locations (store_id,title,location,venue, lat, lng ,city,state,zip,country,address,address2, is_default) VALUES ("' . $store->store_id . '","' . $_POST['title'] . '","' . $_POST['location'] . '", "' . $_POST['venue_name'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '","' . $_POST['is_default'] . '") ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue_name'] . '"');
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $store->store_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "stores")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $store->location = $_POST['location'];
        $store->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function designAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Estore_Form_Dashboard_Viewdesign();
    $form->storestyle->setValue($store->storestyle);
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    $store->storestyle = $_POST['storestyle'];
    $store->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'design', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function editLocationAction() {
    $store = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Estore_Form_Dashboard_Editlocation();
    $location = Engine_Api::_()->getItem('estore_location', $this->_getParam('location_id'));
    $form->title->setValue($location->title);
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    if (!empty($_POST['location'])) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      if (isset($_POST['is_default']) && !empty($_POST['is_default'])) {
        $dbGetInsert->update('engine4_estore_locations', array('is_default' => 0), array('store_id =?' => $store->store_id));
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
        $dbGetInsert->query('INSERT INTO engine4_sesbasic_locations (resource_id,venue, lat, lng ,city,state,zip,country,address,address2, resource_type) VALUES ("' . $store->store_id . '","' . $_POST['location'] . '", "' . $_POST['lat'] . '","' . $_POST['lng'] . '","' . $_POST['city'] . '","' . $_POST['state'] . '","' . $_POST['zip'] . '","' . $_POST['country'] . '","' . $_POST['address'] . '","' . $_POST['address2'] . '",  "stores")	ON DUPLICATE KEY UPDATE	lat = "' . $_POST['lat'] . '" , lng = "' . $_POST['lng'] . '",city = "' . $_POST['city'] . '", state = "' . $_POST['state'] . '", country = "' . $_POST['country'] . '", zip = "' . $_POST['zip'] . '", address = "' . $_POST['address'] . '", address2 = "' . $_POST['address2'] . '", venue = "' . $_POST['venue'] . '"');
        $store->location = $_POST['location'];
        $store->save();
      }
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function deleteLocationAction() {
    $store = Engine_Api::_()->core()->getSubject();
    $this->view->form = $form = new Estore_Form_Dashboard_Deletelocation();
    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;
    $location = Engine_Api::_()->getItem('estore_location', $this->_getParam('location_id'));
    $location->delete();

    return $this->_helper->redirector->gotoRoute(array('action' => 'manage-location', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function addPhotosAction() {
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->location = $location = Engine_Api::_()->getItem('estore_location', $this->_getParam('location_id'));
  }

  public function composeUploadAction() {
    if (!Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->_redirect('login');
      return;
    }
    $location = Engine_Api::_()->getItem('estore_location', $this->_getParam('location_id'));
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
    $photoTable = Engine_Api::_()->getItemTable('estore_locationphoto');
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
      $photo->store_id = $location->store_id;
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
    $photo = Engine_Api::_()->getItem('estore_locationphoto', $photo_id);
    $db = Engine_Api::_()->getItemTable('estore_locationphoto')->getAdapter();
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
    $store = Engine_Api::_()->core()->getSubject();
    $db = Engine_Api::_()->getDbTable('stores', 'estore')->getAdapter();
    $db->beginTransaction();
    try {
      $store->photo_id = '';
      $store->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'mainphoto', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function insightsAction() {
    if (!Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'auth_insightrpt'))
      return $this->_forward('requireauth', 'error', 'core');
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->view_type = $interval = isset($_POST['type']) ? $_POST['type'] : 'monthly';
    $dateArray = $this->createDateRangeArray($store->creation_date, $store->creation_date, $interval);

    $likeTable = Engine_Api::_()->getDbTable('likes', 'sesbasic');
    $likeSelect = $likeTable->select()->from($likeTable->info('name'), array(new Zend_Db_Expr('"like" AS type'), 'COUNT(like_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
             ->where('resource_type =?', 'stores')
             ->where('resource_id =?', $store->store_id);
    if ($interval == 'monthly')
      $likeSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $likeSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $likeSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $likeSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $likeSelect->group("HOUR(creation_date)");
    }

    $commentTable = Engine_Api::_()->getDbTable('comments', 'core');
    $commentSelect = $commentTable->select()->from($commentTable->info('name'), array(new Zend_Db_Expr('"comment" AS type'), 'COUNT(comment_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'stores')
            ->where('resource_id =?', $store->store_id);
    if ($interval == 'monthly')
      $commentSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $commentSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $commentSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $commentSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $commentSelect->group("HOUR(creation_date)");
    }

    $favouriteTable = Engine_Api::_()->getDbTable('favourites', 'estore');
    $favouritesSelect = $favouriteTable->select()->from($favouriteTable->info('name'), array(new Zend_Db_Expr('"favourite" AS type'), 'COUNT(favourite_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'stores')
            ->where('resource_id =?', $store->store_id);
    if ($interval == 'monthly')
      $favouritesSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $favouritesSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $favouritesSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $favouritesSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $favouritesSelect->group("HOUR(creation_date)");
    }

    $viewTable = Engine_Api::_()->getDbTable('recentlyviewitems', 'estore');
    $viewSelect = $viewTable->select()->from($viewTable->info('name'), array(new Zend_Db_Expr('"view" AS type'), 'COUNT(recentlyviewed_id) as total', 'creation_date', 'DATE_FORMAT(creation_date,"%Y-%m-%d %H") as hourtime'))
            ->where('resource_type =?', 'stores')
            ->where('resource_id =?', $store->store_id);
    if ($interval == 'monthly')
      $viewSelect->group("month(creation_date)");
    elseif ($interval == 'weekly')
      $viewSelect->group("week(creation_date)");
    elseif ($interval == 'daily')
      $viewSelect->group("DATE_FORMAT(creation_date, '%Y-%m-%d')");
    elseif ($interval == 'hourly') {
      $viewSelect->where('DATE_FORMAT(creation_date,"%Y-%m-%d") =?', date('Y-m-d'));
      $viewSelect->group("HOUR(creation_date)");
    }
    $dataSelect = $viewSelect . ' ' . UNION . ' ' . $favouritesSelect . ' ' . UNION . ' ' . $commentSelect . ' ' . UNION . ' ' . $likeSelect;
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $results = $db->query($dataSelect)->fetchAll();

    $var1 = $var2 = $var3 = $var4 = $var5 = $var6 = array();
    $array1 = $array2 = $array3 = $array4 = $array5 = array();
    if ($interval == 'monthly') {
      $this->view->likeHeadingTitle = $this->view->translate("Monthly Like Report For ") . $store->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Monthly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Monthly Comment Report For ") . $store->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Monthly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Monthly Favourite Report For ") . $store->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Monthly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Monthly Views Report For ") . $store->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Monthly Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m', (strtotime($result['creation_date'])))] = $result['total'];
      }
      foreach ($dateArray as $date) {
        if (!$is_ajax)
          $var2[] = '"' . date("d", strtotime($date)) . '-' . date("M", strtotime($date)) . '"';
        else
          $var2[] = date("d", strtotime($date)) . '-' . date("M", strtotime($date));
        if (isset($array1[date('Y-m', strtotime($date))])) {
          $var1[] = $array1[date('Y-m', strtotime($date))];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[date('Y-m', strtotime($date))])) {
          $var3[] = $array2[date('Y-m', strtotime($date))];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[date('Y-m', strtotime($date))])) {
          $var4[] = $array3[date('Y-m', strtotime($date))];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[date('Y-m', strtotime($date))])) {
          $var5[] = $array4[date('Y-m', strtotime($date))];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[date('Y-m', strtotime($date))])) {
          $var6[] = $array5[date('Y-m', strtotime($date))];
        } else {
          $var6[] = 0;
        }
      }
    } elseif ($interval == 'weekly') {
      $this->view->likeHeadingTitle = $this->view->translate("Weekly Like Report For ") . $store->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Weekly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Weekly Comment Report For ") . $store->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Weekly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Weekly Favourite Report For ") . $store->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Weekly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Weekly Views Report For ") . $store->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Weekly Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m-d', strtotime("last Sunday", strtotime($result['creation_date'])))] = $result['total'];
      }
      $previousYear = '';
      foreach ($dateArray as $date) {
        $year = date('Y', strtotime($date));
        if ($previousYear != $year)
          $yearString = '-' . $year;
        else
          $yearString = '';
        if (!$is_ajax)
          $var2[] = '"' . (date("d-M", strtotime($date))) . $yearString . '"';
        else
          $var2[] = (date("d-M", strtotime($date))) . $yearString;
        if (isset($array1[date('Y-m-d', strtotime($date))])) {
          $var1[] = $array1[date('Y-m-d', strtotime($date))];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[date('Y-m-d', strtotime($date))])) {
          $var3[] = $array2[date('Y-m-d', strtotime($date))];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[date('Y-m-d', strtotime($date))])) {
          $var4[] = $array3[date('Y-m-d', strtotime($date))];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[date('Y-m-d', strtotime($date))])) {
          $var5[] = $array4[date('Y-m-d', strtotime($date))];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[date('Y-m-d', strtotime($date))])) {
          $var6[] = $array5[date('Y-m-d', strtotime($date))];
        } else {
          $var6[] = 0;
        }
        $previousYear = $year;
      }
    } elseif ($interval == 'daily') {
      $this->view->likeHeadingTitle = $this->view->translate("Daily Like Report for ") . $store->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Daily Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Daily Comment Report for ") . $store->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Daily Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Daily Favourite Report for ") . $store->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Daily Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Daily Views Report for ") . $store->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Daily Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m-d', strtotime($result['creation_date']))] = $result['total'];
      }
      foreach ($dateArray as $date) {
        if (!$is_ajax)
          $var2[] = '"' . date("d", strtotime($date)) . '-' . date("M", strtotime($date)) . '"';
        else
          $var2[] = date("d", strtotime($date)) . '-' . date("M", strtotime($date));
        if (isset($array1[$date])) {
          $var1[] = $array1[$date];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[$date])) {
          $var3[] = $array2[$date];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[$date])) {
          $var4[] = $array3[$date];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[$date])) {
          $var5[] = $array4[$date];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[$date])) {
          $var6[] = $array5[$date];
        } else {
          $var6[] = 0;
        }
      }
    } elseif ($interval == 'hourly') {
      $this->view->likeHeadingTitle = $this->view->translate("Hourly Like Report For ") . $store->getTitle();
      $this->view->likeXAxisTitle = $this->view->translate("Hourly Likes");
      $this->view->commentHeadingTitle = $this->view->translate("Hourly Comment Report For ") . $store->getTitle();
      $this->view->commentXAxisTitle = $this->view->translate("Hourly Comments");
      $this->view->favouriteHeadingTitle = $this->view->translate("Hourly Favourite Report For ") . $store->getTitle();
      $this->view->favouriteXAxisTitle = $this->view->translate("Hourly Favourites");
      $this->view->viewHeadingTitle = $this->view->translate("Hourly Views Report For ") . $store->getTitle();
      $this->view->viewXAxisTitle = $this->view->translate("Hourly Views");
      foreach ($results as $result) {
        if ($result['type'] == 'like')
          $array2[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'comment')
          $array3[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'favourite')
          $array4[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
        elseif ($result['type'] == 'view')
          $array5[date('Y-m-d H', strtotime($result['creation_date']))] = $result['total'];
      }
      foreach ($dateArray as $date) {
        $time = date("h A", strtotime($date . ':00:00'));
        if (!$is_ajax)
          $var2[] = '"' . $time . '"';
        else
          $var2[] = $time;
        if (isset($array1[$date])) {
          $var1[] = $array1[$date];
        } else {
          $var1[] = 0;
        }
        if (isset($array2[$date])) {
          $var3[] = $array2[$date];
        } else {
          $var3[] = 0;
        }
        if (isset($array3[$date])) {
          $var4[] = $array3[$date];
        } else {
          $var4[] = 0;
        }
        if (isset($array4[$date])) {
          $var5[] = $array4[$date];
        } else {
          $var5[] = 0;
        }
        if (isset($array5[$date])) {
          $var6[] = $array5[$date];
        } else {
          $var6[] = 0;
        }
      }
    }
    if ($is_ajax) {
      echo json_encode(array('date' => $var2, 'voteCount' => $var1, 'likeCount' => $var3, 'commentCount' => $var4, 'favouriteCount' => $var5, 'viewCount' => $var6, 'headingTitle' => $this->view->headingTitle, 'XAxisTitle' => $this->view->XAxisTitle, 'likeHeadingTitle' => $this->view->likeHeadingTitle, 'likeXAxisTitle' => $this->view->likeXAxisTitle, 'commentHeadingTitle' => $this->view->commentHeadingTitle, 'commentXAxisTitle' => $this->view->commentXAxisTitle, 'favouriteHeadingTitle' => $this->view->favouriteHeadingTitle, 'favouriteXAxisTitle' => $this->view->favouriteXAxisTitle, 'viewHeadingTitle' => $this->view->viewHeadingTitle, 'viewXAxisTitle' => $this->view->viewXAxisTitle));
      die;
    } else {
      $this->view->date = $var2;
      $this->view->voteCount = $var1;
      $this->view->like_count = $var3;
      $this->view->comment_count = $var4;
      $this->view->favourite_count = $var5;
      $this->view->view_count = $var6;
    }
  }

  // create date range from 2 given dates.
  public function createDateRangeArray($strDateFrom = '', $strDateTo = '', $interval) {
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    $aryRange = array();
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
      if ($interval == 'monthly') {
        array_push($aryRange, date('Y-m', $iDateFrom));
        $iDateFrom = strtotime('+1 Months', $iDateFrom);
        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m', $iDateFrom));
          $iDateFrom += strtotime('+1 Months', $iDateFrom);
        }
      } elseif ($interval == 'weekly') {
        array_push($aryRange, date('Y-m-d', strtotime("last Sunday", $iDateFrom)));
        $iDateFrom = strtotime('+1 Weeks', $iDateFrom);
        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m-d', strtotime("last Sunday", $iDateFrom)));
          $iDateFrom = strtotime('+1 Weeks', $iDateFrom);
        }
      } elseif ($interval == 'daily') {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
          $iDateFrom += 86400; // add 24 hours
          array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
      } elseif ($interval == 'hourly') {
        $iDateFrom = strtotime(date('Y-m-d 00:00:00'));
        $iDateTo = strtotime('+1 Day', $iDateFrom);

        array_push($aryRange, date('Y-m-d H', $iDateFrom));
        $iDateFrom = strtotime('+1 Hours', ($iDateFrom));

        while ($iDateFrom < $iDateTo) {
          array_push($aryRange, date('Y-m-d H', $iDateFrom));
          $iDateFrom = strtotime('+1 Hours', ($iDateFrom));
        }
      }
    }
    $preserve = $aryRange;
    return $preserve;
  }

  public function reportsAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Estore_Form_Dashboard_Searchreport();
    $value = array();
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
    if (isset($_GET['excel']) && $_GET['excel'] != '')
      $value['download'] = 'excel';
    if (isset($_GET['csv']) && $_GET['csv'] != '')
      $value['download'] = 'csv';

    $form->populate($value);
    $value['store_id'] = $store->getIdentity();
    $this->view->storeReportData = $data = Engine_Api::_()->getDbTable('stores', 'estore')->getReportData($value);

    if (isset($value['download'])) {
      $name = str_replace(' ', '_', $store->getTitle()) . '_' . time();
      switch ($value["download"]) {
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


  public function backgroundphotoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Backgroundphoto();
    $form->populate($store->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('stores', 'estore')->getAdapter();
    $db->beginTransaction();
    try {
      $store->setBackgroundPhoto($_FILES['background'], 'background');
      $store->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function removeBackgroundphotoAction() {
    $store = Engine_Api::_()->core()->getSubject();
    $store->background_photo_id = 0;
    $store->save();
    return $this->_helper->redirector->gotoRoute(array('action' => 'backgroundphoto', 'store_id' => $store->custom_url), "estore_dashboard", true);
  }

  public function mainphotoAction() {

    if (!Engine_Api::_()->authorization()->isAllowed('stores', $this->view->viewer(), 'upload_mainphoto'))
      return $this->_forward('requireauth', 'error', 'core');

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $this->view->viewer = Engine_Api::_()->user()->getViewer();

    // Get form
    $this->view->form = $form = new Estore_Form_Dashboard_Mainphoto();

    if (empty($store->photo_id)) {
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
      $db = $store->getTable()->getAdapter();
      $db->beginTransaction();

      try {
        $fileElement = $form->Filedata;
        //$photo_id = Engine_Api::_()->sesbasic()->setPhoto($fileElement, false, false, 'estore', store, '', $store, true);
        $store->setPhoto($fileElement, '', 'profile');
//         $store->photo_id = $photo_id;
//         $store->save();
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

  public function removePhotoAction() {
    //Get form
    $this->view->form = $form = new Estore_Form_Dashboard_RemovePhoto();

    if (!$this->getRequest()->isPost() || !$form->isValid($this->getRequest()->getPost()))
      return;

    $store = Engine_Api::_()->core()->getSubject();
    $store->photo_id = 0;
    $store->save();

    $this->view->status = true;

    $this->_forward('success', 'utility', 'core', array(
        'smoothboxClose' => true,
        'parentRefresh' => true,
        'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your photo has been removed.'))
    ));
  }
  public function policyAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
      $this->view->store = $store = Engine_Api::_()->core()->getSubject();
      $viewer = Engine_Api::_()->user()->getViewer();
			if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.termncondition', 1))
				return $this->_forward('notfound', 'error', 'core');
      // Create form
      $this->view->form = $form = new Estore_Form_Dashboard_Policy();
      $form->populate($store->toArray());
      if (!$this->getRequest()->isPost())
        return;
      // Not post/invalid
      if (!$this->getRequest()->isPost() || $is_ajax_content)
        return;
      if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
        return;
      $db = Engine_Api::_()->getDbTable('stores', 'estore')->getAdapter();
      $db->beginTransaction();
      try {
        $store->setFromArray($_POST);
        $store->save();
        $db->commit();
        //Activity Feed Work
  //      $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
  //      $action = $activityApi->addActivity($viewer, $store, 'estore_store_editstoreoverview');
  //      if ($action) {
  //        $activityApi->attachActivity($action, $store);
  //      }
      } catch (Exception $e) {
        $db->rollBack();
      }
  }
  public function storePolicyAction() {
      $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
      $storeId = $this->_getParam('store_id');
      $viewer = Engine_Api::_()->user()->getViewer();
			if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('estore.allow.termncondition', 1))
				return $this->_forward('notfound', 'error', 'core');
      // Create form
      if($storeId) {
        $this->view->store = Engine_Api::_()->getItem('stores',$storeId);
      } else {
        return false;
      }
  }
  public function overviewAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Overview();
    $form->populate($store->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('stores', 'estore')->getAdapter();
    $db->beginTransaction();
    try {
      $store->setFromArray($_POST);
      $store->save();
      $db->commit();
      //Activity Feed Work
//      $activityApi = Engine_Api::_()->getDbTable('actions', 'activity');
//      $action = $activityApi->addActivity($viewer, $store, 'estore_store_editstoreoverview');
//      if ($action) {
//        $activityApi->attachActivity($action, $store);
//      }
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  //get seo detail
  public function seoAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Seo();

    $form->populate($store->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $db = Engine_Api::_()->getDbTable('stores', 'estore')->getAdapter();
    $db->beginTransaction();
    try {
      $store->setFromArray($_POST);
      $store->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  //get style detail
  public function openHoursAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    if ($this->getRequest()->isPost()) {
      $openHours = Engine_Api::_()->getDbTable('openhours', 'estore')->getStoreHours(array('store_id' => $store->getIdentity()));
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
      $openHoursTable = Engine_Api::_()->getDbTable('openhours', 'estore');
      $db = $openHoursTable->getAdapter();
      $db->beginTransaction();
      try {
        if ($_POST['hours'] == "closed") {
          $store->status = 0;
          $store->save();
        } else {
          $store->status = 1;
          $store->save();
        }
        if (!$openHours)
          $openHours = $openHoursTable->createRow();
        $values['params'] = json_encode($data);
        $values['store_id'] = $store->getIdentity();
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
    $hoursData = Engine_Api::_()->getDbTable('openhours', 'estore')->getStoreHours(array('store_id' => $store->getIdentity()));
    if ($hoursData) {
      $this->view->hoursData = json_decode($hoursData->params, true);
      $this->view->timezone = $hoursData->timezone;
    }
  }

  //get style detail
  public function styleAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get current row
    $table = Engine_Api::_()->getDbTable('styles', 'core');
    $select = $table->select()
            ->where('type = ?', 'stores')
            ->where('id = ?', $store->getIdentity())
            ->limit(1);
    $row = $table->fetchRow($select);
    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Style();
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
      $row->type = 'stores';
      $row->id = $store->getIdentity();
    }
    $row->style = $style;
    $row->save();
  }

  public function advertiseStoreAction() {

    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
  }

  // Send Update who like, follow and join store
  public function sendUpdatesAction() {

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_id');
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type');

    if (!$id || !$type)
      return;

    // Make form
    $this->view->form = $form = new Estore_Form_Dashboard_SendUpdates();

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
      $likeMembers = Engine_Api::_()->estore()->getMemberByLike($attachment->getIdentity());
      foreach ($likeMembers as $likeMember) {
        $likeMemberIds[] = $likeMember['poster_id'];
      }
    }
    if (in_array('followed', $values['type'])) {

      $followMembers = Engine_Api::_()->estore()->getMemberFollow($attachment->getIdentity());
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

  //get store contact information
  public function contactInformationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = Engine_Api::_()->user()->getViewer();
    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Contactinformation();

    $form->populate($store->toArray());
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    if (!empty($_POST["store_contact_email"]) && !filter_var($_POST["store_contact_email"], FILTER_VALIDATE_EMAIL)) {
      $form->addError($this->view->translate("Invalid email format."));
      return;
    }
    if (!empty($_POST["store_contact_website"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["store_contact_website"])) {
      $form->addError($this->view->translate("Invalid WebSite URL."));
      return;
    }
    if (!empty($_POST["store_contact_facebook"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["store_contact_facebook"])) {
      $form->addError($this->view->translate("Invalid Facebook URL."));
      return;
    }
    if (!empty($_POST["store_contact_linkedin"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["store_contact_linkedin"])) {
      $form->addError($this->view->translate("Invalid Linkedin URL."));
      return;
    }
    if (!empty($_POST["store_contact_twitter"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["store_contact_twitter"])) {
      $form->addError($this->view->translate("Invalid Twitter URL."));
      return;
    }
    if (!empty($_POST["store_contact_instagram"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["store_contact_instagram"])) {
      $form->addError($this->view->translate("Invalid Instagram URL."));
      return;
    }
    if (!empty($_POST["store_contact_pinterest"]) && !preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["store_contact_pinterest"])) {
      $form->addError($this->view->translate("Invalid Pinterest URL."));
      return;
    }
    $db = Engine_Api::_()->getDbTable('stores', 'estore')->getAdapter();
    $db->beginTransaction();
    try {
      $store->setFromArray($form->getValues());
      $store->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      echo false;
      die;
    }
  }

  public function linkedStoreAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('linkstores', 'estore')
        ->getLinkStoresPaginator(array('store_id' => $store->store_id));
    $paginator->setItemCountPerPage(10);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    if (!$this->getRequest()->isPost() || empty($_POST['store_id']))
      return;
    $linkStore = Engine_Api::_()->getItem('stores', $_POST['store_id']);
    $storeOwner = Engine_Api::_()->getItem('user', $linkStore->owner_id);

    $storeLinkTable = Engine_Api::_()->getDbTable('linkstores', 'estore');
    $db = $storeLinkTable->getAdapter();
    $db->beginTransaction();
    try {
      $linkedStore = $storeLinkTable->createRow();
      $linkedStore->setFromArray(array(
          'user_id' => $viewer->getIdentity(),
          'store_id' => $store->store_id,
          'link_store_id' => $_POST['store_id']));
      $linkedStore->save();
      $db->commit();
      if ($storeOwner->getIdentity() != $viewer->getIdentity())
        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($storeOwner, $viewer, $linkStore, 'estore_link_store');
      $this->_redirectCustom(array('route' => 'estore_dashboard', 'action' => 'linked-store', 'store_id' => $store->custom_url));
    } catch (Exception $e) {
      $db->rollBack();
    }
  }

  public function searchStoreAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $sesdata = array();
    $viewerId = $this->view->viewer()->getIdentity();
    $storeTable = Engine_Api::_()->getItemTable('stores');
    $linkStoreTable = Engine_Api::_()->getDbTable('linkstores', 'estore');
    $select = $linkStoreTable->select()
            ->from($linkStoreTable->info('name'), 'link_store_id')
            ->where('user_id =?', $viewerId);
    $linkedStores = $storeTable->fetchAll($select)->toArray();
    $selectStoreTable = $storeTable->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"');
    if (count($linkedStores) > 0)
      $selectStoreTable->where('store_id NOT IN(?)', $linkedStores);

    $stores = $storeTable->fetchAll($selectStoreTable);
    foreach ($stores as $store) {
      $store_icon = $this->view->itemPhoto($store, 'thumb.icon');
      $sesdata[] = array(
          'id' => $store->store_id,
          'user_id' => $store->owner_id,
          'label' => $store->title,
          'photo' => $store_icon
      );
    }
    return $this->_helper->json($sesdata);
  }

  function sendMessage($stores, $store, $is_ajax_content) {
    // Assign the composing stuff
    $composePartials = array();
    $prohibitedPartials = array('_composeTwitter.tpl', '_composeFacebook.tpl');
    foreach (Zend_Registry::get('Engine_Manifest') as $data) {
      if (empty($data['composer'])) {
        continue;
      }
      foreach ($data['composer'] as $type => $config) {
        // is the current user has "create" privileges for the current plugin
        if (isset($config['auth'], $config['auth'][0], $config['auth'][1])) {
          $isAllowed = Engine_Api::_()
                  ->authorization()
                  ->isAllowed($config['auth'][0], null, $config['auth'][1]);

          if (!empty($config['auth']) && !$isAllowed) {
            continue;
          }
        }
        if (!in_array($config['script'][0], $prohibitedPartials)) {
          $composePartials[] = $config['script'];
        }
      }
    }
    $this->view->composePartials = $composePartials;

    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Compose();
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;

    // Process
    $db = Engine_Api::_()->getDbTable('messages', 'messages')->getAdapter();
    $db->beginTransaction();

    try {
      // Try attachment getting stuff
      $attachment = null;
      $attachmentData = $this->getRequest()->getParam('attachment');
      if (!empty($attachmentData) && !empty($attachmentData['type'])) {
        $type = $attachmentData['type'];
        $config = null;
        foreach (Zend_Registry::get('Engine_Manifest') as $data) {
          if (!empty($data['composer'][$type])) {
            $config = $data['composer'][$type];
          }
        }
        if ($config) {
          $plugin = Engine_Api::_()->loadClass($config['plugin']);
          $method = 'onAttach' . ucfirst($type);
          $attachment = $plugin->$method($attachmentData);
          $parent = $attachment->getParent();
          if ($parent->getType() === 'user') {
            $attachment->search = 0;
            $attachment->save();
          } else {
            $parent->search = 0;
            $parent->save();
          }
        }
      }

      $viewer = Engine_Api::_()->user()->getViewer();
      $values = $form->getValues();
      $actionName = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
      if ($actionName == 'contact-stores') {
        foreach ($stores as $store)
          $userIds[] = $store->owner_id;
      } else
        $userIds = $_POST['winner'];

      $recipientsUsers = Engine_Api::_()->getItemMulti('user', $userIds);

      // Create conversation
      $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
              $viewer, $userIds, $values['title'], $values['body'], $attachment
      );

      // Send notifications
      foreach ($recipientsUsers as $user) {
        if ($user->getIdentity() == $viewer->getIdentity()) {
          continue;
        }

        Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification(
                $user, $viewer, $conversation, 'message_new'
        );
      }

      // Increment messages counter
      Engine_Api::_()->getDbTable('statistics', 'core')->increment('messages.creations');

      // Commit
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $_SESSION['show_message'] = 1;
    if ($actionName == 'contact-stores') {
      return $this->_helper->redirector->gotoRoute(array('action' => 'contact-stores', 'store_id' => $store->custom_url), "estore_dashboard", true);
    } else {
      return $this->_helper->redirector->gotoRoute(array('action' => 'contact-winners', 'store_id' => $store->custom_url), "estore_dashboard", true);
    }
  }

  public function getMembersAction() {
    $sesdata = array();
    $roleIDArray = array();
    // $ownerId = Engine_Api::_()->getItem('stores', $this->_getParam('store_id', null))->user_id;
    //$viewer = Engine_Api::_()->getItem('user', $ownerId);
    $users = array();
    $roleTable = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('store_id =?', $this->_getParam('store_id', null))->query()->fetchAll();
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

  public function changeStoreAdminAction() {
    $storerole_id = $this->_getParam('storerole_id', '');
    $storeroleid = $this->_getParam('storeroleid', '');
    $store_id = $this->_getParam('store_id', '');
    $roleTable = Engine_Api::_()->getDbTable('storeroles', 'estore');
    if (!$storeroleid) {
      $roleId = $this->_getParam('roleId', '');
      $roleIds = $roleTable->select()->from($roleTable->info('name'), '*')->where('store_id =?', $this->_getParam('store_id', null))->where('storerole_id =?', $storerole_id);
      $storeRole = $roleTable->fetchRow($roleIds);
      if (!($storeRole)) {
        echo 0;
        die;
      }
      $storeRole->memberrole_id = $roleId;
      $storeRole->save();
    } else {
      $storeRole = Engine_Api::_()->getItem('estore_storerole', $storeroleid);
      $storeRole->delete();
    }
    $this->view->store = $store = Engine_Api::_()->getItem('stores', $store_id);
    $this->view->is_ajax = 1;
    $this->view->storeRoles = Engine_Api::_()->getDbTable('memberroles', 'estore')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('store_id =?', $store->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/store-roles.tpl');
  }

  public function storeRolesAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    if (!Engine_Api::_()->authorization()->isAllowed('stores', $viewer, 'bs_allow_roles'))
      return $this->_forward('requireauth', 'error', 'core');

    $this->view->storeRoles = Engine_Api::_()->getDbTable('memberroles', 'estore')->getLevels(array('status' => true));
    $roleTable = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('store_id =?', $store->getIdentity())->order('memberrole_id ASC')->query()->fetchAll();
  }

  public function addStoreAdminAction() {
    if (!count($_POST)) {
      echo 0;
      die;
    }

    $user_id = $this->_getParam('user_id', '');
    $store_id = $this->_getParam('store_id', '');
    $roleId = $this->_getParam('roleId', '');
    $roleTable = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $roleIds = $roleTable->select()->from($roleTable->info('name'), 'user_id')->where('store_id =?', $this->_getParam('store_id', null))->where('user_id =?', $user_id)->query()->fetchAll();
    if (count($roleIds)) {
      echo 0;
      die;
    }

    $storeRoleTable = Engine_Api::_()->getDbTable('storeroles', 'estore');
    $storeRole = $storeRoleTable->createRow();
    $storeRole->user_id = $user_id;
    $storeRole->store_id = $store_id;
    $storeRole->memberrole_id = $roleId;
    $storeRole->save();
    $user = Engine_Api::_()->getItem('user', $user_id);
    $this->view->store = $store = Engine_Api::_()->getItem('stores', $store_id);
    $storeRole = Engine_Api::_()->getItem('estore_memberrole', $roleId);
    $title = array('roletitle' => $storeRole->title);
    //notification
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($user, $store->getOwner(), $store, 'estore_storeroll_ctbs', $title);

    //mail
    Engine_Api::_()->getApi('mail', 'core')->sendSystem($user, 'notify_estore_storeroll_createstore', array('store_title' => $store->getTitle(), 'sender_title' => $store->getOwner()->getTitle(), 'object_link' => $store->getHref(), 'host' => $_SERVER['HTTP_HOST'], 'role_title' => $storeRole->title));


    $this->view->is_ajax = 1;
    $this->view->storeRoles = Engine_Api::_()->getDbTable('memberroles', 'estore')->getLevels(array('status' => true));
    $this->view->roles = $roleTable->select()->from($roleTable->info('name'), '*')->where('store_id =?', $store->getIdentity())->query()->fetchAll();
    $this->renderScript('dashboard/store-roles.tpl');
  }

  public function crossPostStoreAction() {
    $query = $this->_getParam('text', '');
    $crossPosts = Engine_Api::_()->getItemTable('estore_crosspost')->getCrossposts(array('store_id' => $this->_getParam('store_id')));
    $store_ids = array();
    foreach ($crossPosts as $store) {
      $store_ids[] = $store['receiver_store_id'];
      $store_ids[] = $store['sender_store_id'];
    }
    $table = Engine_Api::_()->getItemTable('stores');
    $storeCrossPostTable = Engine_Api::_()->getItemTable('estore_crosspost')->info('name');
    $select = $table->select()->where('title LIKE "%' . $this->_getParam('text', '') . '%"')->from($table->info('name'))->where('store_id !=?', $this->_getParam('store_id'))->where('search =?', 1)->where('draft =?', 1);
    $select->setIntegrityCheck(false)
            ->joinLeft($storeCrossPostTable, $storeCrossPostTable . '.receiver_store_id = ' . $table->info('name') . '.store_id || ' . $storeCrossPostTable . '.sender_store_id = ' . $table->info('name') . '.store_id');
    if (count($store_ids)) {
      $select->where('(' . $storeCrossPostTable . '.receiver_store_id NOT IN (' . implode(',', $store_ids) . ') AND ' . $storeCrossPostTable . '.sender_store_id NOT IN (' . implode(',', $store_ids) . ')) OR ' . $storeCrossPostTable . '.receiver_store_id IS NULL');
    }

    foreach ($table->fetchAll($select) as $store) {
      $user_icon_photo = $this->view->itemPhoto($store, 'thumb.icon');
      $sesdata[] = array(
          'id' => $store->store_id,
          'label' => $store->getTitle(),
          'photo' => $user_icon_photo
      );
    }
    return $this->_helper->json($sesdata);
  }

  public function createCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $store_id = $store->getIdentity();
    $crossStore = $this->_getParam('crossstore', 0);
    $crossPostTable = Engine_Api::_()->getItemTable('estore_crosspost');
    $crossPost = $crossPostTable->createRow();
    $crossPost->sender_store_id = $store_id;
    $crossPost->receiver_store_id = $crossStore;
    $crossPost->receiver_approved = 0;
    $crossPost->save();

    $crossStoreItem = Engine_Api::_()->getItem('stores', $crossStore);
    $postLink = '<a href="' . $this->view->absoluteUrl($this->view->url(array('store_id' => $crossStoreItem->custom_url, 'action' => 'cross-post', 'id' => $crossPost->getIdentity()), 'estore_dashboard', true)) . '">' . $store->getTitle() . '</a>';

    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($crossStoreItem->getOwner(), $store->getOwner(), $store, 'estore_crosspost_ctbs', array("postLink" => $postLink));

    $this->view->crosspost = Engine_Api::_()->getItemTable('estore_crosspost')->getCrossposts(array('store_id' => $store->getIdentity(), 'receiver_approved' => true));

    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function approveCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $crossStoreid = $this->_getParam('crossstore', 0);
    $crossStore = Engine_Api::_()->getItem('estore_crosspost', $crossStoreid);
    $crossStore->receiver_approved = 1;
    $crossStore->save();

    $storeItem = Engine_Api::_()->getItem('stores', $crossStore->sender_store_id);
    $postLink = '<a href="' . $this->view->absoluteUrl($this->view->url(array('store_id' => $storeItem->custom_url, 'action' => 'cross-post'), 'estore_dashboard', true)) . '">' . $storeItem->getTitle() . '</a>';
    //notification
    Engine_Api::_()->getDbTable('notifications', 'activity')->addNotification($store->getOwner(), $storeItem->getOwner(), $storeItem, 'estore_crosspost_apbs', array("postLink" => $postLink));

    $this->view->crosspost = Engine_Api::_()->getItemTable('estore_crosspost')->getCrossposts(array('store_id' => $store->getIdentity(), 'receiver_approved' => true));
    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function crossPostAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $id = $this->_getParam('id', '');
    if ($id) {
      $crossItem = Engine_Api::_()->getItem('estore_crosspost', $id);
      if ($crossItem) {
        if ($crossItem->receiver_approved == 0 && $crossItem->receiver_store_id == $store->getIdentity()) {
          $item = Engine_Api::_()->getItem('stores', $crossItem->sender_store_id);
          ;
          if ($item)
            $this->view->crosspoststore = $item;
          $this->view->crosspoststoreid = $id;
        }
      }
    }
    $this->view->crosspost = Engine_Api::_()->getItemTable('estore_crosspost')->getCrossposts(array('store_id' => $store->getIdentity(), 'receiver_approved' => true));
  }

  function manageNotificationAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    ;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $this->view->form = $form = new Estore_Form_Dashboard_Notification();

    if ($this->getRequest()->getPost() && $form->isValid($this->getRequest()->getPost())) {
      $dbGetInsert = Engine_Db_Table::getDefaultAdapter();
      $dbGetInsert->query("DELETE FROM engine4_estore_notifications WHERE user_id = " . $viewer->getIdentity() . ' AND store_id =' . $store->getIdentity());
      $values = $form->getValues();
      // Process
      $table = Engine_Api::_()->getDbTable('notifications', 'estore');
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        $values = $form->getValues();
        foreach ($values as $key => $value) {
          if ($key != "notification_type") {
            foreach ($value as $noti) {
              $this->createNotification($noti, $table, $store->getIdentity(), $viewer->getIdentity());
            }
          } else {
            $this->createNotification($value, $table, $store->getIdentity(), $viewer->getIdentity(), $key);
          }
        }
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }

    $notifications = Engine_Api::_()->getDbTable('notifications', 'estore')->getNotifications(array('store_id' => $store->getIdentity(), 'getAll' => true));
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

  function createNotification($val, $table, $store_id, $user_id, $key = "") {
    $noti = $table->createRow();
    $noti->store_id = $store_id;
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

  function deleteCrossPostAction() {
    $is_ajax = $this->view->is_ajax = true;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    $crossStoreid = $this->_getParam('crossstore', 0);
    $crossStore = Engine_Api::_()->getItem('estore_crosspost', $crossStoreid);

    if ($crossStore) {
      if ($crossStore->sender_store_id == $store->getIdentity() || $crossStore->receiver_store_id == $store->getIdentity()) {
        $crossStore->delete();
      } else {
        echo 0;
        die;
      }
    }

    $this->view->crosspost = Engine_Api::_()->getItemTable('estore_crosspost')->getCrossposts(array('store_id' => $store->getIdentity(), 'receiver_approved' => true));

    $this->renderScript('dashboard/cross-post.tpl');
  }

  public function postAttributionAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();

    $value = $this->_getParam('value', '');
    if (strlen($value)) {
      $res = Engine_Api::_()->getDbTable('postattributions', 'estore')->getStorePostAttribution(array('store_id' => $store->getIdentity(), 'return' => 1));
      if ($res) {
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      } else {
        $table = Engine_Api::_()->getDbTable('postattributions', 'estore');
        $res = $table->createRow();
        $res->store_id = $store->getIdentity();
        $res->user_id = $viewer->getIdentity();
        $res->type = $value;
        $res->save();
        echo 1;
        die;
      }
    }
    $this->view->attribution = Engine_Api::_()->getDbTable('postattributions', 'estore')->getStorePostAttribution(array('store_id' => $store->getIdentity()));
    $this->view->form = $form = new Estore_Form_Attribution(array('storeItem' => $store));
    $form->attribution->setValue($this->view->attribution);
  }

  public function contactAction() {
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $is_ajax_content = $this->view->is_ajax_content = $this->_getParam('is_ajax_content', null) ? $this->_getParam('is_ajax_content') : false;
    $this->view->store = $store = Engine_Api::_()->core()->getSubject();
    $viewer = $this->view->viewer();
    // Create form
    $this->view->form = $form = new Estore_Form_Dashboard_Contact();
    if (!empty($_SESSION['send_Mail'])) {
      $form->addNotice("Message send to members.");
      unset($_SESSION['send_Mail']);
    }
    if (!$this->getRequest()->isPost())
      return;
    // Not post/invalid
    if (!$this->getRequest()->isPost() || $is_ajax_content)
      return;
    if (!$form->isValid($this->getRequest()->getPost()) || $is_ajax_content)
      return;
    $values = $form->getValues();
    if ($values['type'] == 1) {
      $tableUser = Engine_Api::_()->getDbTable('users', 'user');
      $select = $store->membership()->getMembersObjectSelect();
      $fullMembers = $tableUser->fetchAll($select);
    } else {
      $userTable = Engine_Api::_()->getDbTable('users', 'user');
      $tableName = Engine_Api::_()->getDbTable('storeroles', 'estore')->info('name');
      $select = $userTable->select()->from($userTable);
      $select->where($userTable->info('name') . '.user_id IN (SELECT user_id FROM ' . $tableName . ' WHERE store_id = ' . $store->getIdentity() . ' AND memberrole_id IN (' . implode(',', $values['store_roles']) . '))');
      $fullMembers = $userTable->fetchAll($select);
    }

    foreach ($fullMembers as $member) {
      if ($member->user_id != $viewer->getIdentity()) {
        // Create conversation
        $conversation = Engine_Api::_()->getItemTable('messages_conversation')->send(
                $viewer, array($member->getIdentity()), str_replace('[store_title]', $store->getTitle(), $values['subject']), str_replace('[store_title]', $store->getTitle(), $values['message']), $store
        );

        Engine_Api::_()->getApi('mail', 'core')->sendSystem($member, 'estore_contact_member', array('subject' => str_replace('[store_title]', $store->getTitle(), $values['subject']), 'message' => str_replace('[store_title]', $store->getTitle(), $values['message']), 'object_link' => $this->view->absoluteUrl($store->getHref()), 'host' => $_SERVER['HTTP_HOST'], 'queue' => false));
      }
    }

    if (count($fullMembers)) {
      $_SESSION['send_Mail'] = true;
      $this->_helper->redirector->gotoRoute(array());
    }
  }

  public function upgradeAction() {
    if (!$this->_helper->requireUser()->isValid())
      return;
    $is_ajax = $this->view->is_ajax = $this->_getParam('is_ajax', null) ? $this->_getParam('is_ajax') : false;
    $this->view->store = $estore = Engine_Api::_()->core()->getSubject();
    //current package
    if (!empty($estore->orderspackage_id)) {
      $this->view->currentPackage = Engine_Api::_()->getItem('estorepackage_orderspackage', $estore->orderspackage_id);
      if (!$this->view->currentPackage) {
        $this->view->currentPackage = Engine_Api::_()->getItem('estorepackage_package', $estore->package_id);
        $price = $this->view->currentPackage->price;
      } else {
        $price = Engine_Api::_()->getItem('estorepackage_package', $this->view->currentPackage->package_id)->price;
      }
    } else {
      $this->view->currentPackage = array();
      $price = 0;
    }
    $this->view->viewer = $viewer = $this->view->viewer();
    //get upgrade packages
    $this->view->upgradepackage = Engine_Api::_()->getDbTable('packages', 'estorepackage')->getPackage(array('member_level' => $viewer->level_id, 'not_in_id' => $estore->package_id, 'price' => $price));
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

}
