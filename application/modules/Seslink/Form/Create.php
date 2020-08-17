<?php

class Seslink_Form_Create extends Engine_Form
{
  public $_error = array();

  public function init()
  {   
    $this->setTitle('Post New Link')
      ->setDescription('Post a new link')
      ->setAttrib('name', 'seslink_create');
      
    $user = Engine_Api::_()->user()->getViewer();
    $userLevel = Engine_Api::_()->user()->getViewer()->level_id;
    
    $link_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('link_id', 0);
    
    if(!$link_id) {
      $this->addElement('Text', 'link', array(
        'label' => 'Enter External Link',
        'allowEmpty' => false,
        'required' => true,
      ));
      
      $this->addElement('Dummy', 'attachlink', array(
        'content' => '<div class="" id="loading_image" style="display: none;"><span class="sesbasic_link_btn"><i class="fa fa-spinner fa-spin"></i></span></div><a href="javascript:void(0);" onclick="attachlink();">'."Attach".'</a>',
      ));
      
      $this->addElement('Dummy', 'previewlink', array(
        'content' => '<div id="link_preview" style="display: none;"></div>',
      ));
    }

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '255'))
      ),
    ));
    
    // init to
    $this->addElement('Text', 'tags', array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");

    $this->addElement('TinyMce', 'body', array(
      'label' => 'Description',
      'required' => true,
      'editorOptions' => array(
        'html' => true,
      ),
      'allowEmpty' => false,        
    ));

    $this->addElement('File', 'photo', array(
      'label' => 'Choose Photo',
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this link entry in search results',
      'value' => 1,
    ));

    $this->addElement('Hidden', 'imagelink', array());

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Post Entry',
      'type' => 'submit',
    ));
  }
}