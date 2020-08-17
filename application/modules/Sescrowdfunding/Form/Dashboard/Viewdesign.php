<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Viewdesign.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Dashboard_Viewdesign extends Engine_Form {

  public function init() {

    $setting = Engine_Api::_()->getApi('settings', 'core');
    $translate = Zend_Registry::get('Zend_Translate');
    $viewer = Engine_Api::_()->user()->getViewer();
    if (Engine_Api::_()->core()->hasSubject('crowdfunding'))
      $crowdfunding = Engine_Api::_()->core()->getSubject();
    //get current logged in user
    $this->setTitle('Profile Crowdfunding Layouts')
            ->setDescription('')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");

    $chooselayoutVal = json_decode(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'crowdfunding', 'select_pagestyle'));

    $designoptions = array();
    if (in_array(1, $chooselayoutVal)) {
      $designoptions[1] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_1.jpg" alt="" /></span> ' . $translate->translate("Design 1");
    }
    if (in_array(2, $chooselayoutVal)) {
      $designoptions[2] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_2.jpg" alt="" /></span> ' . $translate->translate("Design 2");
    }
    if (in_array(3, $chooselayoutVal)) {
      $designoptions[3] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_3.jpg" alt="" /></span> ' . $translate->translate("Design 3");
    }
    if (in_array(4, $chooselayoutVal)) {
      $designoptions[4] = '<span><img src="./application/modules/Sescrowdfunding/externals/images/layout_4.jpg" alt="" /></span> ' . $translate->translate("Design 4");
    }

    $this->addElement('Radio', 'pagestyle', array(
        'label' => 'Crowdfunding Profile Page Layout',
        'description' => 'Set Your Page Template',
        'multiOptions' => $designoptions,
        'escape' => false,
        'value' => '',
    ));
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
  }
}
