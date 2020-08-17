<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdiscussion_admin_main', array(), 'sesdiscussion_admin_main_settings');

    $this->view->form = $form = new Sesdiscussion_Form_Admin_Settings_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();

      if(@$values['sesdiscussion_newdays']) {
        $seconds = $values['sesdiscussion_newdays'] * 24 * 60 *60;
        $db->query('UPDATE `engine4_core_tasks` SET `timeout` = "'.$seconds.'" WHERE `engine4_core_tasks`.`plugin` = "Sesdiscussion_Plugin_Task_Removeasnew";');
      }

      if(@$values['sesdiscussion_createform']) {
        $db->query('UPDATE `engine4_core_menuitems` SET `params` = \'{"route":"sesdiscussion_general","action":"create", "class":"sessmoothbox"}\' WHERE `engine4_core_menuitems`.`name` = "sesdiscussion_main_create";');
      } else {
        $db->query('UPDATE `engine4_core_menuitems` SET `params` = \'{"route":"sesdiscussion_general","action":"create"}\' WHERE `engine4_core_menuitems`.`name` = "sesdiscussion_main_create";');
      }

      unset($values['defaultdiscussion']);
      include_once APPLICATION_PATH . "/application/modules/Sesdiscussion/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.pluginactivated')) {

        //START TEXT CHNAGE WORK IN CSV FILE
        $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussion.singular', 'discussion');
        $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.discussion.plural', 'discussions');
        $newSigularWord = @$values['sesdiscussion_discussion_singular'] ? @$values['sesdiscussion_discussion_singular'] : 'discussion';
        $newPluralWord = @$values['sesdiscussion_discussion_plural'] ? @$values['sesdiscussion_discussion_plural'] : 'discussions';
        $newSigularWordUpper = ucfirst($newSigularWord);
        $newPluralWordUpper = ucfirst($newPluralWord);
        if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

          $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sesdiscussion.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
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

          $targetFile = APPLICATION_PATH . '/application/languages/en/sesdiscussion.csv';
          if (file_exists($targetFile))
            @unlink($targetFile);

          touch($targetFile);
          chmod($targetFile, 0777);

          $writer = new Engine_Translate_Writer_Csv($targetFile);
          $writer->setTranslations($OutputData);
          $writer->write();
          //END CSV FILE WORK
        }

        if(!empty($values['is_license'])) {
            if (isset($values['sesdiscussion_options']))
                $values['sesdiscussion_options'] = serialize($values['sesdiscussion_options']);
            else
                $values['sesdiscussion_options'] = serialize(array());
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
    public function supportAction() {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdiscussion_admin_main', array(), 'sesdiscussion_admin_main_support');
    }

  public function manageWidgetizePageAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesdiscussion_admin_main', array(), 'sesdiscussion_admin_main_managepages');

    $this->view->pagesArray = array('sesdiscussion_index_index', 'sesdiscussion_index_manage', 'sesdiscussion_index_view', 'sesdiscussion_category_browse', 'sesdiscussion_index_top-voted', 'sesdiscussion_index_create', 'sesdiscussion_index_edit');
  }
}
