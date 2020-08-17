<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contact.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Dashboard_Contact extends Engine_Form {

  public function init() {
    $this->setTitle('Contact Business Members')
         ->setDescription('Using the below form, you will be able to send message to all of the members of your Business and also to the members of selected Business Role. ')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
            ->setMethod('POST');
    ;

    $options = array('1'=>'All Members','2'=>'Business Role');
    $table = Engine_Api::_()->getDbTable('memberroles','sesbusiness');
    $businessRoles = $table->fetchAll($table->select());
    $businessRolesArray = array();
    foreach($businessRoles as $role)
      $businessRolesArray[$role->getIdentity()] = $role->title;

    if(!count($businessRolesArray))
      unset($options['2']);

    if(count($options)){
      $this->addElement('Select', 'type', array(
          'label' => 'Select Member',
          'description' => '',
          'multiOptions' => $options,
      ));
      $allowEmpty = !(!empty($_POST) && $_POST['type'] == 2);
      $required = !empty($_POST) && $_POST['type'] == 2;
      $this->addElement('MultiCheckbox', 'business_roles', array(
          'label' => 'Select Business Roles',
          'allowEmpty'=>$allowEmpty,
          'required'=>$required,
          'description' => '',
          'multiOptions' => $businessRolesArray,
      ));
    }else{
      $this->addElement('Hidden','type',array('order'=>9998,'value'=>1));
    }

    $this->addElement('Text', 'subject', array(
        'label' => 'Subject',
        'description' => '',
        'allowEmpty'=>false,
          'required'=>true,
        'value' => '[business_title] owner contacted you.',
    ));

    $this->addElement('Textarea', 'message', array(
        'label' => 'Message',
        'allowEmpty'=>false,
          'required'=>true,
        'description' => '',

    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Send',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
  }

}
