<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_AdminSettingsController extends Core_Controller_Action_Admin
{

  public function manageWidgetizePageAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesforum_admin_main', array(), 'sesforum_admin_main_managepages');

    $this->view->pagesArray = array('sesforum_index_index', 'sesforum_category_view', 'sesforum_forum_view', 'sesforum_topic_view', 'sesforum_index_dashboard', 'sesforum_index_search','sesforum_index_tags','sesforum_forum_topic-create','sesforum_post_edit');
  }

  public function indexAction()
  {
	$db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation  = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('sesforum_admin_main', array(), 'sesforum_admin_main_settings');
    $settings = Engine_Api::_()->getApi('settings', 'core');
    
    $table_exist = $db->query('SHOW TABLES LIKE \'engine4_sesforum_reputations\'')->fetch();
    if($table_exist) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sesforum.pluginactivated', 1);
    }
    
    $this->view->form = $form = new Sesforum_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesforum/controllers/License.php";
      
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesforum.pluginactivated')) {
      
        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = $settings->getSetting('sesforum.text.singular', 'forum');
        $oldPluralWord = $settings->getSetting('sesforum.text.plural', 'forums');
        $newSigularWord = $values['sesforum_text_singular'] ? $values['sesforum_text_singular'] : 'forum';
        $newPluralWord = $values['sesforum_text_plural'] ? $values['sesforum_text_plural'] : 'forums';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesforum.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
          if( !empty($tmp['null']) && is_array($tmp['null']) )
            $inputData = $tmp['null'];
          else
            $inputData = array();

          $OutputData = array();
          $chnagedData = array();
          foreach($inputData as $key => $input) {
            $chnagedData = str_replace(array($oldPluralWord, $oldSigularWord,ucfirst($oldPluralWord),ucfirst($oldSigularWord),strtoupper($oldPluralWord),strtoupper($oldSigularWord)), array($newPluralWord, $newSigularWord, ucfirst($newPluralWord), ucfirst($newSigularWord), strtoupper($newPluralWord), strtoupper($newSigularWord)), $input);
            $OutputData[$key] = $chnagedData;
          }

          $targetFile = APPLICATION_PATH . '/application/languages/en/sesforum.csv';
          if (file_exists($targetFile))
            @unlink($targetFile);

          touch($targetFile);
          chmod($targetFile, 0777);

          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations($OutputData);
          $writer->write();
          //END CSV FILE WORK
        }
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

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesforum_admin_main', array(), 'sesforum_admin_main_support');

  }
}
