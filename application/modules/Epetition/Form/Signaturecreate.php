<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Signaturecreate.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Signaturecreate extends Engine_Form
{

  protected $_type;

  public function getType()
  {
    return $this->_type;
  }

  public function setType($type)
  {
    $this->_type = $type;
    return $this;
  }

  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id=$viewer->getIdentity();
  //  $this->setAttribs(array('onsubmit' => 'signturecreatebyajax()','id'=>'signturecreate'));
    $this->setMethod('POST')
      ->setAttrib('class', 'all_form_smoothbox epetition_sign_petition_popup')
      ->setAttrib('id', 'signaturecreate')
      ->setAttrib('onsubmit', 'signturecreatebyajax(sesJqueryObject(this).attr("action"),sesJqueryObject(this).serialize());return false;');

    $this->setTitle('Signature for this petition');

    if(empty($viewer_id))
    {

      $this->addElement('text', 'first_name', array(
        'label' => 'Enter  Your First Name',
      ));

      $this->addElement('text', 'last_name', array(
        'label' => 'Enter  Your Last Name',
        'required'=>'required',
      ));

      $this->addElement('text', 'email', array(
        'label' => 'Enter  Your Email',
        'required'=>'required',
      ));
    }

    if($settings->getSetting('epetition.enb.loc',1)) {
      $this->addElement('text', 'epetition_location', array(
        'label' => 'Enter  Your Location',
        'required' => $settings->getSetting('epetition.loc.man',1),
      ));
    }

    if($settings->getSetting('epetition.enb.supt',1)) {
      $this->addElement('text', 'epetition_support_statement', array(
        'label' => 'Enter your support Statement',
        'required' => $settings->getSetting('epetition.supt.man',1),
      ));
    }
    if($settings->getSetting('epetition.enb.reason',1)) {
      $this->addElement('textarea', 'epetition_support_reason', array(
        'label' => 'Reason',
        'discription' => 'Why are you signing this petition?',
        'required' => $settings->getSetting('epetition.reason.man',1),
      ));
    }


    $this->addElement('Button', 'submit', array(
      'label' => 'Submit',
      'type' => 'submit',
      'ignore' => true
    ));

  }


}