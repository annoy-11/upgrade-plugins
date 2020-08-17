<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminComingsoonController.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_AdminComingsoonController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_comingsoon');

    $this->view->form = $form = new Seserror_Form_Admin_Comingsoon_Add();
    
    $endDate = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.comingsoondate', 0);
    if(!empty($endDate)) {
      $endDate = strtotime($endDate);
      $endDate = date('Y-m-d', $endDate);
      $form->populate(array('seserror_comingsoondate' => $endDate));
    } else {
    
    }

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
      $values = $form->getValues();
      foreach ($values as $key => $value) {
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }


  public function designsAction() {

    $db = Engine_Db_Table::getDefaultAdapter();
    
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('seserror_admin_main', array(), 'seserror_admin_main_comingsoon');

    $this->view->form = $form = new Seserror_Form_Admin_Comingsoon_Design();

    if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
    
      $values = $form->getValues();
      
      if (empty($values['seserror_comingsoonphotoID']))
        unset($values['seserror_comingsoonphotoID']);
        
      if (isset($_FILES['seserror_comingsoonphotoID'])) {
        $photoFileIcon = Engine_Api::_()->seserror()->setPhoto($form->seserror_comingsoonphotoID);

        if (!empty($photoFileIcon->file_id)) {
          $values['seserror_comingsoonphotoID'] = $photoFileIcon->file_id;
        }
      }
      
      if($values['remove_image'] == 1) {
        $values['seserror_comingsoonphotoID'] = 0;
      }
      
      foreach ($values as $key => $value) {
        //if($value != '')
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }
  }
}