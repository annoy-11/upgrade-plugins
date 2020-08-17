<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvancedheader
 * @package    Sesadvancedheader
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CustomHeader.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesadvancedheader_Form_Admin_CustomHeader extends Engine_Form {

  public function init() {

    $this->setTitle('Add New Custom Color Scheme');
    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
        'label' => 'Enter the new color scheme name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    $customheader_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customheader_id', 0);
    if(!$customheader_id){
      $getCustomHeaders = Engine_Api::_()->getDbTable('headers', 'sesadvancedheader')->getHeader();
    foreach($getCustomHeaders as $getCustomHeader){
      $sesheader[$getCustomHeader['header_id']] = $getCustomHeader['name'];
    }
    $this->addElement('Select', 'customheaderid', array(
        'label' => 'Choose From Existing Color Scheme',
        'multiOptions' => $sesheader,
        'escape' => false,
    ));
    }
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
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
