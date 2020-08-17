<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfooter_admin_main', array(), 'sesfooter_admin_main_settings');
		$settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
    $settingsTableName = $settingsTable->info('name');
    $this->view->form = $form = new Sesfooter_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
			$values = $form->getValues();
			unset($values['footer_settings']);
			include_once APPLICATION_PATH . "/application/modules/Sesfooter/controllers/License.php";
			if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.pluginactivated')) {
			
				foreach ($values as $key => $value) {
				
				  if($key == 'ses_footer_width' || $key == 'ses_footer_background_color' || $key == 'ses_footer_border_color' || $key == 'ses_footer_headings_color' || $key == 'ses_footer_text_color' || $key == 'ses_footer_link_color' || $key == 'ses_footer_link_hover_color' || $key == 'ses_footer_button_color' || $key == 'ses_footer_button_hover_color' || $key == 'ses_footer_button_text_color' || $key == 'ses_footer_background_image') {
				    Engine_Api::_()->sesfooter()->readWriteXML($key, $value, '');
					} else {
					  if($key == 'sesfooter_licensekey' || $key == 'sesfooter_footerlogo' || $key == 'sesfooter_logintext') {
						  Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);

            } else {
              if(Engine_Api::_()->getApi('settings', 'core')->hasSetting($key)){
                Engine_Api::_()->getApi('settings', 'core')->removeSetting($key);
              }
              Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
// 							$columnVal = $settingsTable->select()
// 																		->from($settingsTableName, array('value'))
// 																		->where('name = ?', $key)
// 																		->query()
// 																		->fetchColumn();
// 	            if($columnVal) {
// 		            $db->query("UPDATE `engine4_core_settings` SET `value` = '$value' WHERE `engine4_core_settings`.`name` = '$key';");
// 	            } else {
// 		            $db->query("INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ('$key', '$value');");
// 	            }
						}
					}
				}
			
				//Clear scaffold cache
	      Core_Model_DbTable_Themes::clearScaffoldCache();
	      //Increment site counter
	      //$settings->core_site_counter = Engine_Api::_()->getApi('settings', 'core')->core_site_counter + 1;
			
				$form->addNotice('Your changes have been saved.');
				if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  //Enable Action
  public function enabledAction() {

    $id = $this->_getParam('managesearchoption_id');
    if (!empty($id)) {
      $item = Engine_Api::_()->getItem('sesfooter_managesearchoptions', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    $this->_redirect('admin/sesfooter/settings/manage-search');
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
  
  public function footerWidgetSet() {
  
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    //Footer Default Work
    $footerContent_id = $this->widgetCheck(array('widget_name' => 'sesfooter.footer', 'page_id' => '2'));
    $footerMenu = $this->widgetCheck(array('widget_name' => 'core.menu-footer', 'page_id' => '2'));
    $parent_content_id = $db->select()
	    ->from('engine4_core_content', 'content_id')
	    ->where('type = ?', 'container')
	    ->where('page_id = ?', '2')
	    ->where('name = ?', 'main')
	    ->limit(1)
	    ->query()
	    ->fetchColumn();
    if (empty($footerContent_id)) {
      if($footerMenu)
      $db->query('DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`content_id` = "'.$footerMenu.'";');
      $db->insert('engine4_core_content', array(
	  'type' => 'widget',
	  'name' => 'sesfooter.footer',
	  'page_id' => 2,
	  'parent_content_id' => $parent_content_id,
	  'order' => 10,
      ));
    }
  }
  
	
  
  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfooter_admin_main', array(), 'sesfooter_admin_main_typography');

    $this->view->form = $form = new Sesfooter_Form_Admin_Typography();
    
    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
    
      $values = $form->getValues(); 
      unset($values['sesfooter_heading']);
      unset($values['sesfooter_text']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfooter.pluginactivated')) {
        
        foreach ($values as $key => $value) {
        
          if($values['sesfooter_googlefonts']) {
            unset($values['sesfooter_heading_fontfamily']);
            unset($values['sesfooter_text_fontfamily']);

            unset($values['sesfooter_heading_fontsize']);
            unset($values['sesfooter_text_fontsize']);
              
            if($values['sesfooter_googleheading_fontfamily'])
              Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_heading_fontfamily', $values['sesfooter_googleheading_fontfamily']);
                            
            if($values['sesfooter_googleheading_fontsize'])
              Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_heading_fontsize', $values['sesfooter_googleheading_fontsize']);
              
            if($values['sesfooter_googletext_fontfamily'])
              Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_text_fontfamily', $values['sesfooter_googletext_fontfamily']);
              
            if($values['sesfooter_googletext_fontsize'])
              Engine_Api::_()->sesfooter()->readWriteXML('sesfooter_text_fontsize', $values['sesfooter_googletext_fontsize']);
              
            //Engine_Api::_()->sesfooter()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesfooter_googleheading_fontfamily']);
            unset($values['sesfooter_googletext_fontfamily']);

            unset($values['sesfooter_googleheading_fontsize']);
            unset($values['sesfooter_googletext_fontsize']);
            
            Engine_Api::_()->sesfooter()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
