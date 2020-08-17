<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Contact.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Classroom_Form_Dashboard_Contact extends Engine_Form {

  public function init() {
    $this->setTitle('Contact Classroom Members')
         ->setDescription('Using the below form, you will be able to send message to all of the members of your Classroom and also to the members of selected Classroom Role. ')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
            ->setMethod('POST');
    ;

    $options = array('1'=>'All Members','2'=>'Classroom Role');
    $table = Engine_Api::_()->getDbTable('memberroles','eclassroom');
    $classroomRoles = $table->fetchAll($table->select());
    $classroomRolesArray = array();
    foreach($classroomRoles as $role)
      $classroomRolesArray[$role->getIdentity()] = $role->title;

    if(!count($classroomRolesArray))
      unset($options['2']);

    if(count($options)){
      $this->addElement('Select', 'type', array(
          'label' => 'Select Member',
          'description' => '',
          'multiOptions' => $options,
      ));
      $allowEmpty = !(!empty($_POST) && $_POST['type'] == 2);
      $required = !empty($_POST) && $_POST['type'] == 2;
      $this->addElement('MultiCheckbox', 'classroom_roles', array(
          'label' => 'Select Classroom Roles',
          'allowEmpty'=>$allowEmpty,
          'required'=>$required,
          'description' => '',
          'multiOptions' => $classroomRolesArray,
      ));
    }else{
      $this->addElement('Hidden','type',array('order'=>9998,'value'=>1));
    }

    $this->addElement('Text', 'subject', array(
        'label' => 'Subject',
        'description' => '',
        'allowEmpty'=>false,
          'required'=>true,
        'value' => '[classroom_title] owner contacted you.',
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
