<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contactinformation.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusiness_Form_Dashboard_Contactinformation extends Engine_Form {

  public function init() {
    $this->setTitle('Information')
            ->setDescription('Here, you can add the contact details for your Business. These details will be visible to other users of this site at various places so that they can easily reach out to you.')

            ->setAttrib('id', 'sesbusiness_ajax_form_submit')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Name
    $this->addElement('Text', 'business_contact_name', array(
        'label' => 'Name',
        'allowEmpty' => false,
        'required' => true,
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
    $this->addElement('Text', 'business_contact_email', array(
        'label' => 'Email',
    ));
    // Phone
    $this->addElement('Text', 'business_contact_phone', array(
        'label' => 'Phone',
    ));
    // Website
    $this->addElement('Text', 'business_contact_website', array(
        'label' => 'Website URL',
    ));
    // Facebook
    $this->addElement('Text', 'business_contact_facebook', array(
        'label' => 'Facebook URL',
    ));
    // Linkedin
    $this->addElement('Text', 'business_contact_linkedin', array(
        'label' => 'Linkedin URL',
    ));
    // twitter
    $this->addElement('Text', 'business_contact_twitter', array(
        'label' => 'Twitter URL',
    ));
    // twitter
    $this->addElement('Text', 'business_contact_instagram', array(
        'label' => 'Instagram URL',
    ));
    // twitter
    $this->addElement('Text', 'business_contact_pinterest', array(
        'label' => 'Pinterest URL',
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
