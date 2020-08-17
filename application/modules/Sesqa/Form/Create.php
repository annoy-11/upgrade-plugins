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
class Sesqa_Form_Create extends Engine_Form
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
      ->setTitle('Add New Question')
      ->setDescription('')
      ->setAttrib('id', 'question-create')
      ->setAttrib('name', 'question_create')
      ->setAttrib('enctype','multipart/form-data')
       ->setAttrib('autocomplete','false')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ;
   
    // Init name 
    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'maxlength' => '255',
      'required'=>true,
      'allowEmpty'=>false,
      'filters' => array(
        //new Engine_Filter_HtmlSpecialChars(),
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '255')),
      )
    ));
  
  if($setting->getSetting('qanda.create.tags','1')){
    // init to 
    $this->addElement('Text', 'tags',array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");
  }
  
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesqa_enable_location', 1)) {
    
      $optionsenableglotion = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('optionsenableglotion','a:6:{i:0;s:7:"country";i:1;s:5:"state";i:2;s:4:"city";i:3;s:3:"zip";i:4;s:3:"lat";i:5;s:3:"lng";}'));
      
      $locationEnable = $setting->getSetting('sesqa_location_mandatory','1');
      if($locationEnable == 1){
        $required = true; 
        $allowEmpty = false;
      }else{
        $required = false;  
        $allowEmpty = true; 
      }
      
      $this->addElement('Text', 'location', array(
          'label' => 'Location',
          'id' =>'locationSesList',
          'required'=>$required,
          'allowEmpty'=>$allowEmpty,
          'filters' => array(
              new Engine_Filter_Censor(),
              new Engine_Filter_HtmlSpecialChars(),
          ),
      ));

      if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1)) {
        if(in_array('country', $optionsenableglotion)) {
          $this->addElement('Text', 'country', array(
            'label' => 'Country',
          ));
        }
        if(in_array('state', $optionsenableglotion)) {
          $this->addElement('Text', 'state', array(
            'label' => 'State',
          ));
        }
        if(in_array('city', $optionsenableglotion)) {
          $this->addElement('Text', 'city', array(
            'label' => 'City',
          ));
        }
        if(in_array('zip', $optionsenableglotion)) {
          $this->addElement('Text', 'zip', array(
            'label' => 'Zip',
          ));
        }
      }
      $this->addElement('Text', 'lat', array(
        'label' => 'Latitude',
        'id' => 'latSesList',
      ));
      $this->addElement('Text', 'lng', array(
        'label' => 'Longitude',
        'id' => 'lngSesList',
      ));

      $this->addElement('dummy', 'map-canvas', array());
      $this->addElement('dummy', 'ses_location', array('content'));
    }
    
    // prepare categories
    $categories = Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategoriesAssoc();
    
    if( count($categories) > 0 &&  $setting->getSetting('qanda.allow.category','1')) {
      if(!$question_id){
        $categorieEnable = $setting->getSetting('qanda.category.mandatory','1');
        if($categorieEnable == 1){
          $required = true; 
          $allowEmpty = false;
        }else{
          $required = false;  
          $allowEmpty = true; 
        }
      }else{
        $required = false;  
        $allowEmpty = true; 
      }       
      $categories = array(''=>'')+$categories;
      $this->addElement('Select', 'category_id', array(
        'label' => 'Category',
        'multiOptions' => $categories,
        'allowEmpty' => $allowEmpty,
        'required' => $required,
        'onchange' => "showSubCategory(this.value);",
      ));
      $subcatArray = $subsubCatArray = array('0'=>'');
      
      if((!empty($question) && $question->category_id) || !empty($_POST['category_id'])){
        $subcatArray =  Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategoriesAssoc(array('subcat'=>!empty($_POST['category_id']) ? $_POST['category_id'] : $question->category_id));
        $subcatArray = array(''=>'')+$subcatArray;
      }
      if((!empty($question) && $question->subcat_id) || !empty($_POST['subcat_id'])){
        $subsubCatArray =  Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategoriesAssoc(array('subsubcat'=>!empty($_POST['subcat_id']) ? $_POST['subcat_id'] : $question->subcat_id));
        $subsubCatArray = array(''=>'')+$subsubCatArray;
      }
      //Add Element: 2nd-level Category
      $this->addElement('Select', 'subcat_id', array(
          'label' => "2nd-level Category",
          'allowEmpty' => true,
          'required' => false,
          'multiOptions' => $subcatArray,
          'registerInArrayValidator' => false,
          'onchange' => "showSubSubCategory(this.value);"
      ));     
      //Add Element: Sub Sub Category
      $this->addElement('Select', 'subsubcat_id', array(
          'label' => "3rd-level Category",
          'allowEmpty' => true,
          'registerInArrayValidator' => false,
          'required' => false,
          'multiOptions' => $subsubCatArray,
          'onchange' => ''
      )); 
    }
    
    
    //UPLOAD PHOTO URL
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

    $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';

    $editorOptions = array(
        'upload_url' => $upload_url,
        'html' => (bool) $allowed_html,
    );

    if (!empty($upload_url)) {
      $editorOptions['editor_selector'] = 'tinymce';
      $editorOptions['mode'] = 'specific_textareas';
      $editorOptions['plugins'] = array(
          'table', 'fullscreen', 'media', 'preview', 'paste',
          'code', 'image', 'textcolor', 'jbimages', 'link','codesample'
      );

      $editorOptions['toolbar1'] = array(
          'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
          'media', 'image', 'jbimages', 'link', 'fullscreen',
          'preview','codesample'
      );
    }
    
    if($setting->getSetting('qanda.create.editor', 'simple') == "editor")
        $tinymce = true;
    else
      $tinymce = false;
    
      if($tinymce){
        //Overview
        $this->addElement('TinyMce', 'description', array(
            'label' => 'Question Description',
            'class'=>'tinymce',
             'editorOptions' => $editorOptions,
        ));
      }else{
             //Overview
        $this->addElement('Textarea', 'description', array(
            'label' => 'Question Description',
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
                new Engine_Filter_EnableLinks(),
            ),
        ));
      }
       
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('qanda.enable.poll',1)){

        $this->addElement('Checkbox', 'enableAnswer', array(
            'label' => 'Enable answer to user',
             'value' => 1,
        ));
        //poll fields
        $this->addElement('dummy', 'poll_question', array(
          'decorators' => array(array('ViewScript', array(
                      'viewScript' => 'application/modules/Sesqa/views/scripts/_poll.tpl',
                      'class' => 'form element',
                      'question'=>isset($question) ? $question : '',
                  )))
        ));
      }
    
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
    //video/photo
    //if(empty($question_id)) {
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
    //}
    if(!empty($quote_id) && $question->photo_id && !empty($photoTrue)) {
      $this->addElement('File', 'photo', array(
        'label' => 'Photo',
        'accept'=>"image/*",
      ));
    }
    
    //ADD AUTH STUFF HERE
    $availableLabels = array(
      'everyone'              => 'Everyone',
      'registered'            => 'All Registered Members',
      'owner_network'         => 'Friends and Networks',
      'owner_member_member'   => 'Friends of Friends',
      'owner_member'          => 'Friends Only',
      'owner'                 => 'Just Me'
    );
    $this->addElement('hidden', 'is_poll', array('value' =>0,'order'=>777));
    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesqa_question', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));
    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if(count($viewOptions) == 1) {
        $this->addElement('hidden', 'auth_view', array('value' => key($viewOptions),'order'=>997));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'View Privacy',
            'description' => 'Who may see this question?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    
    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesqa_question', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));
    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if(count($commentOptions) == 1) {
        $this->addElement('hidden', 'auth_comment', array('value' => key($commentOptions),'order'=>998));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this question?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    } 
    
    // Element: auth_answer
    $postAnswer = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('sesqa_question', $user, 'auth_answer');
    $postAnswer = array_intersect_key($availableLabels, array_flip($postAnswer));
    if( !empty($postAnswer) && count($postAnswer) >= 1 ) {
      // Make a hidden field
      if(count($postAnswer) == 1) {
        $this->addElement('hidden', 'auth_answer', array('value' => key($postAnswer),'order'=>999));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_answer', array(
            'label' => 'Answer Privacy',
            'description' => 'Who may answer to this question?',
            'multiOptions' => $postAnswer,
            'value' => key($postAnswer),
        ));
        $this->auth_answer->getDecorator('Description')->setOption('placement', 'append');
      }
    }
    
    
     // Init send mail
    $this->addElement('Checkbox', 'send_mail', array(
      'label' => Zend_Registry::get('Zend_Translate')->_("Send me a mail update when someone answer my question"),
      'value' => 1,
      'disableTranslator' => true
    )); 

    
     // Init search
    $this->addElement('Checkbox', 'search', array(
      'label' => Zend_Registry::get('Zend_Translate')->_("Show this question in search results"),
      'value' => 1,
      'disableTranslator' => true
    )); 
    
    $this->addElement('Select', 'draft', array(
        'label' => 'Status',
        'description' => 'If this entry is published, it cannot be switched back to draft mode.',
        'multiOptions' => array(1=>'Published',0=>'Saved As Draft'),
        'value' => 1,
    ));
    $this->draft->getDecorator("Description")->setOption("placement", "append");
    
    $this->addElement('Button', 'submit', array(
      'label' => 'Submit',
      'order'=>1001,
      'type' => 'submit',
    ));
  }
}