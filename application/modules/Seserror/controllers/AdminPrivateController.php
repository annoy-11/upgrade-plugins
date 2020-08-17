<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id AdminPrivateController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_AdminPrivateController extends Core_Controller_Action_Admin {


  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_private');

    $this->view->form = $form = new Seserror_Form_Admin_Private_Add();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }


  public function designsAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_private');

    $this->view->form = $form = new Seserror_Form_Admin_Private_Design();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();

      if (empty($values['seserror_privatepagephotoID']))
        unset($values['seserror_privatepagephotoID']);
        
      if (isset($_FILES['seserror_privatepagephotoID'])) {
        $photoFileIcon = Engine_Api::_()->seserror()->setPhoto($form->seserror_privatepagephotoID);

        if (!empty($photoFileIcon->file_id)) {
          $values['seserror_privatepagephotoID'] = $photoFileIcon->file_id;
        }
      }
      if($values['remove_image'] == 1) {
        $values['seserror_privatepagephotoID'] = 0;
      }
      
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
}