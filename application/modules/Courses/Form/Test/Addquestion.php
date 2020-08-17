<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Addquestion.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Test_Addquestion extends Engine_Form
{ 
  protected $_isEdit;
  public function setIsEdit($isEdit){
    $this->_isEdit = $isEdit;
  }
  public function init() {
    $this->setTitle('Add New Question')
            ->setDescription('Please compose your new question below.')
            ->setAttrib('id', 'courses_add_question')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form courses_smoothbox_addquestion');
    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('TinyMce', 'question', array(
        'label' => $translate->translate("Question"),
        'required' => true,
        'class' => 'tinymce',
        'editorOptions' => array('html' => true),
        'allowEmpty' => false,
    ));
    $this->addElement('Text', 'marks', array(
            'label' => $translate->translate("Enter Mark."),
            'placeholder'=> $translate->translate("Please enter Mark."),
            'class'=>'sesdecimal',
            'pattern'=>"[0-9]{1,5}",
            'validators' => array(
                    array('NotEmpty', true),
                    array('Float', true),
                    array('GreaterThan', false, array(-1))
            ),
    ));
    if(!$this->_isEdit) {
      $this->addElement('Select', 'answer_type', array(
              'label' => $translate->translate("Answer Type"),
              'multiOptions'=>array('1'=> $translate->translate("True/False"),'2'=> $translate->translate("Single Answer"),'3'=> $translate->translate("Multiple Answers")/*,'4'=>'Short Answers'*/),
      ));
    }
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => $translate->translate("Create Question"),
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'link' => true,
        'href' => '',
        'prependText' => ' or ',
        'onclick' => 'sessmoothboxclose();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
  }
}
