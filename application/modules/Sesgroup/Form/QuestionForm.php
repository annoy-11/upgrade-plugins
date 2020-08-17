<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: QuestionForm.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Form_QuestionForm extends Engine_Form
{
 
  public function init() { 
  
    $this->setTitle('Ask Pending Members Questions')
      ->setDescription('Ask pending members some questions. They\'ll have up to 250 characters to answer each one, and only admins and moderators will see the answers.')
      ->setAttrib('name', '')
      ->setAttrib('id', '');
    $this->addElement('Text', 'quesfield1', array(
      'label' => '',
      'placeholder' => 'Write a question',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
    $this->addElement('Dummy', 'removequesfield1', array(
      'label' => '',
      'content' => '<a href="javascript:void(0);" onclick="removeQuestion(1);" class="_remove"><i class="fa fa-close"></i><span>Remove</span></a>',
    ));
		$this->addDisplayGroup(array('quesfield1', 'removequesfield1'), 'quesfield1_cont');
   $this->addElement('Text', 'quesfield2', array(
      'label' => '',
      'placeholder' => 'Write a question',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
   $this->addElement('Dummy', 'removequesfield2', array(
      'label' => '',
      'content' => '<a href="javascript:void(0);" onclick="removeQuestion(2);" class="_remove"><i class="fa fa-close"></i><span>Remove</span></a>',
    ));
    $this->addDisplayGroup(array('quesfield2', 'removequesfield2'), 'quesfield2_cont');
    $this->addElement('Text', 'quesfield3', array(
      'label' => '',
      'placeholder' => 'Write a question',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
    $this->addElement('Dummy', 'removequesfield3', array(
      'label' => '',
      'content' => '<a href="javascript:void(0);" onclick="removeQuestion(3);" class="_remove"><i class="fa fa-close"></i><span>Remove</span></a>',
    ));
		$this->addDisplayGroup(array('quesfield3', 'removequesfield3'), 'quesfield3_cont');
    $this->addElement('Text', 'quesfield4', array(
      'label' => '',
      'placeholder' => 'Write a question',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
    $this->addElement('Dummy', 'removequesfield4', array(
      'label' => '',
      'content' => '<a href="javascript:void(0);" onclick="removeQuestion(4);" class="_remove"><i class="fa fa-close"></i><span>Remove</span></a>',
    ));
    $this->addDisplayGroup(array('quesfield4', 'removequesfield4'), 'quesfield4_cont');
    $this->addElement('Text', 'quesfield5', array(
      'label' => '',
      'placeholder' => 'Write a question',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));
    $this->addElement('Dummy', 'removequesfield5', array(
      'label' => '',
      'content' => '<a href="javascript:void(0);" onclick="removeQuestion(5);" class="_remove"><i class="fa fa-close"></i><span>Remove</span></a>',
    ));
		$this->addDisplayGroup(array('quesfield5', 'removequesfield5'), 'quesfield5_cont');
    $this->addElement('Dummy', 'createquestion', array(
      'label' => '',
      'content' => '<a href="javascript:void(0);" onclick="showMoreQuestion();"><i class="fa fa-plus"></i> <span>Add a question</span></a>',
    ));
    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      //'type' => 'submit',
      'onclick' => 'saveFormQuestions();',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));
    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');
  }
}
