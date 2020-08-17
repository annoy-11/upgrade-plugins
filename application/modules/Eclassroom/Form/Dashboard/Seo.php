<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Seo.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Eclassroom_Form_Dashboard_Seo extends Engine_Form {

  public function init() {
    $this->setTitle('Add SEO')
            ->setAttrib('id', 'classroom_ajax_form_submit')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Classroom Contact Name
    $this->addElement('Text', 'seo_title', array(
        'label' => 'Classroom SEO Title',
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
    // Classroom Contact Email
    $this->addElement('Text', 'seo_keywords', array(
        'description' => 'Enter list of keywords seperated by a comma (,)',
        'label' => 'Classroom SEO Keywords',
    ));
    // Classroom Contact Phone
    $this->addElement('Textarea', 'seo_description', array(
        'label' => 'Classroom SEO Description',
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
