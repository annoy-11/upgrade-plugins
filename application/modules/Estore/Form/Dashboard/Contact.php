<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contact.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Dashboard_Contact extends Engine_Form {

  public function init() {
    $this->setTitle('Contact Store Members')
         ->setDescription('Using the below form, you will be able to send message to all of the members of your Store and also to the members of selected Store Role. ')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
            ->setMethod('POST');
    ;

    $options = array('1'=>'All Members','2'=>'Store Role');
    $table = Engine_Api::_()->getDbTable('memberroles','estore');
    $storeRoles = $table->fetchAll($table->select());
    $storeRolesArray = array();
    foreach($storeRoles as $role)
      $storeRolesArray[$role->getIdentity()] = $role->title;

    if(!count($storeRolesArray))
      unset($options['2']);

    if(count($options)){
      $this->addElement('Select', 'type', array(
          'label' => 'Select Member',
          'description' => '',
          'multiOptions' => $options,
      ));
      $allowEmpty = !(!empty($_POST) && $_POST['type'] == 2);
      $required = !empty($_POST) && $_POST['type'] == 2;
      $this->addElement('MultiCheckbox', 'store_roles', array(
          'label' => 'Select Store Roles',
          'allowEmpty'=>$allowEmpty,
          'required'=>$required,
          'description' => '',
          'multiOptions' => $storeRolesArray,
      ));
    }else{
      $this->addElement('Hidden','type',array('order'=>9998,'value'=>1));
    }

    $this->addElement('Text', 'subject', array(
        'label' => 'Subject',
        'description' => '',
        'allowEmpty'=>false,
          'required'=>true,
        'value' => '[store_title] owner contacted you.',
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
