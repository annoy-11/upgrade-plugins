<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: SendUpdates.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Dashboard_SendUpdates extends Engine_Form {

  public function init() {

    $this->setTitle('Send Updates')
          ->setDescription('Send updated to all who liked, followed and joined your this classroom.')
          ->setAttrib('id', 'send_updates');
    $this->addElement('MultiCheckbox', 'type', array(
      'label' => 'Choose type of member which you want to update.',
      'multiOptions' => array(
        'liked' => "Only Liked Member",
        'followed' => "Only Followed Members",
        //'joined' => "Only Joined Members",
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
