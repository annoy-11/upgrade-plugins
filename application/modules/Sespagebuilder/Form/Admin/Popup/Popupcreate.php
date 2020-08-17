<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Popupcreate.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Popup_Popupcreate extends Engine_Form {

  public function init() {
  
    $this->loadDefaultDecorators();
    $this->setDescription('Below, choose the effect for the modal window to open and add content for the modal window.<br /><br />To add this modal window to any page: after creating it, get the shortcode from “Manage Modal Windows” section. Copy the shortcode and paste in the desired widgetized page [created using this plugin only].');
    $this->getDecorator('Description')->setOption('escape', false);
    $this->setMethod('post');
    $stringDes = '';
    $popupStyle = array('' => 'Select an Effect', 'mfp-zoom-in' => ' Zoom In', 'mfp-newspaper' => 'Zoom Roll', 'mfp-move-horizontal' => 'Move Horizontal', 'mfp-move-from-top' => 'Move From Top', 'mfp-3d-unfold' => 'Unfold', 'mfp-zoom-out' => 'Zoom Out');
    foreach ($popupStyle as $key => $val) {
      if (!$key)
        continue;
      $stringDes .= '<a class="sespagebuilder-popup-with-move-anim" style="margin-right:5px" data-effect="' . $key . '" href="#ses_test_form">' . $val . '</a>';
    }
    $this->addElement('Dummy', 'popupstyle', array(
        'description' => $stringDes,
        'label' => 'Example Modal Window Effects'
    ));
    $this->getElement('popupstyle')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    $this->addElement('Select', 'type', array(
        'label' => 'Modal Window Effect',
        'description' => 'Choose an effect for opening this modal window.',
        'multiOptions' => $popupStyle,
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Text', 'title', array(
        'label' => 'Modal Window Title',
        'description' => 'Enter title for the modal window. [Clicking on this title,the modal window will open.]',
        'allowEmpty' => false,
        'required' => true,
    ));
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

    $this->addElement('TinyMce', 'description', array(
        'label' => "Modal Window Content",
        'description' => 'Enter content for the modal window.',
        'editorOptions' => $editorOptions,
        'allowEmpty' => false,
        'required' => true,
    ));
    $this->addElement('Button', 'save', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Save & Exit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
  }

}