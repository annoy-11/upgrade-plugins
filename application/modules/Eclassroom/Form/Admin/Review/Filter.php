<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Filter.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Form_Admin_Review_Filter extends Engine_Form {

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
    $this->addElement('Text', 'classroom_title', array(
        'label' => 'Classroom Title',
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
        'decorators' => array('ViewHelper',array('HtmlTag', array('tag' => 'div'))),
    ));
    $this->addElement('Dummy','#loadingimgecourse', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" style="display:none;" id="courses-search-order-img" alt="Loading" />',
   ));
    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
