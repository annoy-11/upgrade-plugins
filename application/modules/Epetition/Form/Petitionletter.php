<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Petitionletter.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Petitionletter extends Engine_Form
{

  public function init()
  {
    $epetition = Engine_Api::_()->core()->getSubject();
    $this->setTitle('Letter');
    $this->addElement('TinyMce', 'letter', array(
      'label' => 'Petition Letter',
      'required' => false,
      'allowEmpty' => true,
    ));
    $rec_epetiton = Engine_Api::_()->getItemTable('epetition', 'epetition')->getDetailsForAjaxUpdate($epetition->epetition_id);
    $type=Engine_Api::_()->getDbTable('decisionmakers', 'epetition')->checkLetterApprove($epetition->epetition_id,null);
    if (($rec_epetiton['goal'] == $rec_epetiton['signpet']) && $epetition['victory'] == 0 && $type) {
      $this->addElement('Button', 'send', array(
        'label' => 'Send',
        'type' => 'button',
        'ignore' => true,
      ));
    }

    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'ignore' => true,
    ));

  }
}
