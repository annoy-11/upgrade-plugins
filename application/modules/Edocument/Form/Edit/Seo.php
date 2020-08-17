<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Seo.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Form_Edit_Seo extends Engine_Form {

  public function init() {

    $this->setTitle('SEO Details')
    ->setAttrib('id', 'edocument_ajax_form_submit')
    ->setMethod("POST")
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    // Document Contact Name
    $this->addElement('Text', 'seo_title', array(
      'label' => 'SEO Title',
      'allowEmpty' => false,
      'required' => true,
      'validators' => array(
        array('NotEmpty', true),
        array('StringLength', false, array(1, 255)),
      ),
      'filters' => array(
        'StripTags',
        new Engine_Filter_Censor(),
      ),
    ));

    $this->addElement('Text', 'seo_keywords', array(
      'description'=>'Enter list of keywords seperated by a comma (,)',
      'label' => 'SEO Keywords',
    ));

    $this->addElement('Textarea', 'seo_description', array(
      'label' => 'SEO Description',
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array(
	'ViewHelper',
      ),
    ));
  }
}
