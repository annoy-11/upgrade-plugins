<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Creatememberrole.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Admin_Classroom_Creatememberrole extends Engine_Form {

  public function init() {

    parent::init();

    // My stuff
    $this->setTitle('Create Classroom Roles')
            ->setDescription('');
    $class = '';


    $this->addElement('Text', 'title', array(
        'label' => 'Classroom Role Title',
        'allowEmpty'=>false,
        'required'=>true,
        'description' => '',
    ));

     // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
