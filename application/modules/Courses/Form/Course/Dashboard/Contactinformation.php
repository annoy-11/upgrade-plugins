<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Contactinformation.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_Course_Dashboard_Contactinformation extends Engine_Form {

  public function init() {
    $this->setTitle('Information')
            ->setDescription('Here, you can add your contact details. These details will be visible to other users of this site at various places so that they can easily reach out to you.')
            ->setAttrib('id', 'courses_ajax_form_submit')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Name
    $this->addElement('Text', 'course_contact_name', array(
        'label' => 'Name',
        'allowEmpty' => false,
        'required' => true,
        'placeholder'=>'Enter your name.',
        'validators' => array(
            array('NotEmpty', true),
            array('StringLength', false, array(1, 64)),
        ),
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));
    // Email
    $this->addElement('Text', 'course_contact_email', array(
        'label' => 'Email',
        'placeholder'=>'Enter your email id.',
    ));
    // Phone
    $this->addElement('Text', 'course_contact_phone', array(
        'label' => 'Phone',
        'placeholder'=>'Enter your Contact Number.',

    ));
    // Website
    $this->addElement('Text', 'course_contact_website', array(
        'label' => 'Website URL',
        'placeholder'=>'Enter your Website URL.',

    ));
    // Facebook
    $this->addElement('Text', 'course_contact_facebook', array(
        'label' => 'Facebook URL',
         'placeholder'=>'Enter your Facebook URL.',

    ));
    // Linkedin
    $this->addElement('Text', 'course_contact_linkedin', array(
        'label' => 'Linkedin URL',
        'placeholder'=>'Enter your LinkedIn URL.',
    ));
    // twitter
    $this->addElement('Text', 'course_contact_twitter', array(
        'label' => 'Twitter URL',
        'placeholder'=>'Enter your Twitter URL.',
    ));
    // twitter
    $this->addElement('Text', 'course_contact_instagram', array(
        'label' => 'Instagram URL',
        'placeholder'=>'Enter your Instagram URL.',
    ));
    // twitter
    $this->addElement('Text', 'course_contact_pinterest', array(
        'label' => 'Pinterest URL',
        'placeholder'=>'Enter your Pinterest URL.',
    ));
    $this->addElement('Text', 'instructor_qualifications', array(
        'label' => 'Add qualification (Separate qualification with commas)',
        'placeholder'=>'Enter your qualification.',
    ));
    $this->addElement('Text', 'working_profiles', array(
        'label' => 'Add Working Profile (Separate Working Profile with commas)',
        'placeholder'=>'Enter your Working Profile.',
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
