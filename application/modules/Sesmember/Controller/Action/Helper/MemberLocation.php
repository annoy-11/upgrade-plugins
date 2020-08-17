<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MemberLocation.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Controller_Action_Helper_MemberLocation extends Zend_Controller_Action_Helper_Abstract {

  public function preDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $action = $front->getRequest()->getActionName();
    $controller = $front->getRequest()->getControllerName();
    if ($module == 'user' && $controller == 'profile' && $action == 'index') {
      $isLikeBased = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.approve.criteria', 1);
      if (empty($isLikeBased)) {
        $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
        $subject = Engine_Api::_()->user()->getUser($id);
        $viewCountForApproved = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.view.count', 10);
        $userViewCount = $subject->view_count;
        $view_count = $userViewCount + 1;
        if ($view_count >= $viewCountForApproved) {
            $getUserInfoItem = Engine_Api::_()->sesmember()->getUserInfoItem($subject->user_id);
            $getUserInfoItem->user_verified = 1;
            $getUserInfoItem->save();
           //Engine_Api::_()->getItemTable('user')->update(array('user_verified' => 1), array('user_id =?' => $subject->user_id));
        }
      }
    }
  }

  public function postDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $action = $front->getRequest()->getActionName();
    $controller = $front->getRequest()->getControllerName();
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesmember.enable.location', 1)) {
    //For Future Reference
      if ($module == 'user' && $controller == 'signup' && $action == 'index' && !isset($_SESSION['User_Plugin_Signup_Account']['data']['email'])) {
//         $form = $this->getActionController()->view->form;
//         $form->addElement('Text', 'ses_location', array(
//             'label' => 'Location',
//             'order' => Count($form->getElements()) - 7,
//             'filters' => array(
//                 new Engine_Filter_Censor(),
//                 new Engine_Filter_HtmlSpecialChars(),
//             ),
//         ));
//         $form->addElement('Hidden', 'ses_lat', array(
//             'order' => 9995,
//         ));
//         $form->addElement('Hidden', 'ses_lng', array(
//             'order' => 9996,
//         ));
//         $form->addElement('Hidden', 'ses_zip', array(
//             'order' => 9997,
//         ));
//         $form->addElement('Hidden', 'ses_city', array(
//             'order' => 9998,
//         ));
//         $form->addElement('Hidden', 'ses_state', array(
//             'order' => 9999,
//         ));
//         $form->addElement('Hidden', 'ses_country', array(
//             'order' => 10000,
//         ));
      }
      if (isset($_POST['ses_location'])) {
        $_SESSION['ses_location'] = $_POST['ses_location'];
        $_SESSION['ses_lat'] = $_POST['ses_lat'];
        $_SESSION['ses_lng'] = $_POST['ses_lng'];
        $_SESSION['ses_zip'] = $_POST['ses_zip'];
        $_SESSION['ses_city'] = $_POST['ses_city'];
        $_SESSION['ses_state'] = $_POST['ses_state'];
        $_SESSION['ses_country'] = $_POST['ses_country'];
      }
    }
    if ($module == 'user' && $controller == 'admin-fields' && ($action == 'field-create' || $action == 'field-edit' || $action == 'heading-edit' || $action == 'heading-create')) {
      $form = $this->getActionController()->view->form;
      if (!$this->getRequest()->isPost()) {
        $form->addElement('Select', 'ses_field', array(
            'label' => 'Show on SES - Advanced Members Plugin Widgets?',
            'multiOptions' => array(
                0 => 'Hide on SES - Advanced Members Plugin Widgets',
                1 => 'Show on SES - Advanced Members Plugin Widgets',
            ),
        ));
        $form->buttons->setOrder(500);
        $fieldId = $front->getRequest()->getParam('field_id', 0);
        if ($fieldId) {
          $form->ses_field->setValue(Engine_Api::_()->fields()->getField($fieldId, 'user')->ses_field);
        }
      }
    }
  }

}
