<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Incognitoavatar.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesavatar_Form_Incognitoavatar extends Engine_Form {

  public function init() {
  
    $userId = Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id', 0);
    $rowExists = Engine_Api::_()->getDbTable('avatars', 'sesavatar')->rowExists($userId);
    
    $hours = 0;
    if(!empty($rowExists)) {
      $creation_date = $rowExists->creation_date;
      
      $date1 = $creation_date;
      $date2 = date('Y-m-d H:i:s');
      $seconds = strtotime($date2) - strtotime($date1);
      //$hours = $seconds / 60 /  60;
      $hours = $seconds / 60;
    }

    if(empty($rowExists)) {
      
      $this->addElement('Button', 'submit', array(
          'type' => 'submit',
          'ignore' => true,
          'decorators' => array('ViewHelper')
      ));

      $this->addElement('Cancel', 'cancel', array(
          'label' => 'Cancel',
          'link' => true,
          'prependText' => ' or ',
          'onclick' => 'javascript:parent.Smoothbox.close()',
          'decorators' => array(
              'ViewHelper',
          ),
      ));
      $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    } else {
        
        if($hours < 10) {
          $description = "<div class='tip'><span>" . Zend_Registry::get('Zend_Translate')->_('You have already gone to Incognito mode, Now you can go only after 24 hours.') . "</span></div>";
          $this->addElement('Dummy', 'sesavatar_tip', array(
              'description' => $description,
          ));
          $this->sesavatar_tip->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
        }
    
        $this->addElement('Cancel', 'cancel', array(
            'label' => 'Cancel',
            'link' => true,
            'onclick' => 'javascript:parent.Smoothbox.close()',
            'decorators' => array(
                'ViewHelper',
            ),
        ));
    }
  }
}
