<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminStyleController.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmenu_AdminStyleController extends Core_Controller_Action_Admin
{
  public function indexAction()
  {
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesmenu_admin_main', array(), 'sesmenu_admin_main_style');
    $this->view->form = $form = new Sesmenu_Form_Admin_style_styling();
    $settings = Engine_Api::_()->getApi('settings', 'core');

          if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
          $values = $form->getValues();
          $db = Engine_Db_Table::getDefaultAdapter();
          $db->beginTransaction();
          try {
              $values = $form->getValues();
              foreach ($values as $key=>$value){
                  $settings->setSetting($key,$value);
              }
              $db->commit();
          } catch( Exception $e ) {
              $db->rollback();
              throw $e;
          }
          $form->addNotice('Your changes have been saved.');
          $this->_helper->redirector->gotoRoute(array());
      }
  }
}
