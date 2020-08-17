<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Seo.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Course_Dashboard_Seo extends Engine_Form {

  public function init() {
    $this->setTitle('Add SEO')
            ->setAttrib('id', 'courses_ajax_form_submit')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Courses Contact Name
    $this->addElement('Text', 'seo_title', array(
        'label' => 'Courses SEO Title',
        'allowEmpty' => true,
        'required' => false,
        'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 64)),
        ),
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));
    // Courses Contact Email
    $this->addElement('Text', 'seo_keywords', array(
        'description' => 'Enter list of keywords seperated by a comma (,)',
        'label' => 'Courses SEO Keywords',
    ));
    // Courses Contact Phone
    $this->addElement('Textarea', 'seo_description', array(
        'label' => 'Courses SEO Description',
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }
}
