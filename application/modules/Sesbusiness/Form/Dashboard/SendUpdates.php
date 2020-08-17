<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SendUpdates.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Dashboard_SendUpdates extends Engine_Form {

  public function init() {

    $this->setTitle('Send Updates')
          ->setDescription('Send updated to all who liked, followed and joined your this business.')
          ->setAttrib('id', 'send_updates');

//     $this->addElement('MultiCheckbox', 'sm_header_nonloggedin_options', array(
//       'label' => 'Show Header Options to Non Logged-in users?',
//       'description' => 'Choose from below the header options that you want to be shown to Non Logged-in users on your website.',
//       'multiOptions' => array(
//           'search' => 'Search',
//           'miniMenu' => 'Mini Menu',
//           'mainMenu' =>'Main Menu',
//           'logo' =>'Logo',
//       ),
//     ));

    $this->addElement('MultiCheckbox', 'type', array(
      'label' => 'Choose type of member which you eant to update.',
      'multiOptions' => array(
        'liked' => "Only Likes Member",
        'followed' => "Only Followed Members",
        'joined' => "Only Joined Members",
      ),
      'requried' => true,
      'allowEmpty' => false,
    ));

    // init title
    $this->addElement('Text', 'title', array(
      'label' => 'Subject',
      'requried' => true,
      'allowEmpty' => false,
      'filters' => array(
          new Engine_Filter_Censor(),
          new Engine_Filter_HtmlSpecialChars(),
      ),
    ));

    // init body - plain text
    $this->addElement('Textarea', 'body', array(
      'label' => 'Message',
      'required' => true,
      'allowEmpty' => false,
      'filters' => array(
          new Engine_Filter_HtmlSpecialChars(),
          new Engine_Filter_Censor(),
          new Engine_Filter_EnableLinks(),
      ),
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Send Message',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
        'onclick' => 'javascript:parent.Smoothbox.close()',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
        'decorators' => array(
        ),
    ));

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_id');
    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('resource_type');
    if ($id) {
      $item = Engine_Api::_()->getItem($type, $id);
      $this->addElement('Image', 'item_preview', array(
        'src' => $item->getPhotoUrl(),
      ));
    }
  }
}
