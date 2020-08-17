<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contact.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespage_Form_Dashboard_Contact extends Engine_Form {

  public function init() {
    $this->setTitle('Contact Page Members')
         ->setDescription('Using the below form, you will be able to send message to all of the members of your Page and also to the members of selected Page Role. ')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
            ->setMethod('POST');
    ;
    
    $options = array('1'=>'All Members','2'=>'Page Role');
    $table = Engine_Api::_()->getDbTable('memberroles','sespage');
    $pageRoles = $table->fetchAll($table->select());
    $pageRolesArray = array();
    foreach($pageRoles as $role)
      $pageRolesArray[$role->getIdentity()] = $role->title;
      
    if(!count($pageRolesArray))
      unset($options['2']);
    
    if(count($options)){
      $this->addElement('Select', 'type', array(
          'label' => 'Select Member',
          'description' => '',
          'multiOptions' => $options,
      ));
      $allowEmpty = !(!empty($_POST) && $_POST['type'] == 2);
      $required = !empty($_POST) && $_POST['type'] == 2;
      $this->addElement('MultiCheckbox', 'page_roles', array(
          'label' => 'Select Page Roles',
          'allowEmpty'=>$allowEmpty,
          'required'=>$required,
          'description' => '',
          'multiOptions' => $pageRolesArray,
      ));
    }else{
      $this->addElement('Hidden','type',array('order'=>9998,'value'=>1));
    }
    
    $this->addElement('Text', 'subject', array(
        'label' => 'Subject',
        'description' => '',
        'allowEmpty'=>false,
          'required'=>true,
        'value' => 'The owner of [page_title] has contacted you.',
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
