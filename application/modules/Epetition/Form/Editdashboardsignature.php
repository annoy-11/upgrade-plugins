<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Editdashboardsignature.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Editdashboardsignature extends Engine_Form
{


  public function init()
  {
    $this->setMethod('POST')
      ->setAttrib('class', 'all_form_smoothbox')
      ->setAttrib('onsubmit', 'signturecreatebyajax(sesJqueryObject(this).attr("action"),sesJqueryObject(this).serialize());return false;');

    $this->addElement('text', 'location', array(
      'label' => 'Enter Your Location',
      'required'=>true,
    ));

    $this->addElement('text', 'support_statement', array(
      'label' => 'Enter your support Statement',
      'required'=>true,
    ));

    $this->addElement('textarea', 'support_reason', array(
      'label' => 'Reason',
      'discription'=>'Why are you signing this petition?',
      'required'=>true,
    ));


    $this->addElement('Button', 'submit', array(
      'label' => 'Submit',
      'type' => 'submit',
      'ignore' => true
    ));

  }


}