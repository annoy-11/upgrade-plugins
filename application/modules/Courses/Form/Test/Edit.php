<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Edit.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Test_Edit extends Courses_Form_Test_Create
{
  public function init() {
    parent::init();
     $translate = Zend_Registry::get('Zend_Translate');

    if (Engine_Api::_()->core()->hasSubject())
        $course = Engine_Api::_()->core()->getSubject();
    $this->submit->setLabel("Save Changes");
    $this->setTitle('Edit Test')
      ->setDescription('Edit your entry below, then click "Save Changes" to edit the Test.')->setAttrib('name', 'test_edit');
  }
}
