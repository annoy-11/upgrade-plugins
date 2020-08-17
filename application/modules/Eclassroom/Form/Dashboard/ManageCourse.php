<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: ManageCourse.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Dashboard_ManageCourse extends Engine_Form {
  public function init() {
    $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));
    $this->setAttribs(array('id' => 'courses_filter_form', 'class' => 'global_form_box'))->setMethod('GET');
    $this->addElement('Text', 'title', array(
        'label' => 'Course Title',
        'placeholder' => 'Enter Course Title',
    ));
    $subform = new Engine_Form(array(
        'description' => 'Creation Date Ex (yyyy-mm-dd)',
        'elementsBelongTo'=> 'date',
        'decorators' => array(
            'FormElements',
            array('Description', array('placement' => 'PREPEND', 'tag' => 'label', 'class' => 'form-label')),
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-wrapper', 'id' =>'integer-wrapper'))
        )
    ));
    $subform->addElement('Text', 'date_to', array('placeholder'=>'to','autocomplete'=>'off'));
    $subform->addElement('Text', 'date_from', array('placeholder'=>'from','autocomplete'=>'off'));
    $this->addSubForm($subform, 'date');
    $categories = Engine_Api::_()->getDbtable('categories', 'courses')->getCategory(array('column_name' => '*'));
		$data[''] = 'Choose a Category';
      foreach ($categories as $category) {
        $data[$category['category_id']] = $category['category_name'];
				$categoryId = $category['category_id'];
      }
    if (count($categories) > 1) {
      $this->addElement('Select', 'category_id', array(
          'label' => "Category",
          'required' => false,
          'multiOptions' => $data,
          'onchange' => "showSubCategory(this.value)",
      ));
    }
    $this->addElement('Button', 'manage_course_search_form', array(
        'label' => 'Search',
        'type' => 'submit',
        'ignore' => true,
    ));
     $this->addElement('Dummy','#loadingimge', array(
        'content' => '<img src="application/modules/Core/externals/images/loading.gif" id="courses-search-order-img" alt="Loading" style="display:none;"/>',
   ));
  /*  $this->addElement('Hidden', 'order', array(
        'order' => 10004,
    ));
    $this->addElement('Hidden', 'order_direction', array(
        'order' => 10002,
    ));

    $this->addElement('Hidden', 'event_id', array(
        'order' => 10003,
    ));*/

    //Set default action without URL-specified params
    $params = array();
    foreach (array_keys($this->getValues()) as $key) {
      $params[$key] = null;
    }
    $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
  }

}
