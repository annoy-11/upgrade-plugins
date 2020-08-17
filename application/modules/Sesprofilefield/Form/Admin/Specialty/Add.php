<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Admin_Specialty_Add extends Engine_Form {

  public function init() {

    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
        'allowEmpty' => false,
        'required' => true,
    ));

    $this->addElement('Hidden', 'id', array());
    
    $sptparam = Zend_Controller_Front::getInstance()->getRequest()->getParam('sptparam');
    if($sptparam == 'subsub') {
      $this->addElement('MultiCheckbox', 'type', array(
        'label' => 'Choose Type',
        'multiOptions' => array(
          'minutes' => 'Minutes',
          'seconds' => 'Seconds',
          'reps' => 'REPS',
          'lbs' => "LBS",
          'lbskg' => "LBS or KG",
        ),
      ));
    }

    $this->addElement('Button', 'submit', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}