<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Approve.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sespageveroth_Form_Admin_Approve extends Engine_Form {

  public function init() {

    $param = Zend_Controller_Front::getInstance()->getRequest()->getParam('param');

    $this->setTitle("Approve This Request")
            ->setDescription('Are you sure you want to approve this request?')
            ->setMethod('post')
            ->setAttrib('class', 'global_form_box');

    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.enablecomment', 1)) {

      $this->addElement('Textarea', 'description', array(
        'label' => 'Comment',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
          new Engine_Filter_Censor(),
          'StripTags',
          new Engine_Filter_StringLength(array('max' => '5000'))
        ),
      ));
    }

    $this->addElement('Button', 'submit', array(
        'label' => 'Approve',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
