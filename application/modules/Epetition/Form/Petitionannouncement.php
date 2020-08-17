<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Petitionannouncement.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Petitionannouncement extends Engine_Form {

  public function init() {
    $this->setTitle('Petition Announcement');
    $this->setMethod('POST')
      ->setAttrib('class', 'all_form_smoothbox')
      ->setAttrib('onsubmit', 'signturecreatebyajax(sesJqueryObject(this).attr("action"),this);return false;');

    $this->addElement('text', 'announcement_title', array(
      'label' => 'Announcement Title',
      'required' => true,
      'allowEmpty' => false,
    ));

    $this->addElement('TinyMce', 'announcement_description', array(
      'label' => 'Description',
	    'class'=>'tinymce',
      'required' => false,
      'allowEmpty' => true,
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Submit',
      'type' => 'submit',
      'ignore' => true
    ));
  }

}
