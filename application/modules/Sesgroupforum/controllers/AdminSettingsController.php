<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_AdminSettingsController extends Core_Controller_Action_Admin {

  public function manageWidgetizePageAction() {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroup_admin_main', array(), 'sesgroup_admin_main_sesgroupforum');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupforum_admin_main', array(), 'sesgroupforum_admin_main_managepages');

    $this->view->pagesArray = array('sesgroupforum_topic_view','sesgroupforum_forum_topic-create','sesgroupforum_post_edit');
  }

  public function indexAction() {
  
    $db = Engine_Db_Table::getDefaultAdapter();
	
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroup_admin_main', array(), 'sesgroup_admin_main_sesgroupforum');

    $this->view->subNavigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupforum_admin_main', array(), 'sesgroupforum_admin_main_settings');
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesgroupforum_reputations\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesgroupforum.pluginactivated', 1);
    }
    
    $this->view->form = $form = new Sesgroupforum_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesgroupforum/controllers/License.php";
      
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesgroupforum.pluginactivated')) {
      
//         //START TEXT CHNAGE WORK IN CSV FILE
//         $oldSigularWord = $settings->getSetting('sesgroupforum.text.singular', 'forum');
//         $oldPluralWord = $settings->getSetting('sesgroupforum.text.plural', 'forums');
//         $newSigularWord = $values['sesgroupforum_text_singular'] ? $values['sesgroupforum_text_singular'] : 'forum';
//         $newPluralWord = $values['sesgroupforum_text_plural'] ? $values['sesgroupforum_text_plural'] : 'forums';
//         $newSigularWordUpper = ucfirst($newSigularWord);
//         $newPluralWordUpper = ucfirst($newPluralWord);
//         if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {
// 
//           $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesgroupforum.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
//           if( !empty($tmp['null']) && is_array($tmp['null']) )
//             $inputData = $tmp['null'];
//           else
//             $inputData = array();
// 
//           $OutputData = array();
//           $chnagedData = array();
//           foreach($inputData as $key => $input) {
//             $chnagedData = str_replace(array($oldPluralWord, $oldSigularWord,ucfirst($oldPluralWord),ucfirst($oldSigularWord),strtoupper($oldPluralWord),strtoupper($oldSigularWord)), array($newPluralWord, $newSigularWord, ucfirst($newPluralWord), ucfirst($newSigularWord), strtoupper($newPluralWord), strtoupper($newSigularWord)), $input);
//             $OutputData[$key] = $chnagedData;
//           }
// 
//           $targetFile = APPLICATION_PATH . '/application/languages/en/sesgroupforum.csv';
//           if (file_exists($targetFile))
//             @unlink($targetFile);
// 
//           touch($targetFile);
//           chmod($targetFile, 0777);
// 
//           $writer = new Engine_Translate_Writer_Csv($targetFile);
//           $writer->setTranslations($OutputData);
//           $writer->write();
//           //END CSV FILE WORK
//         }

        foreach ($values as $key => $value) {
          if($value != '')
          $settings->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  public function supportAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesgroupforum_admin_main', array(), 'sesgroupforum_admin_main_support');

  }
}
