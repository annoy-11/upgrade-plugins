<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Addteammembers.php 2015-03-10 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Form_Admin_AddAdminPicks extends Engine_Form {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    $this->setTitle('Add New Member')
            ->setMethod('POST');

    $this->addElement('Text', "name", array(
        'label' => 'Choose Member',
        'placeholder' => 'Enter Member Name',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Hidden', 'user_id', array());


    $this->addElement('Button', 'button', array(
        'type' => 'submit',
        'label' => "Add",
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
    $this->addDisplayGroup(array('button', 'cancel'), 'buttons');
  }

}
