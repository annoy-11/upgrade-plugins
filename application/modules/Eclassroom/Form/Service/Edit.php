<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Edit.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Service_Edit extends Eclassroom_Form_Service_Add {

  public function init() {
    parent::init();
    $this->setTitle('Edit Service')
      ->setDescription('')
      ->setAttrib('name', 'classroomservice_addservice')
      ->setAttrib('class', 'classroomservice_formcheck global_form');
    $this->submit->setLabel('Save Changes');
  }
}
