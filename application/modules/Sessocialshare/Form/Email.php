<?php

class Sessocialshare_Form_Email extends Engine_Form {

 public $_error = array();

  public function init() {

    /*$item_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);
    $item_type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type', null);
    $item = Engine_Api::_()->getItem($item_type, $item_id);
    $item_title = ucfirst(str_replace(array('sesevent_',''),'',$item->getType()));*/
    
//     $titleShare = 'Email a Friend';
//     $this->setTitle($titleShare )
            $this->setAttrib('name', 'sesbasic_tellafriend');
    $this->setAttribs(array('id' => 'sessocialshare_invite','class' => 'global_form_box'))->setMethod('GET');
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if(!empty($viewer_id)) {
    
      //$this->addElement('Hidden', 'sender_name', array('value' => $viewer->displayname,'order'=>98));
      //$this->addElement('Hidden', 'sender_email', array('value' => $viewer->email));
      
      $this->addElement('Text', 'sender_name', array(
        'label' => 'Your Name',
        //'allowEmpty' => false,
        //'required' => true,
        'disable' => true,
        'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
          new Engine_Filter_StringLength(array('max' => '63')),
        ),
        //'value' => $viewer->displayname,
      ));

      $this->addElement('Text', 'sender_email', array(
        'label' => 'Your Email',
        //'allowEmpty' => false,
        //'required' => true,
        'disable' => true,
        'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
          new Engine_Filter_StringLength(array('max' => '63')),
        ),
       // 'value' => $viewer->email,
      ));
    }
    else {
      $this->addElement('Text', 'sender_name', array(
          'label' => 'Your Name',
          'allowEmpty' => false,
          'required' => true,
          'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '63')),
      )));

      $this->addElement('Text', 'sender_email', array(
          'label' => 'Your Email',
          'allowEmpty' => false,
          'required' => true,
          'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '63')),
      )));
    }
    $this->addElement('Text', 'reciver_emails', array(
        'label' => 'To',
        'allowEmpty' => false,
        'required' => true,
        // 'description' => 'Separate multiple addresses with commas',
        'filters' => array(
            new Engine_Filter_Censor(),
        ),
    ));

    $this->addElement('textarea', 'message', array(
        'label' => 'Add a note',
        'required' => true,
        'allowEmpty' => false,
        'attribs' => array('rows' => 4, 'cols' => 150),
        'value' => '',
        'filters' => array(
            'StripTags',
            new Engine_Filter_HtmlSpecialChars(),
            new Engine_Filter_EnableLinks(),
            new Engine_Filter_Censor(),
        ),
    ));
    
    $show_captcha = Engine_Api::_()->getApi('settings', 'core')->getSetting('sessocialshare.captcha', 1);
    if( $show_captcha && !Engine_Api::_()->user()->getViewer()->getIdentity()) {
      $this->addElement('captcha', 'captcha', Engine_Api::_()->core()->getCaptchaOptions());
    }
    
    $this->addElement('Button', 'submit', array(
      'type' => 'submit',
      'label' => 'Send',
      'ignore' => true,
    ));
  }
}