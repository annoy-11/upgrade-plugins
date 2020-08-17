<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Seo.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Form_Dashboard_Seo extends Engine_Form {

  public function init() {
    $this->setTitle('Add SEO')
            ->setAttrib('id', 'sescrowdfunding_ajax_form_submit')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->addElement('Text', 'seo_title', array(
        'label' => 'Crowdfunding SEO Title',
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
    // Crowdfunding Contact Email
    $this->addElement('Text', 'seo_keywords', array(
        'description' => 'Enter list of keywords separated by a comma (,)',
        'label' => 'Crowdfunding SEO Keywords',
    ));
    // Crowdfunding Contact Phone
    $this->addElement('Textarea', 'seo_description', array(
        'label' => 'Crowdfunding SEO Description',
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
