<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: EditAnswer.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Test_EditAnswer extends Courses_Form_Test_AddAnswer
{
  public function init() {
    parent::init();
     $translate = Zend_Registry::get('Zend_Translate');
    $this->setTitle('Edit Answer')
            ->setDescription('Please compose your new Answer below.')
            ->setAttrib('id', 'courses_edit_answer')
            ->setAttrib('class', 'global_form courses_smoothbox_editanswer');
    $this->submit->setLabel("Save Changes");
  }
}
