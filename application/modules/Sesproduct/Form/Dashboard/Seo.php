<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Seo.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Form_Dashboard_Seo extends Engine_Form {

  public function init() {

    $this->setTitle('SEO Details')
    ->setAttrib('id', 'sesproduct_ajax_form_submit')
    ->setMethod("POST")
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
    // Product Contact Name
    $this->addElement('Text', 'seo_title', array(
      'label' => 'SEO Title',
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

//    $this->addDisplayGroup(array('submit'), 'buttons', array(
//      'decorators' => array(
//	'FormElements',
//	'DivDivDivWrapper',
//      ),
//    ));
  }
}
