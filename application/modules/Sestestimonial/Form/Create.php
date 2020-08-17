<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Form_Create extends Engine_Form {

  public function init() {

    $this->setTitle('Write New Testimonial')
      ->setDescription('Write your Testimonial')
      ->setAttrib('name', 'sestestimonials_create');

    $user = Engine_Api::_()->user()->getViewer();
    $userLevel = Engine_Api::_()->user()->getViewer()->level_id;

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1)) {
        $this->addElement('Text', 'title', array(
            'label' => 'Title',
            'allowEmpty' => false,
            'required' => true,
            'filters' => array(
                new Engine_Filter_Censor(),
                'StripTags',
                new Engine_Filter_StringLength(array('max' => '500'))
            ),
        ));
    }

    $this->addElement('Textarea', 'description', array(
      'label' => 'Short Description',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '500'))
      ),
    ));

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.titleviewpage', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.longdes', 1)) {

        //UPLOAD PHOTO URL
        $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'manage', 'action' => "upload-image"), 'admin_default', true);

        $allowed_html = 'strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr';
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
        }

        $this->addElement('TinyMce', 'body', array(
            'label' => 'Detailed Description',
            'editorOptions' => $editorOptions,
        ));
    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.designation', 1)) {
        // init to
        $this->addElement('Text', 'designation', array(
        'label'=>'Designation',
        'description' => 'Enter Your Designation',
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
        ));
    }

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sestestimonial.rating', 1)) {
        $this->addElement('Select', 'rating', array(
            'label' => 'Rating',
            'multiOptions' => array(
                '5' => '5 Star',
                '4' => '4 Star',
                '3' => '3 Star',
                '2' => '2 Star',
                '1' => '1 Star',
            ),
        ));
    }

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Post Entry',
      'type' => 'submit',
    ));
  }
}
