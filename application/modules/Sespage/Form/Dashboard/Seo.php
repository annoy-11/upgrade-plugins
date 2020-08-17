<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Seo.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Form_Dashboard_Seo extends Engine_Form {

  public function init() {
    $this->setTitle('Add SEO')
            ->setAttrib('id', 'sespage_ajax_form_submit')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Page Contact Name
    $this->addElement('Text', 'seo_title', array(
        'label' => 'Page SEO Title',
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
    // Page Contact Email
    $this->addElement('Text', 'seo_keywords', array(
        'description' => 'Enter list of keywords seperated by a comma (,)',
        'label' => 'Page SEO Keywords',
    ));
    // Page Contact Phone
    $this->addElement('Textarea', 'seo_description', array(
        'label' => 'Page SEO Description',
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
