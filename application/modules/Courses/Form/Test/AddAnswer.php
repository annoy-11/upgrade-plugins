<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: AddAnswer.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Test_AddAnswer extends Engine_Form
{
  protected $_question;
  protected $_isTrue;
  public function setQuestion($question){
    $this->_question = $question;
  }
  public function setIsTrue($isTrue){ 
    $this->_isTrue = $isTrue;
  }
  public function init() {
     $translate = Zend_Registry::get('Zend_Translate');
    $this->setTitle('Add Answer')
            ->setDescription('Please compose your new Answer below.')
            ->setAttrib('id', 'courses_add_answer')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST")
            ->setAttrib('class', 'global_form courses_smoothbox_addanswer');
    if($this->_question->answer_type != 1) {
        $this->addElement('TinyMce', 'answer', array(
            'label' => $translate->translate("Answer"),
            'required' => true,
            'class' => 'tinymce',
            'editorOptions' => array('html' => true),
            'allowEmpty' => false,
          ));
    }
    if(!Engine_Api::_()->courses()->getQuestionType($this->_question) || $this->_isTrue) {
      $this->addElement('Radio', 'is_true', array(
          'label' => 'Answer',
          'multiOptions'=>array('1'=>'true','0'=> 'false'),
          'value'=> 0
      ));
    }
    $this->addElement('Button', 'submit', array(
        'label' => $translate->translate("Create Answer"),
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
