<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminTemplateController.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Otpsms_AdminTemplateController extends Core_Controller_Action_Admin {
  public function indexAction() {
    $db = Engine_Db_Table::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('otpsms_admin_main', array(), 'otpsms_admin_main_template');
    $this->view->form = $form = new Otpsms_Form_Admin_Templates();
    $language = $this->_getParam('language','en');
    if($language)
      $form->language->setValue($language);
    
    $result = Engine_Api::_()->getDbTable('templates','otpsms')->getTemplates($language);
    if($result)
      $form->populate($result->toArray());
    
    if($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())){
      if($result){
        $result->setFromArray($form->getValues());
        $result->save();
      }else{
        $table = Engine_Api::_()->getDbTable('templates','otpsms');
        $result = $table->createRow();
        $result->setFromArray($form->getValues());
        $result->save();
      }
      $form->addNotice("Changes saved successfully.");
    }
  }
  
}
