<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Advancedsearch
 * @package    Advancedsearch
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Advancedsearch_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('advancedsearch_admin_main', array(), 'advancedsearch_admin_main_settings');

        $this->view->form = $form = new Advancedsearch_Form_Admin_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
            unset($values['defaulttext']);
            include_once APPLICATION_PATH . "/application/modules/Advancedsearch/controllers/License.php";
            if (Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedsearch.pluginactivated')) {
                foreach ($values as $key => $value) {
                if($value != '')
                Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
                }
                $form->addNotice('Your changes have been saved.');
                if($error)
                $this->_helper->redirector->gotoRoute(array());
            }
        }
    }
    function helpAction(){
        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('advancedsearch_admin_main', array(), 'advancedsearch_admin_main_help');

    }
    function manageAction(){
        if(!empty($_POST['order'])){
            $counter = 1;
            foreach($_POST['order'] as $order){
                $item = Engine_Api::_()->getItem('advancedsearch_modules',$order);
                if(!$item)
                    continue;
                $item->order = $counter;
                $item->save();
                $counter++;
            }
        }
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('advancedsearch_admin_main', array(), 'advancedsearch_admin_main_managemodule');
        $table = Engine_Api::_()->getDbTable('modules','advancedsearch');
        $select = $table->select()->order('order ASC');
        $this->view->paginator = $table->fetchAll($select);
    }
    function showOnSearchAction(){
        $id = $this->_getParam('id');
        $item = Engine_Api::_()->getItem('advancedsearch_modules',$id);
        $item->show_on_search = !$item->show_on_search;
        $item->save();
        header("Location:".$_SERVER["HTTP_REFERER"]);
    }
    function createTabAction(){
        $id = $this->_getParam('id');
        $item = Engine_Api::_()->getItem('advancedsearch_modules',$id);
        $item->create_tab = !$item->create_tab;
        $item->save();
        header("Location:".$_SERVER["HTTP_REFERER"]);
    }
    function editAction(){
        $this->view->form = $form = new Advancedsearch_Form_Admin_Edit();
        $this->_helper->layout->setLayout('admin-simple');
        $module = Engine_Api::_()->getItem('advancedsearch_modules',$this->_getParam('id'));
        $form->populate($module->toArray());
        if(!$this->getRequest()->isPost())
            return;
        if(!$form->isValid($this->_getAllParams())){
            return;
        }
        $module->setFromArray($form->getValues());
        $module->save();

        if(!empty($_FILES['photo']['name'])) {
            $file_ext = pathinfo($_FILES['photo']['name']);
            $file_ext = $file_ext['extension'];

            $storage = Engine_Api::_()->getItemTable('storage_file');
            $storageObject = $storage->createFile($form->photo, array(
                'parent_id' => $module->getIdentity(),
                'parent_type' => $module->getType(),
                'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
            ));
            // Remove temporary file
            $module->file_id = $storageObject->file_id;
            $module->save();
        }


        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('')
        ));

    }
  function addAction(){
      $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('advancedsearch_admin_main', array(), 'advancedsearch_admin_main_managemodule');
      $this->view->form = $form = new Advancedsearch_Form_Admin_Create();

      if(!$this->getRequest()->isPost())
          return;
      if(!$form->isValid($this->_getAllParams())){
          return;
      }

      $table = Engine_Api::_()->getDbTable('modules','advancedsearch');

      try{
        $row = $table->createRow();
          $values["resource_type"] = $_POST['content_type'];
          $values["resource_title"] = $_POST['module_title'];
          $values["module_name"] = $_POST['module_name'];
          $values["title"] =  $_POST['title'];
          $values["show_on_search"] = $_POST['show_on_search'];
          $values["create_tab"] = $_POST['create_tab'];

          $values["is_deleted"] = 1;
          $values["creation_date"] = date('Y-m-d H:i:s');
          $values["modified_date"] = date('Y-m-d H:i:s');
          //$values[""]
          $row->setFromArray($values);
          $row->save();

          if(!empty($_FILES['photo']['name'])) {
              $file_ext = pathinfo($_FILES['photo']['name']);
              $file_ext = $file_ext['extension'];

              $storage = Engine_Api::_()->getItemTable('storage_file');
              $storageObject = $storage->createFile($form->photo, array(
                  'parent_id' => $row->getIdentity(),
                  'parent_type' => $row->getType(),
                  'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
              ));
              // Remove temporary file
              $row->file_id = $storageObject->file_id;
              $row->save();
          }

          $row->order = $row->module_id;
          $row->save();
          return $this->_helper->redirector->gotoRoute(array('action' => 'manage','module'=>'advancedsearch','controller'=>'settings'),'admin_default',true);
      }catch (Exception $e){
          throw $e;
      }

  }
}
