<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Form_Create extends Engine_Form {

  public $_error = array();
  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $createform = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.createform', 1);

    $editortype = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.editortype', 0);

    if($settings->getSetting('sesdiscussion.descriptionlimit', 0) == '0') {
      $descriptionlimit = 9999;
    } else {
      $descriptionlimit = $settings->getSetting('sesdiscussion.descriptionlimit', 0);
    }

    $discussion_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('discussion_id', 0);
    if($discussion_id) {
      $discussion = Engine_Api::_()->getItem('discussion', $discussion_id);
    }

    if(empty($discussion_id)) {

      $options = unserialize(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.options', 'a:4:{i:0;s:5:"topic";i:1;s:5:"photo";i:2;s:5:"video";i:3;s:4:"link";}'));
      if(count($options) > 1) {
        $option_array = array();
        if(in_array('topic', $options))
          $option_array[4] = 'Topic';
        if(in_array('photo', $options))
          $option_array[1] = 'Photo';
        if(in_array('video', $options))
          $option_array[2] = 'Video';
        if(in_array('link', $options))
          $option_array[3] = 'Link';

        if(count($option_array) > 0) {
          $this->addElement('Radio', 'mediatype', array(
            'label' => "Choose Media Type",
            'multiOptions' => $option_array,
            'value' => 4,
            'onchange' => "showMediaType(this.value);",
          ));
        }
      }
    }

    $this->setTitle('Create New Discussion')
        //->setMethod("POST")
        ->setDescription('Compose your new discussion entry below, then click "Post Discussion" to publish your discussion.')
        ->setAttrib('class', 'sesdiscussion_create_form global_form');

    if($createform) {
      $this->setAttrib('name', 'sesdiscussions_create');
    } else {
      $this->setAttrib('name', 'sesdiscussion_create');
    }

    if(empty($discussion_id)) {

      $this->addElement('Text', 'video', array(
        'label'=> 'Paste the web address of the video here.',
        'onblur' => "iframelyurl();",
      ));

      $this->addElement('Text', 'link', array(
        'label'=> 'Link URL',
        'onblur' => "linkurl();",
      ));

      $this->addElement('File', 'photo', array(
        'label' => 'Photo',
        'onchange' => 'showReadImage(this, "photo_preview")',
        'accept'=>"image/*",
      ));
    }

    $path = '';
    if(!empty($discussion_id) && $discussion->photo_id) {

      $this->addElement('File', 'photo', array(
        'label' => 'Photo',
        'onchange' => 'showReadImage(this, "photo_preview")',
        'accept'=>"image/*",
      ));


      $img_path = Engine_Api::_()->storage()->get($discussion->photo_id, '');
      if($img_path) {
        $path = $img_path->getPhotoUrl();
      }
    }
    //if($path) {
      $this->addElement('Image', 'photo_preview', array(
        'label' => 'Image Preview',
        'width' => 500,
        'src' => $path,
        'height' => 500,
        'disable' => true
      ));
    //}
    $this->addElement('Text', 'discussiontitle', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '255'))
      ),
    ));

    if(empty($editortype)) {
      $this->addElement('Textarea', 'title', array(
        'label' => 'Discussion',
        'allowEmpty' => false,
        'required' => true,
        'maxlength' => $descriptionlimit,
        'filters' => array(
          'StripTags',
          new Engine_Filter_Censor(),
          new Engine_Filter_EnableLinks(),
          new Engine_Filter_StringLength(array('max' => $descriptionlimit)),
        ),
      ));
    } else {

      $allowed_html = 'blockquote, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe';
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);

      $editorOptions = array(
        'upload_url' => $upload_url,
        'html' => (bool) $allowed_html,
      );

      if (!empty($upload_url)) {
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

      $this->addElement('TinyMce', 'title', array(
        'label' => 'Discussion',
        'required' => true,
        'allowEmpty' => false,
        'class' => 'tinymce',
        'editorOptions' => $editorOptions,
      ));

    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.enablecategory', 1)) {

      if($settings->getSetting('sesdiscussion.categoryrequried', 0)) {
        $required = true;
        $allowEmpty = false;
      } else {
        $required = false;
        $allowEmpty = true;
      }

      //Category
      $categories = Engine_Api::_()->getDbtable('categories', 'sesdiscussion')->getCategoriesAssoc();
      if (count($categories) > 0) {

        $categories = array('' => 'Choose Category') + $categories;
        $this->addElement('Select', 'category_id', array(
          'label' => 'Category',
          'multiOptions' => $categories,
          'allowEmpty' => $allowEmpty,
          'required' => $required,
          'onchange' => "showSubCategory(this.value);",
        ));

        //Add Element: 2nd-level Category
        $this->addElement('Select', 'subcat_id', array(
          'label' => "2nd-level Category",
          'allowEmpty' => $allowEmpty,
          'required' => $required,
          'multiOptions' => array('0' => ''),
          'registerInArrayValidator' => false,
          'onchange' => "showSubSubCategory(this.value);"
        ));

        //Add Element: Sub Sub Category
        $this->addElement('Select', 'subsubcat_id', array(
          'label' => "3rd-level Category",
          'allowEmpty' => $allowEmpty,
          'registerInArrayValidator' => false,
          'required' => $required,
          'multiOptions' => array('0' => ''),
        ));
      }
    }

    // init to
    $this->addElement('Text', 'tags', array(
      'label'=>'Tags',
      'autocomplete' => 'off',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));
    $this->tags->getDecorator("Description")->setOption("placement", "append");


    $this->addElement('Hash', 'token', array(
      'timeout' => 3600,
    ));

    $this->addElement('Hidden', 'photolink', array(
      'order' => 9999,
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Post Discussion',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    if($createform) {
      $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onclick' => 'javascript:sessmoothboxclose();',
        'decorators' => array(
          'ViewHelper'
        )
      ));
      $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
      $button_group = $this->getDisplayGroup('buttons');
    }
  }
}
