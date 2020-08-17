<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilelock
 * @package    Sesprofilelock
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Userunlocked.php 2016-04-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesprofilelock_Form_Userunlocked extends Engine_Form {

  public function init() {

    $tabindex = 1;
    $_SESSION['redirectURL'] = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();

    $this->addElement('Password', 'password', array(
        'required' => true,
        'autocomplete' => 'off',
        'placeholder' => 'Password',
        'allowEmpty' => false,
        'tabindex' => $tabindex++,
        'filters' => array(
            'StringTrim',
        ),
    ));

    $this->addElement('Hidden', 'return_url', array(
    ));

    // Init submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Unlock Screen',
        'type' => 'submit',
        'ignore' => true,
        'tabindex' => $tabindex++,
    ));

    // Set default action
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesprofilelock', 'action' => 'redirect'), 'default', true));
  }

}
