<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Editquestion.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Test_Editquestion extends Courses_Form_Test_Addquestion
{
  public function init() {
    parent::init();
     $translate = Zend_Registry::get('Zend_Translate');
    $this->setTitle('Edit Question')
            ->setDescription('Update your question and click on the SAVE CHANGES button.')
            ->setAttrib('id', 'courses_edit_question')
            ->setAttrib('class', 'global_form courses_smoothbox_editquestion');
    $this->submit->setLabel("Save Changes");
  }
}
