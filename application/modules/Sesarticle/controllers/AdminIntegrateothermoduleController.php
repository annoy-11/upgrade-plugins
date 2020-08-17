<?php

class Sesarticle_AdminIntegrateothermoduleController extends Core_Controller_Action_Admin {

  public function indexAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesarticle_admin_main', array(), 'sesarticle_admin_main_integrateothermodule');
    
    $this->view->enabledModules = Engine_Api::_()->getDbtable('modules', 'core')->getEnabledModuleNames();
    
    $select = Engine_Api::_()->getDbtable('integrateothermodules', 'sesarticle')->select();
    
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
  }
  
  //Add New Plugin entry
  public function addmoduleAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesarticle_admin_main', array(), 'sesarticle_admin_main_integrateothermodule');
    
    $this->view->form = $form = new Sesarticle_Form_Admin_Manage_Add();
    
    $this->view->type = $type = $this->_getParam('type');
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      $values = $form->getValues();
      $integrateothermoduleTable = Engine_Api::_()->getDbtable('integrateothermodules', 'sesarticle');
      
      $is_module_exists= $integrateothermoduleTable->fetchRow(array('content_type = ?' => $values['content_type'], 'module_name = ?' => $values['module_name']));
      
      if (!empty($is_module_exists)) {
        $error = Zend_Registry::get('Zend_Translate')->_("This Module already exist in our database.");
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
      }
			
      $contentTypeItem = Engine_Api::_()->getItemTable($values['content_type']);
      
      //get current content type item id
      $primaryId = current($contentTypeItem->info("primary"));
      
	  //get primary key for content type
      if (!empty($primaryId))
        $values['content_id'] = $primaryId;

      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      $dbInsert = Engine_Db_Table::getDefaultAdapter();
      try {
        $row = $integrateothermoduleTable->createRow();
        $values['type'] = $type;
        $row->setFromArray($values);
        $row->save();

        $modulename = $values['module_name'];
        $dbInsert->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `enabled`, `custom`, `order`) VALUES ("sesarticle_main_browsearticle_'.$row->getIdentity().'", "'.$modulename.'", "Browse Articles", "", \'{"route":"sesarticle_browsearticle_'.$row->getIdentity().'","action":"browse-articles", "resource_type":"'.$values['content_type'].'"}\', "'.$modulename.'_main", "", 1, 0, 999)');
        
        $this->createBrowseArticlePage($modulename, $row->getIdentity());
        
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
    }
  }
  
  function createBrowseArticlePage($modulename, $id) {
  
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    
    
    //Article Browse Page
    $page_id = $db->select()
      ->from('engine4_core_pages', 'page_id')
      ->where('name = ?', 'sesarticle_index_'.$id)
      ->limit(1)
      ->query()
      ->fetchColumn();
    // insert if it doesn't exist yet
    if( !$page_id ) {
      $widgetOrder = 1;
      // Insert page
      $db->insert('engine4_core_pages', array(
        'name' => 'sesarticle_index_'.$id,
        'displayname' => 'SES - Advanced Articles - '.ucfirst($modulename).' Articles Browse Page',
        'title' => ucfirst($modulename) .' Article Browse',
        'description' => 'This page lists articles.',
        'custom' => 0,
      ));
      $page_id = $db->lastInsertId();
      
      // Insert top
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => 1,
      ));
      $top_id = $db->lastInsertId();
      
      // Insert main
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => 2,
      ));
      $main_id = $db->lastInsertId();
      
      // Insert top-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
      ));
      $top_middle_id = $db->lastInsertId();
      
      // Insert main-middle
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 2,
      ));
      $main_middle_id = $db->lastInsertId();
      
      // Insert main-right
      $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => 1,
      ));
      $main_right_id = $db->lastInsertId();
      
      // Insert menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => $modulename.'.browse-menu',
        'page_id' => $page_id,
        'parent_content_id' => $top_middle_id,
        'order' => $widgetOrder++,
      ));
      
      // Insert gutter menu
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesarticle.browse-articles',
        'page_id' => $page_id,
        'parent_content_id' => $main_middle_id,
        'order' => $widgetOrder++,
        'params' => '{"enableTabs":["list","simplelist","advlist","grid","advgrid","supergrid","pinboard","map"],"openViewType":"advgrid","show_criteria":["verifiedLabel","favouriteButton","likeButton","socialSharing","like","favourite","comment","ratingStar","rating","view","title","category","by","readmore","creationDate","location","descriptionlist","descriptiongrid","descriptionpinboard","descriptionsimplelist","descriptionadvlist","descriptionadvgrid","descriptionsupergrid","enableCommentPinboard"],"sort":"recentlySPcreated","show_item_count":"1","title_truncation_list":"100","title_truncation_grid":"100","title_truncation_pinboard":"30","title_truncation_simplelist":"45","title_truncation_advlist":"45","title_truncation_advgrid":"45","title_truncation_supergrid":"45","description_truncation_list":"300","description_truncation_grid":"150","description_truncation_pinboard":"150","description_truncation_simplelist":"150","description_truncation_advlist":"150","description_truncation_advgrid":"150","description_truncation_supergrid":"200","height_list":"230","width_list":"461","height_grid":"270","width_grid":"307","height_simplelist":"230","width_simplelist":"260","height_advgrid":"230","width_advgrid":"461","height_supergrid":"250","width_supergrid":"461","width_pinboard":"280","limit_data_pinboard":"12","limit_data_grid":"12","limit_data_list":"12","limit_data_simplelist":"12","limit_data_advlist":"12","limit_data_advgrid":"12","limit_data_supergrid":"12","pagging":"button","title":"","nomobile":"0","name":"sesarticle.browse-articles"}',
      ));

      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesarticle.browse-search',
        'page_id' => $page_id,
        'parent_content_id' => $main_right_id,
        'order' => $widgetOrder++,
        'params' => '{"view_type":"vertical","search_type":["recentlySPcreated","mostSPviewed","mostSPliked","mostSPcommented","mostSPfavourite","mostSPrated","featured","sponsored","verified"],"default_search_type":"recentlySPcreated","friend_show":"yes","search_title":"yes","browse_by":"yes","categories":"yes","location":"yes","kilometer_miles":"yes","has_photo":"yes","title":"","nomobile":"0","name":"sesarticle.browse-search"}',
      ));
    }
  }

  //Delete entry
  public function deleteAction() {
  
    $this->_helper->layout->setLayout('admin-simple');
    
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
      
        $inttable = Engine_Api::_()->getItem('sesarticle_integrateothermodule', $this->_getParam('integrateothermodule_id'));
        $pageName = "sesarticle_index_".$this->_getParam('integrateothermodule_id');
        if (!empty($pageName)) {
          $page_id = $db->select()
                  ->from('engine4_core_pages', 'page_id')
                  ->where('name = ?', $pageName)
                  ->limit(1)
                  ->query()
                  ->fetchColumn();
          if($page_id) {
            Engine_Api::_()->getDbTable('content', 'core')->delete(array('page_id =?' => $page_id));
            Engine_Api::_()->getDbTable('pages', 'core')->delete(array('page_id =?' => $page_id));
          }
        }
        Engine_Api::_()->getDbtable('menuItems', 'core')->delete(array('name =?' => 'sesarticle_main_browsearticle_' . $this->_getParam('integrateothermodule_id')));
      
        $integrateothermodule = Engine_Api::_()->getItem('sesarticle_integrateothermodule', $this->_getParam('integrateothermodule_id'));
        $integrateothermodule->delete();
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
    $this->renderScript('admin-integrateothermodule/delete.tpl');
  }

  //Enable / Disable Action
  public function enabledAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    $content = Engine_Api::_()->getItemTable('sesarticle_integrateothermodule')->fetchRow(array('integrateothermodule_id = ?' => $this->_getParam('integrateothermodule_id')));
    try {
      
      Engine_Api::_()->getDbtable('menuItems', 'core')->update(array('enabled' => !$content->enabled), array('name =?' => 'sesarticle_main_browsearticle_' . $this->_getParam('integrateothermodule_id')));
    
      $content->enabled = !$content->enabled;
      $content->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    return $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }
}