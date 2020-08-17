<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Einstaclone
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AdminSettingsController.php 2019-12-30 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Einstaclone_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_settings');

    $this->view->form = $form = new Einstaclone_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
    
      $values = $form->getValues();
      
      include_once APPLICATION_PATH . "/application/modules/Einstaclone/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.pluginactivated')) {

        if (@$values['einstaclone_changelanding']) {
          $this->landingpageSet();
        }
        if (@$values['einstaclone_changememberhome']) {
          $this->memberHomePageSet();
        }
        if (@$values['einstaclone_changememberprofile']) {
          $this->memberProfilePageSet();
        }
        
        if(@$values['einstaclone_header_fixed_layout'])
          Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_header_fixed_layout', @$values['einstaclone_header_fixed_layout']);

        //Default settings
        $this->defaultInstallation();

        foreach ($values as $key => $value) {
          if (Engine_Api::_()->getApi('settings', 'core')->hasSetting($key, $value))
              Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
          if (!$value && strlen($value) == 0)
              continue;
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function supportAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_support');
  }
  
  public function stylingAction() {
  
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', 1);

    $this->view->form = $form = new Einstaclone_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $db = Engine_Db_Table::getDefaultAdapter();
      
      $values = $form->getValues();
      unset($values['header_settings']);
      unset($values['footer_settings']);
      unset($values['body_settings']);
      unset($values['custom_themes']);
      $theme_id = $values['theme_color'];
      
      foreach ($values as $key => $value) {
      
        if (isset($_POST['save'])) {
          Engine_Api::_()->einstaclone()->readWriteXML($key, $value, '');
        }

        if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['theme_color'] > '3') {
          foreach($values as $key => $value) {
            $db->query("UPDATE `engine4_einstaclone_customthemes` SET `value` = '".$value."' WHERE `engine4_einstaclone_customthemes`.`theme_id` = '".$theme_id."' AND  `engine4_einstaclone_customthemes`.`column_key` = '".$key."';");
          }
        }
      }
      
      //Clear scaffold cache
      Core_Model_DbTable_Themes::clearScaffoldCache();

      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array('module' => 'einstaclone', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['theme_color']),'admin_default',true);
    }
    $this->view->activatedTheme = Engine_Api::_()->einstaclone()->getContantValueXML('theme_color');
  }

  public function addCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    
    $customtheme_id = $this->_getParam('customtheme_id', 0);
    
    $this->view->form = $form = new Einstaclone_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme_id = $customtheme_id + 1;
      $customtheme = Engine_Api::_()->getItem('einstaclone_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    
    if ($this->getRequest()->isPost()) {
    
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      
      $table = Engine_Api::_()->getDbtable('customthemes', 'einstaclone');
      
      $db = $table->getAdapter();
      $db->beginTransaction();
      try {
        
        $values = $form->getValues();

        if(!$customtheme_id) {
            $customtheme = $table->createRow();
            $customtheme->setFromArray($values);
            $customtheme->save();

            $theme_id = $customtheme->customtheme_id;

            if(!empty($values['customthemeid'])) {

                $dbInsert = Engine_Db_Table::getDefaultAdapter();

                $getThemeValues = $table->getThemeValues(array('customtheme_id' => $values['customthemeid']));
                foreach($getThemeValues as $key => $value) {
                    $dbInsert->query("INSERT INTO `engine4_einstaclone_customthemes` (`name`, `value`, `column_key`,`default`,`theme_id`) VALUES ('".$values['name']."','".$value->value."','".$value->column_key."','1','".$theme_id."') ON DUPLICATE KEY UPDATE `value`='".$value->value."';");
                }
                $db->query("UPDATE `engine4_einstaclone_customthemes` SET `value` = '" . $theme_id . "' WHERE theme_id = " . $theme_id . " AND column_key = 'custom_theme_color';");
                $db->query('DELETE FROM `engine4_einstaclone_customthemes` WHERE `engine4_einstaclone_customthemes`.`theme_id` = "0";');
            }
        } else if(!empty($customtheme_id)) {
          $theme_id = $customtheme_id = $customtheme_id - 1;
          $db->query("UPDATE `engine4_einstaclone_customthemes` SET `name` = '" . $values['name'] . "' WHERE theme_id = " . $customtheme_id);
        }
        $db->commit();
        if(!$customtheme_id) {
          $message = array('New Custom theme created successfully.');
        } else {
          $message = array('New Custom theme edited successfully.');
        }
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'einstaclone', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $theme_id),'admin_default',true),
          'messages' => $message,
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function deleteCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->customtheme_id = $customtheme_id = $this->_getParam('customtheme_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      try {
        $dbQuery = Zend_Db_Table_Abstract::getDefaultAdapter();
        $dbQuery->query("DELETE FROM engine4_einstaclone_customthemes WHERE theme_id = ".$customtheme_id);
        $db->commit();
        $activatedTheme = Engine_Api::_()->einstaclone()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'einstaclone', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
          'messages' => array('You have successfully delete custom theme.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    } else {
      $this->renderScript('admin-settings/delete-custom-theme.tpl');
    }
  }
  
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', null);
    if(empty($customtheme_id))
      return;
    
    if(in_array($customtheme_id, array(1,2,3)))
      $default = 0;
    else
      $default = 1;
      
    $themecustom = Engine_Api::_()->getDbTable('customthemes', 'einstaclone')->getThemeKey(array('theme_id'=>$customtheme_id, 'default' => $default));
    $customthecolorArray = array();
    foreach($themecustom as $value) {
      $customthecolorArray[] = $value['column_key'].'||'.$value['value'];
    }
    echo json_encode($customthecolorArray);die;
  }

  public function widgetCheck($params = array()) {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    return $db->select()
              ->from('engine4_core_content', 'content_id')
              ->where('type = ?', 'widget')
              ->where('page_id = ?', $params['page_id'])
              ->where('name = ?', $params['widget_name'])
              ->limit(1)
              ->query()
              ->fetchColumn();
  }
  
  public function landingpageSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    // Get page param
    $pageTable = Engine_Api::_()->getDbtable('pages', 'core');
    $contentTable = Engine_Api::_()->getDbtable('content', 'core');
    
    // Make new page
    $pageObject = $pageTable->createRow();
    $pageObject->displayname = "SES - Insta Clone - Landing Page Backup";
    $pageObject->provides = 'no-subject';
    $pageObject->save();
    $new_page_id = $pageObject->page_id;
    
    $old_page_content = $db->select()
        ->from('engine4_core_content')
        ->where('`page_id` = ?', 3)
        ->order(array('type', 'content_id'))
        ->query()
        ->fetchAll();
    
    $content_count = count($old_page_content);
    for($i = 0; $i < $content_count; $i++){
      $contentRow = $contentTable->createRow();
      $contentRow->page_id = $new_page_id;
      $contentRow->type = $old_page_content[$i]['type'];
      $contentRow->name = $old_page_content[$i]['name'];
      if( $old_page_content[$i]['parent_content_id'] != null ) {
        $contentRow->parent_content_id = $content_id_array[$old_page_content[$i]['parent_content_id']];            
      }
      else{
        $contentRow->parent_content_id = $old_page_content[$i]['parent_content_id'];
      }
      $contentRow->order = $old_page_content[$i]['order'];
      $contentRow->params = $old_page_content[$i]['params'];
      $contentRow->attribs = $old_page_content[$i]['attribs'];
      $contentRow->save();
      $content_id_array[$old_page_content[$i]['content_id']] = $contentRow->content_id;
    }

    $widgetOrder = 1;
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` = "3";');

    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => 3,
        'order' => 1,
    ));
    $mainId = $db->lastInsertId();

    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => 3,
        'parent_content_id' => $mainId,
        'order' => 2,
    ));
    $mainMiddleId = $db->lastInsertId();
    
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'einstaclone.landing-page',
      'page_id' => 3,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
      'params' => '{"socialloginbutton":"1","title":"","nomobile":"0","name":"einstaclone.landing-page"}',
    ));
  }
  
  public function memberHomePageSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    // Get page param
    $pageTable = Engine_Api::_()->getDbtable('pages', 'core');
    $contentTable = Engine_Api::_()->getDbtable('content', 'core');
    
    // Make new page
    $pageObject = $pageTable->createRow();
    $pageObject->displayname = "Member Home Page Backup for InstaClone Theme";
    $pageObject->provides = 'no-subject';
    $pageObject->save();
    $new_page_id = $pageObject->page_id;
    
    $old_page_content = $db->select()
        ->from('engine4_core_content')
        ->where('`page_id` = ?', 4)
        ->order(array('type', 'content_id'))
        ->query()
        ->fetchAll();
    
    $content_count = count($old_page_content);
    for($i = 0; $i < $content_count; $i++){
      $contentRow = $contentTable->createRow();
      $contentRow->page_id = $new_page_id;
      $contentRow->type = $old_page_content[$i]['type'];
      $contentRow->name = $old_page_content[$i]['name'];
      if( $old_page_content[$i]['parent_content_id'] != null ) {
        $contentRow->parent_content_id = $content_id_array[$old_page_content[$i]['parent_content_id']];            
      }
      else{
        $contentRow->parent_content_id = $old_page_content[$i]['parent_content_id'];
      }
      $contentRow->order = $old_page_content[$i]['order'];
      $contentRow->params = $old_page_content[$i]['params'];
      $contentRow->attribs = $old_page_content[$i]['attribs'];
      $contentRow->save();
      $content_id_array[$old_page_content[$i]['content_id']] = $contentRow->content_id;
    }

    $widgetOrder = 3;
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` = "4";');

    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => 4,
        'order' => 2,
    ));
    $mainId = $db->lastInsertId();
    
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'right',
        'page_id' => 4,
        'parent_content_id' => $mainId,
        'order' => 3,
    ));
    $mainRightId = $db->lastInsertId();
    
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => 4,
        'parent_content_id' => $mainId,
        'order' => 4,
    ));
    $mainMiddleId = $db->lastInsertId();

    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => 4,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"title":"What\'s New","design":"2","upperdesign":"0","enablestatusbox":"2","feeddesign":"1","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
      ));
    } else {
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'activity.feed',
        'page_id' => 4,
        'parent_content_id' => $mainMiddleId,
        'order' => $widgetOrder++,
        'params' => '{"title":"What\'s New"}',
      ));
    }

    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'einstaclone.home-photo',
      'page_id' => 4,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'einstaclone.suggested-members',
      'page_id' => 4,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"limit":"5","title":"Suggested Members","nomobile":"0","name":"einstaclone.suggested-members"}',
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'activity.list-requests',
      'page_id' => 4,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Requests"}',
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'core.hashtags-cloud',
      'page_id' => 4,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
      'params' => '{"tag_count":"10","title":"Trending Hashtags","nomobile":"0","name":"core.hashtags-cloud"}',
    ));
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'einstaclone.sidebar-footer',
      'page_id' => 4,
      'parent_content_id' => $mainRightId,
      'order' => $widgetOrder++,
    ));
  }
  
  public function memberProfilePageSet() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    // Get page param
    $pageTable = Engine_Api::_()->getDbtable('pages', 'core');
    $contentTable = Engine_Api::_()->getDbtable('content', 'core');
    
    // Make new page
    $pageObject = $pageTable->createRow();
    $pageObject->displayname = "Member Profile Page Backup for InstaClone Theme";
    $pageObject->provides = 'no-subject';
    $pageObject->save();
    $new_page_id = $pageObject->page_id;
    
    $old_page_content = $db->select()
        ->from('engine4_core_content')
        ->where('`page_id` = ?', 5)
        ->order(array('type', 'content_id'))
        ->query()
        ->fetchAll();
    
    $content_count = count($old_page_content);
    for($i = 0; $i < $content_count; $i++){
      $contentRow = $contentTable->createRow();
      $contentRow->page_id = $new_page_id;
      $contentRow->type = $old_page_content[$i]['type'];
      $contentRow->name = $old_page_content[$i]['name'];
      if( $old_page_content[$i]['parent_content_id'] != null ) {
        $contentRow->parent_content_id = $content_id_array[$old_page_content[$i]['parent_content_id']];            
      }
      else{
        $contentRow->parent_content_id = $old_page_content[$i]['parent_content_id'];
      }
      $contentRow->order = $old_page_content[$i]['order'];
      $contentRow->params = $old_page_content[$i]['params'];
      $contentRow->attribs = $old_page_content[$i]['attribs'];
      $contentRow->save();
      $content_id_array[$old_page_content[$i]['content_id']] = $contentRow->content_id;
    }

    $widgetOrder = 3;
    $pageId = 5;
    $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` = "'.$pageId.'";');

    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $pageId,
        'order' => 2,
    ));
    $mainId = $db->lastInsertId();
    
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $pageId,
        'parent_content_id' => $mainId,
        'order' => 4,
    ));
    $mainMiddleId = $db->lastInsertId();
    
    $db->insert('engine4_core_content', array(
      'type' => 'widget',
      'name' => 'einstaclone.member-profile-user-info',
      'page_id' => $pageId,
      'parent_content_id' => $mainMiddleId,
      'order' => $widgetOrder++,
    ));
    
    // middle tab container column
    $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'core.container-tabs',
      'parent_content_id' => $mainMiddleId,
      'order' => 5,
      'params' => '{"max":"6"}',
    ));
    $tabId = $db->lastInsertId('engine4_core_content');

    // tabs widgets
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesadvancedactivity')) {
      $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesadvancedactivity.feed',
        'page_id' => 4,
        'parent_content_id' => $tabId,
        'order' => $widgetOrder++,
        'params' => '{"title":"Updates","design":"2","upperdesign":"0","enablestatusbox":"2","feeddesign":"2","sesact_pinboard_width":"300","scrollfeed":"1","autoloadTimes":"3","statusplacehoder":"Post Something...","userphotoalign":"left","enablefeedbgwidget":"1","feedbgorder":"random","enablewidthsetting":"0","sesact_image1":null,"sesact_image1_width":"500","sesact_image1_height":"450","sesact_image2":null,"sesact_image2_width":"289","sesact_image2_height":"200","sesact_image3":null,"sesact_image3_bigwidth":"328","sesact_image3_bigheight":"300","sesact_image3_smallwidth":"250","sesact_image3_smallheight":"150","sesact_image4":null,"sesact_image4_bigwidth":"578","sesact_image4_bigheight":"300","sesact_image4_smallwidth":"192","sesact_image4_smallheight":"100","sesact_image5":null,"sesact_image5_bigwidth":"289","sesact_image5_bigheight":"260","sesact_image5_smallwidth":"289","sesact_image5_smallheight":"130","sesact_image6":null,"sesact_image6_width":"289","sesact_image6_height":"150","sesact_image7":null,"sesact_image7_bigwidth":"192","sesact_image7_bigheight":"150","sesact_image7_smallwidth":"144","sesact_image7_smallheight":"150","sesact_image8":null,"sesact_image8_width":"144","sesact_image8_height":"150","sesact_image9":null,"sesact_image9_width":"192","sesact_image9_height":"150","nomobile":"0","name":"sesadvancedactivity.feed"}',
      ));
    } else {
      $db->insert('engine4_core_content', array(
        'page_id' => $pageId,
        'type' => 'widget',
        'name' => 'activity.feed',
        'parent_content_id' => $tabId,
        'order' => $widgetOrder++,
      ));
    }
    $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'einstaclone.member-profile-photos',
      'parent_content_id' => $tabId,
      'order' => $widgetOrder++,
      'params' => '{"paginationType":"1","limit":"18","title":"Photos","nomobile":"0","name":"einstaclone.member-profile-photos"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'einstaclone.member-tagged-photos',
      'parent_content_id' => $tabId,
      'order' => $widgetOrder++,
      'params' => '{"paginationType":"1","limit":"18","title":"Tagged Photos","nomobile":"0","name":"einstaclone.member-tagged-photos"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'user.profile-fields',
      'parent_content_id' => $tabId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Info","name":"user.profile-fields"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'user.profile-friends-followers',
      'parent_content_id' => $tabId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Followers","titleCount":true,"name":"user.profile-friends-followers","itemCountPerPage":"15"}',
    ));
    $db->insert('engine4_core_content', array(
      'page_id' => $pageId,
      'type' => 'widget',
      'name' => 'user.profile-friends-following',
      'parent_content_id' => $tabId,
      'order' => $widgetOrder++,
      'params' => '{"title":"Following","titleCount":true,"name":"user.profile-friends-following","itemCountPerPage":"15"}',
    ));
    
    if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('video')) {
      $db->insert('engine4_core_content', array(
        'page_id' => $pageId,
        'type' => 'widget',
        'name' => 'video.profile-videos',
        'parent_content_id' => $tabId,
        'order' => $widgetOrder++,
        'params' => '{"title":"Videos","titleCount":true}',
      ));
    }
  }

  public function manageSearchAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_search');

    $availableTypes = Engine_Api::_()->getApi('search', 'core')->getAvailableTypes();
    if (is_array($availableTypes) && count($availableTypes) > 0) {
      $options = array();
      foreach ($availableTypes as $index => $type) {
        $options[$type] = $ITEM_TYPE = strtoupper('ITEM_TYPE_' . $type);
        $hasType = Engine_Api::_()->getDbTable('managesearchoptions', 'einstaclone')->hasType(array('type' => $type));
        if (!$hasType) {
          $db->query("INSERT IGNORE INTO `engine4_einstaclone_managesearchoptions` (`type`, `title`, `file_id`, `enabled`, `order`) VALUES ('" . $type . "', '" . $ITEM_TYPE . "', '', 1, NULL);");
        }
      }
    }
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->getAllSearchOptions = Engine_Api::_()->getDbTable('managesearchoptions', 'einstaclone')->getAllSearchOptions();
  }

   public function enabledAction() {

    $id = $this->_getParam('managesearchoption_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('einstaclone_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/einstaclone/settings/manage-search');
  }

  public function editSearchAction() {

    $this->_helper->layout->setLayout('admin-simple');

    $id = $this->_getParam('id', null);

    $type = $this->_getParam('type', null);

    $db = Engine_Db_Table::getDefaultAdapter();
    $managesearchoptions = Engine_Api::_()->getItem('einstaclone_managesearchoptions', $id);

    $select = new Zend_Db_Select($db);
    $menu = $select->from('engine4_einstaclone_managesearchoptions')
            ->where('managesearchoption_id = ?', $id)
            ->query()
            ->fetchObject();

    $this->view->form = $form = new Einstaclone_Form_Admin_EditSearch();
    $translate = Zend_Registry::get('Zend_Translate');
    if ($managesearchoptions->title)
      $form->title->setValue($translate->translate($managesearchoptions->title));

    if ($this->getRequest()->isPost()) {

      if (isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {

        $photoFile = Engine_Api::_()->einstaclone()->setPhotoIcons($_FILES['photo'], $id);
        if (!empty($photoFile->file_id)) {
          $previous_file_id = $menu->file_id;
          $db->update('engine4_einstaclone_managesearchoptions', array('file_id' => $photoFile->file_id, 'title' => $_POST['title']), array('managesearchoption_id = ?' => $id));
          $file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
          if (!empty($file))
            $file->delete();
        }
      }

      $redirectUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'einstaclone', 'controller' => 'settings', 'action' => 'manage-search'), 'admin_default', true);
      return $this->_forward('success', 'utility', 'core', array(
                  'parentRedirect' => $redirectUrl,
                  'messages' => '',
      ));
    }
  }
  public function deleteSearchIconAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->id = $id = $this->_getParam('id', 0);
    $this->view->file_id = $file_id = $this->_getParam('file_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $mainMenuIcon = Engine_Api::_()->getItemTable('storage_file')->getFile($file_id);
        $mainMenuIcon->delete();
        $db->update('engine4_einstaclone_managesearchoptions', array('file_id' => 0), array('managesearchoption_id = ?' => $id,
        ));
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('')
      ));
    }
    $this->renderScript('admin-settings/delete-search-icon.tpl');
  }

  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('einstaclone_admin_main', array(), 'einstaclone_admin_main_typography');

    $this->view->form = $form = new Einstaclone_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['einstaclone_body']);
      unset($values['einstaclone_heading']);
      unset($values['einstaclone_mainmenu']);
      unset($values['einstaclone_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['einstaclone_googlefonts']) {
            unset($values['einstaclone_body_fontfamily']);
            unset($values['einstaclone_heading_fontfamily']);
            unset($values['einstaclone_mainmenu_fontfamily']);
            unset($values['einstaclone_tab_fontfamily']);

            unset($values['einstaclone_body_fontsize']);
            unset($values['einstaclone_heading_fontsize']);
            unset($values['einstaclone_mainmenu_fontsize']);
            unset($values['einstaclone_tab_fontsize']);

            if($values['einstaclone_googlebody_fontfamily'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_body_fontfamily', $values['einstaclone_googlebody_fontfamily']);

            if($values['einstaclone_googlebody_fontsize'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_body_fontsize', $values['einstaclone_googlebody_fontsize']);

            if($values['einstaclone_googleheading_fontfamily'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_heading_fontfamily', $values['einstaclone_googleheading_fontfamily']);

            if($values['einstaclone_googleheading_fontsize'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_heading_fontsize', $values['einstaclone_googleheading_fontsize']);

            if($values['einstaclone_googlemainmenu_fontfamily'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_mainmenu_fontfamily', $values['einstaclone_googlemainmenu_fontfamily']);

            if($values['einstaclone_googlemainmenu_fontsize'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_mainmenu_fontsize', $values['einstaclone_googlemainmenu_fontsize']);

            if($values['einstaclone_googletab_fontfamily'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_tab_fontfamily', $values['einstaclone_googletab_fontfamily']);

            if($values['einstaclone_googletab_fontsize'])
              Engine_Api::_()->einstaclone()->readWriteXML('einstaclone_tab_fontsize', $values['einstaclone_googletab_fontsize']);

            //Engine_Api::_()->einstaclone()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['einstaclone_googlebody_fontfamily']);
            unset($values['einstaclone_googleheading_fontfamily']);
            unset($values['einstaclone_googleheading_fontfamily']);
            unset($values['einstaclone_googletab_fontfamily']);

            unset($values['einstaclone_googlebody_fontsize']);
            unset($values['einstaclone_googleheading_fontsize']);
            unset($values['einstaclone_googlemainmenu_fontsize']);
            unset($values['einstaclone_googletab_fontsize']);

            Engine_Api::_()->einstaclone()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  
  public function defaultInstallation() {
    
    $db = Engine_Db_Table::getDefaultAdapter();
    
    //Here we have set the value of theme active.
    $themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('einstaclone.themeactive');
    if (empty($themeactive)) {

      $db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('einstaclone', 'Professional Insta Clone', '', 0)");
      
      $themeTable = Engine_Api::_()->getDbtable('themes', 'core');
      $themeSelect = $themeTable->select()
                      ->orWhere('theme_id = ?', 'einstaclone')
                      ->orWhere('name = ?', 'einstaclone')
                      ->limit(1);
      $theme = $themeTable->fetchRow($themeSelect);
      if ($theme) {
          $db = $themeTable->getAdapter();
          $db->beginTransaction();
          try {
              $themeTable->update(array('active' => 0), array('1 = ?' => 1));
              $theme->active = true;
              $theme->save();
              // clear scaffold cache
              Core_Model_DbTable_Themes::clearScaffoldCache();
              // Increment site counter
              $settings = Engine_Api::_()->getApi('settings', 'core');
              $settings->core_site_counter = $settings->core_site_counter + 1;
              $db->commit();
          } catch (Exception $e) {
              $db->rollBack();
              throw $e;
          }
      }
      Engine_Api::_()->getApi('settings', 'core')->setSetting('einstaclone.themeactive', 1);
    }

    //Start Make extra file for custom css for theme
    $themeDirName = APPLICATION_PATH . '/application/themes/einstaclone';
    @chmod($themeDirName, 0777);
    if (!is_readable($themeDirName)) {
      $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
      $form->addError($itemError);
      return;
    }
    $fileName = $themeDirName . '/einstaclone-custom.css';
    $fileexists = @file_exists($fileName);
    if (empty($fileexists)) {
      @chmod($themeDirName, 0777);
      if (!is_writable($themeDirName)) {
        $itemError = Zend_Registry::get('Zend_Translate')->_("You have not writable permission on below file path. So, please give chmod 777 recursive permission to continue this process. <br /> Path Name: $themeDirName");
        $form->addError($itemError);
        return;
      }
      $fh = @fopen($fileName, 'w');
      @fwrite($fh, '/* ADD YOUR CUSTOM CSS HERE */');
      @chmod($fileName, 0777);
      @fclose($fh);
      @chmod($fileName, 0777);
      @chmod($fileName, 0777);
    }
  }
}
