<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Style.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Course_Dashboard_Style extends Engine_Form {
  public function init() {
    $this->setTitle('Styles')
        ->setMethod('post')
        ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    $this->removeDecorator('FormWrapper');
    // Element: style
    $this->addElement('Textarea', 'style', array(
        'label' => 'Custom Courses Styles',
        'description' => 'You can change the colors, fonts, and styles of your Courses by adding CSS code below. The contents of the text area below will be output between <style> tags on your course.'
    ));
//    $this->style->getDecorator('Description')->setOption('placement', 'APPEND');
    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
    ));

    // DisplayCourse: buttons
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
    ));

    $this->addElement('Hidden', 'id');
  }
}
