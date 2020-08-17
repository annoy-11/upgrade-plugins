<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Form_Create extends Engine_Form {

  public function init()
  {
    $this->setTitle('Write New Offer')
        ->setDescription('Write your new offer entry below, then click "Create Offer" to publish the entry to your offer.')
        ->setAttrib('name', 'offers_create');

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

    $allowedHtml = 'blockquote, strong, b, em, i, u, strike, sub, sup, p, div, pre, address, h1, h2, h3, h4, h5, h6, span, ol, li, ul, a, img, embed, br, hr, iframe';
    $uploadUrl = "";

    if( Engine_Api::_()->authorization()->isAllowed('album', $user, 'create') ) {
      $upload_url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesbasic', 'controller' => 'index', 'action' => "upload-image"), 'default', true);
    }

    $editorOptions = array(
      'uploadUrl' => $uploadUrl,
      'html' => (bool) $allowedHtml,
    );
    $this->addElement('TinyMce', 'body', array(
      'label' => 'Description',
      'required' => true,
      'allowEmpty' => false,
      'class'=>'tinymce',
      'editorOptions' => $editorOptions,
    ));

    $this->addElement('File', 'photo', array(
      'label' => 'Choose Profile Photo',
    ));
    $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

    $this->addElement('Select', 'offertype', array(
        'label' => 'Offer Type',
       /* 'description' => 'Choose offer type.',*/
        'multiOptions' => array(
            '1' => "Percentage",
            '2' => "Fixed"
        ),
        'allowEmpty' => false,
        'required' => true,
        'value' => 'percentage',
    ));

    $this->addElement('Text', 'offertypevalue', array(
      'label' => 'Offer Type Value',
      /*'description' => 'Enter offer value.',*/
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'couponcode', array(
      'label' => 'Coupon Code',
      /*'description' => 'Enter coupon code.',*/
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'offerlink', array(
      'label'=>'Offer Link',
     /* 'description' => 'Enter Offer Link',*/
      'allowEmpty' => false,
      'required' => true,
    ));

    $this->addElement('Text', 'totalquantity', array(
      'label' => 'Total Quantity',
      /*'description' => 'Enter number of quantity of this offer.',*/
      'allowEmpty' => false,
      'required' => true,
    ));

    $availableLabels = array(
      'everyone'            => 'Everyone',
      'registered'          => 'All Registered Members',
      'owner_network'       => 'Friends and Networks',
      'owner_member_member' => 'Friends of Friends',
      'owner_member'        => 'Friends Only',
      'owner'               => 'Just Me'
    );

    // Element: auth_view
    $viewOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('pageoffer', $user, 'auth_view');
    $viewOptions = array_intersect_key($availableLabels, array_flip($viewOptions));

    if( !empty($viewOptions) && count($viewOptions) >= 1 ) {
      // Make a hidden field
      if( count($viewOptions) == 1 ) {
        $this->addElement('hidden', 'auth_view', array( 'order' => 101, 'value' => key($viewOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_view', array(
            'label' => 'Privacy',
            'description' => 'Who may see this offer entry?',
            'multiOptions' => $viewOptions,
            'value' => key($viewOptions),
        ));
        $this->auth_view->getDecorator('Description')->setOption('placement', 'append');
      }
    }

    // Element: auth_comment
    $commentOptions = (array) Engine_Api::_()->authorization()->getAdapter('levels')->getAllowed('pageoffer', $user, 'auth_comment');
    $commentOptions = array_intersect_key($availableLabels, array_flip($commentOptions));

    if( !empty($commentOptions) && count($commentOptions) >= 1 ) {
      // Make a hidden field
      if( count($commentOptions) == 1 ) {
        $this->addElement('hidden', 'auth_comment', array('order' => 102, 'value' => key($commentOptions)));
      // Make select box
      } else {
        $this->addElement('Select', 'auth_comment', array(
            'label' => 'Comment Privacy',
            'description' => 'Who may post comments on this offer entry?',
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
      'label' => 'Show this offer entry in search results',
      'value' => 1,
    ));
//     $this->addElement('Hash', 'token', array(
//       'timeout' => 3600,
//     ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Create Offer',
      'type' => 'submit',
    ));
  }
}
