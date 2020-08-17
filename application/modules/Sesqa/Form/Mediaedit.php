<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Form_Mediaedit extends Engine_Form
{
 
  public function init()
  {
    
    $question_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('question_id');
    if($question_id){
      $question = Engine_Api::_()->getItem('sesqa_question',$question_id);  
    }
    $setting = Engine_Api::_()->getApi('settings', 'core');
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;
    $user = Engine_Api::_()->user()->getViewer();
    // Init form
    $this
      ->setTitle('Edit Media')
      ->setDescription('')
      ->setAttrib('id', 'question-create')
      ->setAttrib('name', 'question_create')
      ->setAttrib('enctype','multipart/form-data')
       ->setAttrib('autocomplete','false')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ;
    
     $allowedType = Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda_create_mediaoptions',array('image','video'));
     $option = array();
     if(in_array('video',$allowedType)){
         $videoTrue = true;
         $option['2'] = 'Video';
     }
     if(in_array('image',$allowedType)){
         $photoTrue = true;
         $option['1'] = 'Photo';
     }
        $this->addElement('Radio', 'mediatype', array(
          'label' => "Choose Media Type",
          'multiOptions' => $option,
          'value' => !empty($option[1]) ? 1 : 2,
          'onchange' => "showMediaType(this.value);",
        ));

      if(!empty($photoTrue)){
        $this->addElement('File', 'photo', array(
          'label' => 'Photo',
          'accept'=>"image/*",
        ));
      }
      if(!empty($videoTrue)) {
        $this->addElement('Text', 'video', array(
          'description'=>'',
          'label'=>'Paste web address of the video',
          'placeholder'=> 'Paste the web address of the video here.',
          'autocomplete'=>'off',
          'onblur' => "iframelyurl();",
        ));
      }
      
    if(!empty($quote_id) && $question->photo_id && !empty($photoTrue)) {
      $this->addElement('File', 'photo', array(
        'label' => 'Photo',
        'accept'=>"image/*",
      ));
    }
    
     $this->addElement('Image', 'current', array(
      'label' => 'Current Photo',
      'ignore' => true,
      'decorators' => array(array('ViewScript', array(
      'viewScript' => '_formEditImage.tpl',
      'class'      => 'form element',
      'testing' => 'testing'
          )))
        ));
        Engine_Form::addDefaultDecorators($this->current);

    
    $this->addElement('Button', 'submit', array(
      'label' => 'Submit',
      'order'=>1001,
      'type' => 'submit',
    ));
  }
}