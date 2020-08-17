<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Form_Create extends Engine_Form {

  public function init()
  {
    $this->setTitle('Write New Note')
        ->setDescription('Write your new note entry below, then click "Create Note" to publish the entry to your note.')
        ->setAttrib('name', 'notes_create');

    $user = Engine_Api::_()->user()->getViewer();
    $userLevel = Engine_Api::_()->user()->getViewer()->level_id;

    $this->addElement('Text', 'title', array(
      'label' => 'Title',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_Censor(),
        'StripTags',
        new Engine_Filter_StringLength(array('max' => '63'))
      ),
      'autofocus' => 'autofocus',
    ));

    // init to
    $this->addElement('Text', 'tags', array(
      'label'=>'Tags (Keywords)',
      'autocomplete' => 'off',
      'description' => 'Separate tags with commas.',
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));

    $this->tags->getDecorator("Description")->setOption("placement", "append");

    $allowedHtml = 'blockquote, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe';
    $uploadUrl = "";

    if( Engine_Api::_()->authorization()->isAllowed('album', $user, 'create') ) {
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    }

    $editorOptions = array(
      'uploadUrl' => $upload_url,
      'html' => (bool) $allowedHtml,
    );


    $this->addElement('TinyMce', 'body', array(
      'label' => 'Description',
      'required' => true,
      'allowEmpty' => false,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

//     $this->addElement('TinyMce', 'body', array(
//       'label' => 'Description',
// //       'disableLoadDefaultDecorators' => true,
//       'required' => true,
//       'class'=>'tinymce',
//       'allowEmpty' => false,
// //       'decorators' => array(
// //         'ViewHelper'
// //       ),
//       'editorOptions' => $editorOptions,
//     ));

    $this->addElement('File', 'photo', array(
      'label' => 'Choose Profile Photo',
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    $availableLabels = array(
      'everyone'            => 'Everyone',
      'registered'          => 'All Registered Members',
      'owner_network'       => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member'        => 'Friends Only',
      'owner'               => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('pagenote', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if( count($viewOptions) == 1 ) {
        $this->addElement('hidden', 'auth_view', array( 'order' => 101, 'value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this note entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('pagenote', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if( count($commentOptions) == 1 ) {
        $this->addElement('hidden', 'auth_comment', array('order' => 102, 'value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this note entry?',
            'multiOptions' => $commentOptions,
            'value' => key($commentOptions),
        ));
        $this->auth_comment->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    $this->addElement('Select', 'draft', array(
      'label' => 'Status',
      'multiOptions' => array("0"=>"Published", "1"=>"Saved As Draft"),
      'description' => 'If this entry is published, it cannot be switched back to draft mode.'
    ));
    $this->draft->getDecorator('Description')->setOption('placement', 'append');

    $this->addElement('Checkbox', 'search', array(
      'label' => 'Show this note entry in search results',
      'value' => 1,
    ));
//     $this->addElement('Hash', 'token', array(
//       'timeout' => 3600,
//     ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Create Note',
      'type' => 'submit',
    ));
  }
}
