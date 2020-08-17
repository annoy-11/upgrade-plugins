<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filter.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Course_Review_Filter extends Engine_Form {

  public function init() {
    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');
    $this->addElement('Text', 'title', array(
        'label' => 'Review Title',
    ));
    $this->addElement('Text', 'course_title', array(
        'label' => 'Course Title',
    ));
    $this->addElement('Select', 'rating_star', array(
        'label'=>'Rating Star',
				'MultiOptions'=>array(''=>'Select','1'=>'One Star','2'=>'Two Star','3'=>'Three Star','4'=>'Four Star','5'=>'Five Star'),
    ));
    $this->addElement('Select', 'featured', array(
        'label'=>'Featured',
				'MultiOptions'=>array(''=>'Select','1'=>'Yes','0'=>'No'),
    ));
    $this->addElement('Select', 'verified', array(
        'label'=>'Verified',
				'MultiOptions'=>array(''=>'Select','1'=>'Yes','0'=>'No'),
    ));
    $this->addElement('Select', 'oftheday', array(
        'label'=>'Of The Day',
				'MultiOptions'=>array(''=>'Select','1'=>'Yes','0'=>'No'),
    ));
    $this->addElement('Button', 'search', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
