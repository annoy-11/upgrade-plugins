<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Form_Topic_Create extends Engine_Form
{
  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    $this->setMethod("POST");
    $this->setAttrib('name', 'sesgroupforum_post_create');
    $this->addElement('Text', 'title', array(
      'label' => 'Topic Title',
      'allowEmpty' => false,
      'required' => true,
    ));
     $tag = $settings->getSetting('sesgroupforum.tag.mandatory', 1);
     if($tag == 1) {
        $required = true;
        $allowEmpty = false;
     } else {
        $required = false;
        $allowEmpty = true;
     }

     $this->addElement('Text', 'tags', array(
      'label' => 'Tags (Keywords)',
      'allowEmpty' => $allowEmpty,
      'required' => $required,
      'description'=> 'Separate tags with commas.',
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
      ),
      'validators' => array(
        array('StringLength', true, array(1, 64)),
      ),
    ));

    $viewer = Engine_Api::_()->user()->getViewer();

    $allowHtml = (bool) $settings->getSetting('sesgroupforum.html', 0);
    $allowBbcode = (bool) $settings->getSetting('sesgroupforum.bbcode', 0);
    $enableWYSIWYG = $settings->getSetting('sesgroupforum.enable.WYSIWYG', 1);
    if( !$allowHtml ) {
      $filter = new Engine_Filter_HtmlSpecialChars();
    } else {
      $filter = new Engine_Filter_Html();
      $filter->setForbiddenTags();
      $allowedTags = array_map('trim', explode(',', Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'sesgroupforum', 'commentHtml')));
      $filter->setAllowedTags($allowedTags);
    }

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
        'editorOptions' => $editorOptions,
        'required' => true,
        'allowEmpty' => false,
        'decorators' => array('ViewHelper'),
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        ),
      ));
    } else {
      $this->addElement('textarea', 'body', array(
        'required' => true,
        'attribs' => array('rows' => 24, 'cols' => 80, 'style' => 'width:553px; max-width:553px;height:158px;'),
        'allowEmpty' => false,
        'filters' => array(
          $filter,
          new Engine_Filter_Censor(),
        ),
      ));
    }

//     $this->addElement('Checkbox', 'watch', array(
//       'label' => 'Send me notifications when other members reply to this topic.',
//       'value' => '1',
//     ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Post Topic',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $buttonGroup = $this->getDisplayGroup('buttons');
    $buttonGroup->addDecorator('DivDivDivWrapper');
  }
}
