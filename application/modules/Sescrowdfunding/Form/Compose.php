<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Compose.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Compose extends Engine_Form
{
  public function init()
  {
    $this->setTitle('Compose Message');
    $this->setDescription('Create your new message with the form below. Your message can be addressed to up to 10 recipients.')
       ->setAttrib('id', 'messages_compose');
    $user = Engine_Api::_()->user()->getViewer();
    $userLevel = $user->level_id;

    // init to
    $this->addElement('Text', 'to', array(
        'label'=>'Send To',
        'autocomplete'=>'off'));

    Engine_Form::addDefaultDecorators($this->to);

    // Init to Values
    $this->addElement('Hidden', 'toValues', array(
      'label' => 'Send To',
      'required' => true,
      'allowEmpty' => false,
      //'order' => 2,
      'validators' => array(
        'NotEmpty'
      ),
      'filters' => array(
        'HtmlEntities'
      ),
    ));
    Engine_Form::addDefaultDecorators($this->toValues);

    // init title
    $this->addElement('Text', 'title', array(
      'label' => 'Subject',
      //'order' => 3,
      'filters' => array(
        new Engine_Filter_Censor(),
        new Engine_Filter_HtmlSpecialChars(),
      ),
    ));

    // init body - editor
    $editor = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('messages', $userLevel, 'editor');

    if( $editor == 'editor' ) {
      $uploadUrl = "";
      if( Engine_Api::_()->authorization()->isAllowed('album', $user, 'create') ) {
        $uploadUrl = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'upload-photo'), 'messages_general', true);
      }
      $editorOptions = array(
        'uploadUrl' => $uploadUrl,
        'bbcode' => true,
        'html' => true,
      );

      $this->addElement('TinyMce', 'body', array(
        'disableLoadDefaultDecorators' => true,
        //'order' => 4,
        'required' => true,
        'editorOptions' => $editorOptions,
        'allowEmpty' => false,
        'decorators' => array(
            'ViewHelper',
            'Label',
            array('HtmlTag', array('style' => 'display: block;'))),
        'filters' => array(
          new Engine_Filter_HtmlSpecialChars(),
          new Engine_Filter_Censor(),
        ),
      ));
    } else {
      // init body - plain text
      $this->addElement('Textarea', 'body', array(
        'label' => 'Message',
        //'order' => 4,
        'required' => true,
        'allowEmpty' => false,
        'filters' => array(
          new Engine_Filter_HtmlSpecialChars(),
          new Engine_Filter_Censor(),
          new Engine_Filter_EnableLinks(),
        ),
      ));
    }

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Send Message',
      //'order' => 5,
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      //'order' => 6,
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onclick' => 'parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');

  }
}
