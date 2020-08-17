<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageController.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_AdminManageController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestour_admin_main', array(), 'sestour_admin_main_manage');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('tours', 'sestour')->getTour();
    
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          Engine_Api::_()->getItem('sestour_tour', $value)->delete();
          //$db->query("DELETE FROM engine4_sestour_contents WHERE tour_id = " . $value);
        }
      }
    }
    
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }
  

  public function createTourAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', 0);
    $page_id = $this->_getParam('page_id', 0);

    $this->view->form = $form = new Sestour_Form_Admin_Tour_CreateTour();
    if ($id) {
      $form->setTitle("Edit This Tour");
      $form->submit->setLabel('Save Changes');
      $tour = Engine_Api::_()->getItem('sestour_tour', $id);
      $form->populate($tour->toArray());
    }
    
    if ($this->getRequest()->isPost()) {
    
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
        
      $db = Engine_Api::_()->getDbtable('tours', 'sestour')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('tours', 'sestour');
        $values = $form->getValues(); 
        
        
        
        if($values['page_id']) {
          $getPageInfo = Engine_Api::_()->sestour()->getPageInfo($values['page_id']);
          $values['name'] = $getPageInfo[0]['name'];
          $values['title'] = $getPageInfo[0]['displayname'];
        }
        if($page_id) {
          $values['page_id'] = $page_id;
        }
        
        if (!$id)
          $tour = $table->createRow();
        $tour->setFromArray($values);
        $tour->save();
        
        //delete all entry based on page_id
        if($id && $values['automaticopen'] == 'false') {
          $dbObject = Engine_Db_Table::getDefaultAdapter();
          $dbObject->query('DELETE FROM `engine4_sestour_userviews` WHERE `engine4_sestour_userviews`.`page_id` = "'.$page_id.'";');
        }

        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Gallery created successfully.')
      ));
    }
  }

  public function enabledAction() {

    $id = $this->_getParam('id');
    $tour_id = $this->_getParam('tour_id', 0);
    $page_id = $this->_getParam('page_id', 0);
    if (!empty($id)) {
      if(!empty($tour_id))
      $item = Engine_Api::_()->getItem('sestour_content', $id);
      else
      $item = Engine_Api::_()->getItem('sestour_tour', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if(!empty($tour_id))
    $this->_redirect('admin/sestour/manage/manage-widgets/id/'.$tour_id.'/page_id/'.$page_id);
    else
    $this->_redirect('admin/sestour/manage');
  }
  
  public function deletetourAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete This Tour Entry?');
    $form->setDescription('Are you sure that you want to delete this tour entry ? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      Engine_Api::_()->getItem('sestour_tour', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      //$db->query("DELETE FROM engine4_sestour_tours WHERE tour_id = " . $id);
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Tour Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage/delete-tour.tpl');
  }
  
  public function manageWidgetsAction() {
  
    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $content = Engine_Api::_()->getItem('sestour_content', $value);
          $content->delete();
        }
      }
    }
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestour_admin_main', array(), 'sestour_admin_main_manage');
    $this->view->tour_id = $id = $this->_getParam('id');
    $this->view->page_id = $page_id = $this->_getParam('page_id');
    if (!$id)
      return;
      
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('contents', 'sestour')->getContents($id, 'show_all');
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(1000);
    $paginator->setCurrentPageNumber($page);
  }
  
  public function createContentAction() {
  
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestour_admin_main', array(), 'sestour_admin_main_manage');
    
    $this->view->tour_id = $id = $this->_getParam('id');
    $this->view->page_id = $page_id = $this->_getParam('page_id');
    $this->view->content_id = $content_id = $this->_getParam('content_id', false);
    
    if (!$id)
      return;
      
    $this->view->form = $form = new Sestour_Form_Admin_Tour_CreateContent();
    
    if ($content_id) {
      //$form->setTitle("Edit HTML5 Video Background");
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Tour Tip Settings");
      $form->setDescription("Below, edit the details for content.");
      $content = Engine_Api::_()->getItem('sestour_content', $content_id);

      $form->populate($content->toArray());
    }
    
    if ($this->getRequest()->isPost()) {
    
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
        
      $db = Engine_Api::_()->getDbtable('contents', 'sestour')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('contents', 'sestour');
        $values = $form->getValues(); 

        if($values['widget_id']) {
          $getWidgeName = Engine_Api::_()->sestour()->getWidgeName($values['widget_id']);
          $values['widget_name'] = $getWidgeName;
          
          $checkWidgetInTabContanier = Engine_Api::_()->sestour()->checkWidgetInTabContanier($values['widget_id']);
          if($checkWidgetInTabContanier) {
            $values['classname'] = 'tab_layout_'.str_replace('-', "_", str_replace(".","_",$getWidgeName));
          } else {
            $values['classname'] = 'layout_'.str_replace('-', "_", str_replace(".","_",$getWidgeName));
          }
        } else {
          $values['widget_id'] = $content->widget_id;
        }

        if (!isset($content))
          $content = $table->createRow();
        $content->setFromArray($values);
				$content->save();
        $content->tour_id = $id;
        $content->save();
        $db->commit();
        $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sestour', 'controller' => 'manage', 'action' => 'manage-widgets', 'id' => $id, 'page_id' => $page_id), 'admin_default', true);
        header("Location:" . $url);
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function deleteContentAction() {
  
    $this->view->type = $this->_getParam('type', null);
    
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $content = Engine_Api::_()->getItem('sestour_content', $id);
      $content->delete();

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Content Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage/delete-content.tpl');
  }

  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $contentsTable = Engine_Api::_()->getDbtable('contents', 'sestour');
    $contents = $contentsTable->fetchAll($contentsTable->select());
    foreach ($contents as $content) {
      $order = $this->getRequest()->getParam('slide_' . $content->content_id);
      if (!$order)
        $order = 999;
      $content->order = $order;
      $content->save();
    }
    return;
  }
}