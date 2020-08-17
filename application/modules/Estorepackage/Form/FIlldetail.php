<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Estorepackage
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filldetail.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Estorepackage_Form_Filldetail extends Engine_Form {

  public function init() {
    $this
            ->setTitle('')
            ->setDescription('');
    $this->addElement('Textarea', 'message', array(
        'label' => 'Message',
        'description' => '',
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('File', 'payment_file', array(
        'label' => 'Attach File',
        'placeholder' => "",
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Send Message',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'onclick' => 'javascript:sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        )
    ));
		
  }

}
