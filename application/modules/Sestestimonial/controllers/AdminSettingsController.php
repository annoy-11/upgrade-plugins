<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_AdminSettingsController extends Core_Controller_Action_Admin {

    public function indexAction() {

        $db = Engine_Db_Table::getDefaultAdapter();

        $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestestimonial_admin_main', array(), 'sestestimonial_admin_main_settings');

        $this->view->form = $form = new Sestestimonial_Form_Admin_Settings_Global();

        if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
            include_once APPLICATION_PATH . "/application/modules/Sestestimonial/controllers/License.php";
            if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.pluginactivated')) {

                //START TEXT CHNAGE WORK IN CSV FILE
                $oldSigularWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.text.singular', 'testimonial');
                $oldPluralWord = Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.text.plural', 'testimonials');
                $newSigularWord = @$values['sestestimonial_text_singular'] ? @$values['sestestimonial_text_singular'] : 'testimonial';
                $newPluralWord = @$values['sestestimonial_text_plural'] ? @$values['sestestimonial_text_plural'] : 'testimonials';
                $newSigularWordUpper = ucfirst($newSigularWord);
                $newPluralWordUpper = ucfirst($newPluralWord);
                if($newSigularWord != $oldSigularWord && $newPluralWord != $oldPluralWord) {

                    $tmp = Engine_Translate_Parser_Csv::parse(APPLICATION_PATH . '/application/languages/en/sestestimonial.csv', 'null', array('delimiter' => ';','enclosure' => '"'));
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

                    $targetFile = APPLICATION_PATH . '/application/languages/en/sestestimonial.csv';
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

    public function supportAction() {
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestestimonial_admin_main', array(), 'sestestimonial_admin_main_support');
    }

    public function manageWidgetizePageAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sestestimonial_admin_main', array(), 'sestestimonial_admin_main_managewidgetizepage');

        $pagesArray = array('sestestimonial_index_view', 'sestestimonial_index_index', 'sestestimonial_index_manage', 'sestestimonial_index_create');
        $this->view->pagesArray = $pagesArray;
    }
}
