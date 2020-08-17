<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Createslide.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Dashboard_Createslide extends Engine_Form {

  public function init() {

    $this->setTitle('Create Slide')
    ->setAttrib('id', 'sesproduct_create_slide')
    ->setMethod("POST")
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->addElement('Select', 'type', array(
      'label' => 'Slide Type',
      'allowEmpty' => false,
      'required' => true,
      'multiOptions' => array(0=>'Photo',1=>'Video'),
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 64)),
      ),
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));

    $allowEmpty = false;
    $required = true;
    if(!empty($_POST['type']) && $_POST['type'] == 1){
      $allowEmpty = true;
      $required = false;
    }
    $this->addElement('File', 'file', array(
      'label' => 'Photo',
      'allowEmpty' => $allowEmpty,
      'required' => $required,
      'validators' => array(
          array('Extension', false, 'jpg,png,gif,jpeg')
      ),
    ));

    $this->addElement('Text', 'title', array(
      'description'=>'',
      'label' => "Title",
    ));

     $this->addElement('Textarea', 'description', array(
      'description'=>'',
      'label' => "Description",
    ));
    $allowEmpty = true;
    $required = false;
    if(!empty($_POST['type']) && $_POST['type'] == 1){
      $allowEmpty = false;
      $required = true;
    }
    $this->addElement('Text', 'url', array(
      'description'=>'',
      'allowEmpty' => $allowEmpty,
      'required' => $required,
      'label' => 'Video Source URL',
    ));


    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array(
	      'ViewHelper',
      ),
    ));

//    $this->addDisplayGroup(array('submit'), 'buttons', array(
//      'decorators' => array(
//	'FormElements',
//	'DivDivDivWrapper',
//      ),
//    ));
  }
}
