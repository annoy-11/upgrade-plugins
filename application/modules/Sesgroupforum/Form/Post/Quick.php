<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Quick.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Form_Post_Quick extends Engine_Form
{
  public function init()
  {
    $this
      ->setTitle('Quick Reply')
      ->setAttrib('name', 'sesgroupforum_post_quick')
      ;

    $viewer = Engine_Api::_()->user()->getViewer();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $allowHtml = (bool) $settings->getSetting('sesgroupforum_html', 0);
    $allowBbcode = (bool) $settings->getSetting('sesgroupforum_bbcode', 0);
    $enableWYSIWYG = $settings->getSetting('sesgroupforum.enable.WYSIWYG', 1);

    $filter = new Engine_Filter_Html();
    $allowedTags = explode(',', Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroupforum', 'commentHtml'));

    if( $settings->getSetting('sesgroupforum_html', 0) == '0' ) {
      $filter->setForbiddenTags();
      $filter->setAllowedTags($allowedTags);
    }

    // Element: body
    if(($allowHtml || $allowBbcode) && $enableWYSIWYG) {

      $uploadUrl = "";

      if( Engine_Api::_()->authorization()->isAllowed('album', $viewer, 'create') ) {
        $uploadUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action'=>'upload-photo'), 'sesgroupforum_photo', true);

      }

      $editorOptions = array(
        'uploadUrl' => $uploadUrl
      );

      if( $allowHtml ) {
        $editorOptions = array_merge($editorOptions, array('html' => 1));
      } else {
        $editorOptions = array_merge($editorOptions, array('html' => 0, 'bbcode' => 1));
      }

      $this->addElement('TinyMce', 'body', array(
        'disableLoadDefaultDecorators' => true,
        'required' => true,
        'editorOptions' => $editorOptions,
        'allowEmpty' => false,
        'decorators' => array('ViewHelper'),
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        )
      ));
    } else {
    $this->addElement('textarea', 'body', array(
        'label' => 'Quick Reply',
        'required' => true,
        'allowEmpty' => false,
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        ),
      ));
    }

    // Element: photo
    // Need this hack for some reason
    $this->addElement('File', 'photo', array(
      'attribs' => array('style' => 'display:none;')
    ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Post Reply',
      'type' => 'submit',
    ));
  }
}
