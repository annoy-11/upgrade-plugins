<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Viewdesign.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Dashboard_Viewdesign extends Engine_Form {

  public function init() {
    $setting = Engine_Api::_()->getApi('settings', 'core');
    $translate = Zend_Registry::get('Zend_Translate');
    $viewer = Engine_Api::_()->user()->getViewer();
    //get current logged in user
    $this->setTitle('Profile Classroom Layouts')
            ->setDescription('')
            ->setAttrib('enctype', 'multipart/form-data')
            ->setMethod("POST");
    $chooselayoutVal = json_decode(Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'eclassroom', 'select_bsstyle'));
    $designoptions = array();
    if (in_array(1, $chooselayoutVal)) {
      $designoptions[1] = '<span><img src="./application/modules/Courses/externals/images/layout_1.jpg" alt="" /></span> ' . $translate->translate("Design 1");
    }
    if (in_array(2, $chooselayoutVal)) {
      $designoptions[2] = '<span><img src="./application/modules/Courses/externals/images/layout_2.jpg" alt="" /></span> ' . $translate->translate("Design 2");
    }
    if (in_array(3, $chooselayoutVal)) {
      $designoptions[3] = '<span><img src="./application/modules/Courses/externals/images/layout_3.jpg" alt="" /></span> ' . $translate->translate("Design 3");
    }
    if (in_array(4, $chooselayoutVal)) {
      $designoptions[4] = '<span><img src="./application/modules/Courses/externals/images/layout_4.jpg" alt="" /></span> ' . $translate->translate("Design 4");
    }

    $this->addElement('Radio', 'classroomstyle', array(
        'label' => 'Classroom Profile Classroom Layout',
        'description' => 'Set Your Classroom Template',
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
