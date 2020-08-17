<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seswishe_admin_main', array(), 'seswishe_admin_main_settings');

    $this->view->form = $form = new Seswishe_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      unset($values['defaultwishe']);
      include_once APPLICATION_PATH . "/application/modules/Seswishe/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.pluginactivated')) {
      

        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.wishe.singular', 'wishe');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.wishe.plural', 'wishes');
        $newSigularWord = $values['seswishe_wishe_singular'] ? $values['seswishe_wishe_singular'] : 'wishe';
        $newPluralWord = $values['seswishe_wishe_plural'] ? $values['seswishe_wishe_plural'] : 'wishes';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {
        
          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/seswishe.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
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

          $targetFile = APPLICATION_PATH . '/application/languages/en/seswishe.csv';
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
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
          $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
  
  
  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seswishe_admin_main', array(), 'seswishe_admin_main_managepages');

    $this->view->pagesArray = array('seswishe_index_index', 'seswishe_index_manage', 'seswishe_index_view', 'seswishe_category_browse');
  }
}