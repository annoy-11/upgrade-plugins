<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Search.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Form_Signature extends Engine_Form {

  public function init() {
   $this
      ->setMethod("POST")
      ->setAttrib('name', 'sesgroupforum_edit_signature')
      ->setTitle('Edit Signature')
      ->setDescription("Edit your signature using the editor below, and click on 'Save Signature' to save changes.")
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $viewer = Engine_Api::_()->user()->getViewer();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $allowHtml = (bool) $settings->getSetting('sesgroupforum_html', 0);
    $allowBbcode = (bool) $settings->getSetting('sesgroupforum_bbcode', 0);

    if( !$allowHtml ) {
      $filter = new Engine_Filter_HtmlSpecialChars();
    } else {
      $filter = new Engine_Filter_Html();
      $filter->setForbiddenTags();
      $allowedTags = array_map('trim', explode(',', Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroupforum', 'commentHtml')));
      $filter->setAllowedTags($allowedTags);
    }

    if( $allowHtml || $allowBbcode ) {
      $uploadUrl = "";
      if( Engine_Api::_()->authorization()->isAllowed('album', $viewer, 'create') ) {
        $uploadUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
      }

      $editorOptions = array(
        'uploadUrl' => $uploadUrl
      );

      if( $allowHtml ) {
        $editorOptions = array_merge($editorOptions, array('html' => 1));
      } else {
        $editorOptions = array_merge($editorOptions, array('html' => 0, 'bbcode' => 1));
      }

    $allowedHtml = 'blockquote, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe';
    $this->addElement('TinyMce', 'body', array(
      'disableLoadDefaultDecorators' => true,
      'required' => true,
      'allowEmpty' => false,
      'decorators' => array(
        'ViewHelper'
      ),
      'editorOptions' => $editorOptions,
      'filters' => array(
        new Engine_Filter_Censor(),
        new Engine_Filter_Html(array('AllowedTags' => $allowedHtml))),
    ));
    } else {
      $this->addElement('textarea', 'body', array(
        'required' => true,
        'attribs' => array(
          'rows' => 24,
          'cols' => 80,
          'style' => 'width:553px; max-width:553px; height:158px;'
        ),
        'allowEmpty' => false,
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        ),
      ));
    }



    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));
    $this->addDisplayGroup(array('submit'), 'buttons');
    $buttonGroup = $this->getDisplayGroup('buttons');
    $buttonGroup->addDecorator('DivDivDivWrapper');
  }
}
