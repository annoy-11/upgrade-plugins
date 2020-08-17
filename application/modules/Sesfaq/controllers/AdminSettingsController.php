<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfaq_admin_main', array(), 'sesfaq_admin_main_settings');

    $this->view->form = $form = new Sesfaq_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      include_once APPLICATION_PATH . "/application/modules/Sesfaq/controllers/License.php";
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $form->getValues();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfaq.pluginactivated')) {

        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfaq.text.singular', 'faq');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesfaq.text.plural', 'faqs');
        $newSigularWord = @$values['sesfaq_text_singular'] ? @$values['sesfaq_text_singular'] : 'faq';
        $newPluralWord = @$values['sesfaq_text_plural'] ? @$values['sesfaq_text_plural'] : 'faqs';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesfaq.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
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

          $targetFile = APPLICATION_PATH . '/application/languages/en/sesfaq.csv';
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
          if ($key == 'sesfaq_link') {
            $menu_table = Engine_Api::_()->getDbtable('menuitems', 'core');
            if ($value == 1) {
              $menu_table->update(array('menu' => 'core_footer', 'enabled' => 1), array('name =?' => 'sesfaq_footer_sesfaq'));
              $menu_table->update(array('menu' => 'core_main',  'enabled' => 0), array('name =?' => 'core_main_sesfaq'));
              $menu_table->update(array('menu' => 'core_mini', 'enabled' => 0), array('name =?' => 'sesfaq_mini_sesfaq'));
            }else if ($value == 3){
              $menu_table->update(array('menu' => 'core_main','enabled' => 1), array('name =?' => 'core_main_sesfaq'));
              $menu_table->update(array('menu' => 'core_mini','enabled' => 0), array('name =?' => 'sesfaq_mini_sesfaq'));
              $menu_table->update(array('menu' => 'core_footer','enabled' =>0), array('name =?' => 'sesfaq_footer_sesfaq'));
            }else if ($value == 2){
              $menu_table->update(array('menu' => 'core_mini', 'enabled' => 1), array('name =?' => 'sesfaq_mini_sesfaq'));
              $menu_table->update(array('menu' => 'core_footer', 'enabled' => 0), array('name =?' => 'sesfaq_footer_sesfaq'));
              $menu_table->update(array('menu' => 'core_main','enabled' => 0), array('name =?' => 'core_main_sesfaq'));
            }else if ($value == 0){
              $menu_table->update(array('enabled' => 0), array('name =?' => 'sesfaq_mini_sesfaq'));
              $menu_table->update(array('enabled' => 0), array('name =?' => 'core_main_sesfaq'));
              $menu_table->update(array('enabled' => 0), array('name =?' => 'sesfaq_footer_sesfaq'));
            }
          }
          Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
        }
        $form->addNotice('Your changes have been saved.');
        if($error)
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }

  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesfaq_admin_main', array(), 'sesfaq_admin_main_managewidgetizepage');
    $pagesArray = array('sesfaq_index_home', 'sesfaq_category_browse', 'sesfaq_index_browse', 'sesfaq_index_tags', 'sesfaq_category_index', 'sesfaq_index_view');
    $this->view->pagesArray = $pagesArray;
  }
}
