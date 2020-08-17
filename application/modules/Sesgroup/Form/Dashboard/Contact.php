<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contact.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Form_Dashboard_Contact extends Engine_Form {

  public function init() {
    $this->setTitle('Contact Group Members')
         ->setDescription('Using the below form, you will be able to send message to all of the members of your Group and also to the members of selected Group Role. ')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
            ->setMethod('POST');
    ;
    
    $options = array('1'=>'All Members','2'=>'Group Role');
    $table = Engine_Api::_()->getDbTable('memberroles','sesgroup');
    $groupRoles = $table->fetchAll($table->select());
    $groupRolesArray = array();
    foreach($groupRoles as $role)
      $groupRolesArray[$role->getIdentity()] = $role->title;
      
    if(!count($groupRolesArray))
      unset($options['2']);
    
    if(count($options)){
      $this->addElement('Select', 'type', array(
          'label' => 'Select Member',
          'description' => '',
          'multiOptions' => $options,
      ));
      $allowEmpty = !(!empty($_POST) && $_POST['type'] == 2);
      $required = !empty($_POST) && $_POST['type'] == 2;
      $this->addElement('MultiCheckbox', 'group_roles', array(
          'label' => 'Select Group Roles',
          'allowEmpty'=>$allowEmpty,
          'required'=>$required,
          'description' => '',
          'multiOptions' => $groupRolesArray,
      ));
    }else{
      $this->addElement('Hidden','type',array('order'=>9998,'value'=>1));
    }
    
    $this->addElement('Text', 'subject', array(
        'label' => 'Subject',
        'description' => '',
        'allowEmpty'=>false,
          'required'=>true,
        'value' => '[group_title] owner contacted you.',
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
