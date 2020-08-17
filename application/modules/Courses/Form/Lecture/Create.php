<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Lecture_Create extends Engine_Form
{

  public function init() {
    $this->setTitle('Create new Lecture')
      ->setDescription('Create your lecture with effective visuals, analogies, demonstrations, and examples to reinforce the main points of the topics.');
    $lecture_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('lecture_id');
    if ($lecture_id) {
      $lecture = Engine_Api::_()->getItem('courses_lecture', $lecture_id);
    }
    $settings =Engine_Api::_()->getApi('settings', 'core');
    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('Text', 'title', array(
      'label' => $translate->translate("Title"),
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '224'))
      ),
    ));
    $user_level = Engine_Api::_()->user()->getViewer()->level_id;
    $allowed_html = Engine_Api::_()->authorization()->getPermission($user_level, 'courses', 'auth_html');
    $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    $editorOptions = array(
      'upload_url' => $upload_url,
      'html' => (bool) $allowed_html,
    );
    if (!empty($upload_url))
    {
      $editorOptions['plugins'] = array(
        'table', 'fullscreen', 'media', 'preview', 'paste',
        'code', 'image', 'textcolor', 'jbimages', 'link'
      );
      $editorOptions['toolbar1'] = array(
        'undo', 'redo', 'removeformat', 'pastetext', '|', 'code',
        'media', 'image', 'jbimages', 'link', 'fullscreen',
        'preview'
      );
      $editorOptions['toolbar2'] = array(
        'fontselect','fontsizeselect','bold','italic','underline','strikethrough','forecolor','backcolor','|','alignleft','aligncenter','alignright','alignjustify','|','bullist','numlist','|','outdent','indent','blockquote',
      );
    }

    if($settings->getSetting('courses.wysiwyg.editor',1)) {
            $textarea = 'TinyMce';
    } else{
        $textarea = 'Textarea';
    }

    $descriptionMan= $settings->getSetting('courses.description.mandatory', '1');
    if ($descriptionMan == 1) {
        $required = true;
        $allowEmpty = false;
    } else {
        $required = false;
        $allowEmpty = true;
    }
    $this->addElement($textarea, 'description', array(
        'label' => $translate->translate("Description"),
        'class'=>'tinymce',
        'required' => false,
        'allowEmpty' => true,
        'editorOptions' => $editorOptions,
    ));
    if (!isset($lecture) && empty($lecture)) {
        $this->addElement('Select', 'type', array(
                'label' => $translate->translate("Source"),
                'onchange' => "updateTextFields(this.value)"
        ));
        $lectureOptions = Array();
        $lectureOptions['html'] = $translate->translate("HTML");
        $lectureOptions['external'] = $translate->translate("External Link");
        $ffmpegPath = Engine_Api::_()->getApi('settings', 'core')->video_ffmpeg_path;
        if(!empty($ffmpegPath)) {
            $lable = $translate->translate("My Computer");
          if( Engine_Api::_()->hasModuleBootstrap('mobi') && Engine_Api::_()->mobi()->isMobile() ) {
            $lable = $translate->translate("My Device");
          }
          $lectureOptions['internal'] = $lable;
        }
        $this->type->addMultiOptions($lectureOptions);
    }
    $this->addElement($textarea, 'htmltext', array(
        'label' => $translate->translate("HTML Text"),
        'required' => false,
        'allowEmpty' => true,
        'class'=>'tinymce',
        'editorOptions' => $editorOptions,
    ));
    $this->addElement('File', 'photo_id', array(
        'label' => $translate->translate("Upload photo for Video"),
    )); 
    if (isset($lecture) && $lecture->photo_id) { 
        $img_path = Engine_Api::_()->storage()->get($lecture->photo_id, '')->getPhotoUrl();
        $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
        if (isset($path) && !empty($path)) {
          $this->addElement('Image', 'cover_photo_preview sesbd', array(
              'src' => $path,
              'class' => 'courses_channel_thumb_preview sesbd',
          ));
          $this->addElement('File', 'photo_id', array(
              'label' => $translate->translate("Upload photo for Video"),
          ));
        }
        $this->photo_id->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    } else {
        $this->addElement('File', 'photo_id', array(
            'label' => $translate->translate("Upload photo for Video"),
        ));
        $this->photo_id->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    }
    $this->photo_id->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    if($lecture) {
        $fancyUpload = new Engine_Form_Element_HTMLUpload('Filedata');
        $this->addElement($fancyUpload);
    } else {
       $fancyUpload = new Engine_Form_Element_HTMLUpload('Filedata');
       $fancyUpload->setLabel("Upload Video");
       $this->addElement($fancyUpload);
    }
    $this->addElement('Text', 'url', array(
        'label' => $translate->translate("Video Source URL"),
        'description' => $translate->translate("Paste the Url of the video here."),
    ));
    $this->addElement('Hidden', 'code', array(
        'order' => 1
    ));
    $this->addElement('Hidden', 'id', array(
        'order' => 2
    ));
    $this->addElement('Hidden', 'ignore', array(
        'order' => 3
    ));
    $this->addElement('Checkbox', 'as_preview', array(
      'label' => $translate->translate("Make this lecture as Preview"),
    ));
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' =>  $translate->translate("Create Lecture"),
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }
}
