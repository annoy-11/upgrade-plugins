<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Decisionmakergoaledit.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Dashboard_Decisionmakergoaledit extends Engine_Form
{
  public function init() {
    $this->setTitle('Petition Signature Goal');
    $this->setMethod('POST')
      ->setAttrib('class', 'all_form_smoothbox epetition_signature_popup')
      ->setAttrib('onsubmit', 'signturecreatebyajax(sesJqueryObject(this).attr("action"),sesJqueryObject(this).serialize());return false;');


    $this->addElement('text', 'signature_goal', array(
      'label' => 'Goal',
      'required' => true,
      'allowEmpty' => false,
      'Onkeypress'=>'return allowOnlyNumbers(event)',
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
    ));
  }


}
