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
class Courses_Form_Test_Create extends Engine_Form
{
  public function init() {
    $this->setTitle('Create New Test')
      ->setDescription('Conduct a test to measure the knowledge of the participants on a given topic. Here you can create different question types.');
    $test_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('test_id');
    if ($test_id) {
      $test = Engine_Api::_()->getItem('courses_test', $test_id);
    }
    $settings =Engine_Api::_()->getApi('settings', 'core');
    $translate = Zend_Registry::get('Zend_Translate');
    $this->addElement('Text', 'title', array(
      'label' => 'Title',
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
    $this->addElement($textarea, 'description', array(
        'label' => $translate->translate('Description'),
        'placeholder'=> $translate->translate('Enter Description'),
        'description'=> $translate->translate('Display Test Description on its view page.'),
        'required' => false,
        'allowEmpty' => true,
        'class'=>'tinymce',
        'editorOptions' => $editorOptions,
    ));
    $this->addElement('File', 'photo', array(
        'label' => $translate->translate('Upload Photo'),
        'description'=> $translate->translate('This photo will display on its profile and search pages.'),
        'onclick' => 'javascript:sesJqueryObject("#photo").val("")',
        'onchange' => 'handleFileBackgroundUpload(this,test_main_photo_preview)',
        'description'=> $translate->translate('Add Photo for your Test'),
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
    $this->addElement('Dummy', 'photo-uploader', array(
        'label' => $translate->translate('Upload Photo'),
        'content' => '<div id="dragandrophandlerbackground" class="courses_test_upload_dragdrop_content sesbasic_bxs' . $requiredClass . '"><div class="courses_test_upload_dragdrop_content_inner"><i class="fa fa-camera"></i><span class="courses_test_upload_dragdrop_content_txt">' . $translate->translate('Add photo for your test') . '</span></div></div>'
    ));
    $path = '';
    if (isset($test) && $test->photo_id) {
      $img_path = Engine_Api::_()->storage()->get($test->photo_id, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
    }
    $this->addElement('Image', 'test_main_photo_preview', array(
        'width' => 300,
        'height' => 200,
        'value' => '1',
        'src'=> $path,
        'disable' => true,
    ));
    $this->addElement('Dummy', 'removeimage', array(
        'content' => '<a class="icon_cancel form-link" id="removeimage1" style="display:none; "href="javascript:void(0);" onclick="removeImage();"><i class="fa fa-trash-o"></i>' . $translate->translate('Remove') . '</a>',
    ));
    $this->addElement('Hidden', 'removeimage2', array(
        'value' => 1,
        'order' => 10000000012,
    ));
    $this->addElement($textarea, 'success_message', array(
        'label' => $translate->translate('Success Message'),
        'placeholder'=> $translate->translate('Congratulation Message'),
        'description'=> $translate->translate('This will display when users passed their test.'),
        'required' => false,
        'allowEmpty' => true,
        'class'=>'tinymce',
        'editorOptions' => $editorOptions,
    ));
    $this->addElement($textarea, 'failure_message', array(
        'label' => $translate->translate('Failure Message'),
        'placeholder'=> $translate->translate('Failed Message'),
        'description'=> $translate->translate('This will display when users failed in their test.'),
        'required' => false,
        'allowEmpty' => true,
        'class'=>'tinymce',
        'editorOptions' => $editorOptions,
    ));
    $this->addElement('Text', 'test_time', array(
            'label' => $translate->translate('Enter Time in Minutes.'),
            'placeholder'=> $translate->translate('Please enter time.'),
            'class'=>'sesdecimal',
            'pattern'=>"[0-9]{1,8}",
            'validators' => array(
                    array('NotEmpty', true),
                    array('Float', true),
                    array('GreaterThan', false, array(-1))
            ),
    ));
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => $translate->translate('Create Test'),
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
