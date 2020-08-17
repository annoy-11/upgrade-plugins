<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminPagenotfoundController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_AdminPagenotfoundController extends Core_Controller_Action_Admin {


  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_pagenotfound');

    $this->view->form = $form = new Seserror_Form_Admin_Pagenotfound_Add();

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
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_pagenotfound');

    $this->view->form = $form = new Seserror_Form_Admin_Pagenotfound_Design();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();

      if (empty($values['seserror_pagenotfoundphotoID']))
        unset($values['seserror_pagenotfoundphotoID']);
        
      if (isset($_FILES['seserror_pagenotfoundphotoID'])) {
        $photoFileIcon = Engine_Api::_()->seserror()->setPhoto($form->seserror_pagenotfoundphotoID);

        if (!empty($photoFileIcon->file_id)) {
          $values['seserror_pagenotfoundphotoID'] = $photoFileIcon->file_id;
        }
      }
      if($values['remove_image'] == 1) {
        $values['seserror_pagenotfoundphotoID'] = 0;
      }

      foreach ($values as $key => $value) {
        //if($value != '')
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
      $this->_helper->redirector->gotoRoute(array());
    }
  }
}