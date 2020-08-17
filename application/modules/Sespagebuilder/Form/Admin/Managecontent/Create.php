<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Create.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Managecontent_Create extends Engine_Form {

  public function init() {

    $request = Zend_Controller_Front::getInstance()->getRequest();

    $this->addElement('Text', 'title', array(
        'label' => 'Name',
        'description' => 'Enter a Name.',
        'allowEmpty' => false,
        'required' => true,
        'filters' => array(
            new Engine_Filter_Censor(),
            'StripTags',
            new Engine_Filter_StringLength(array('max' => '250'))
        ),
        'autofocus' => 'autofocus',
    ));
    if ($request->getControllerName() == 'admin-pricingtable') {
    
      $this->addElement('Text', 'table_name', array(
	  'label' => 'Pricing Table Name',
	  'description' => 'Enter the pricing table name. This name is for your indication only and will not be shown at user side.',
	  'allowEmpty' => false,
	  'required' => true,
	  'filters' => array(
	      new Engine_Filter_Censor(),
	      'StripTags',
	      new Engine_Filter_StringLength(array('max' => '250'))
	  ),
	  'autofocus' => 'autofocus',
      ));

      $this->addElement('Text', 'num_row', array(
          'label' => 'Number of Rows',
          'description' => 'Enter number of rows for this pricing table.',
          'allowEmpty' => false,
          'required' => true,
          'validators' => array(array('Int', true))
      ));

      $this->addElement('Textarea', 'description', array(
          'label' => 'Description',
          'description' => 'Enter the description for this pricing table.',
      ));

      $this->addElement('Radio', 'show_short_code', array(
          'label' => "Use As Short Code",
          'description' => "Do you want to use this as a short code? [Note: If you choose “Yes”, then you will be able to configure various design settings.]",
          'multioptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => 0,
          'onclick' => "showSettings(this.value);",
      ));

      $this->addElement('Text', 'row_height', array(
          'label' => "Enter the height of table row (in px).",
          'value' => '20',
      ));

      $this->addElement('Text', 'description_height', array(
          'label' => "Enter the height of description row (in px).",
          'value' => '20',
      ));

      $this->addElement('Radio', 'price_header', array(
          'label' => 'Show Price Section',
          'multiOptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => '1'
      ));

      $this->addElement('Radio', 'description_header', array(
          'label' => 'Show Description Section',
          'multiOptions' => array('1' => 'Yes', '0' => 'No'),
          'value' => '0'
      ));
    }
    if ($request->getControllerName() == 'admin-progressbars') {
      $column_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
      if (!$column_id) {
        $this->addElement('Select', 'type', array(
            'label' => 'Progress Bar Type',
            'description' => 'Choose the type of progress bar.',
            'multioptions' => array('bar' => 'Bar', 'circle' => 'Circle'),
            'allowEmpty' => false,
            'required' => true,
        ));
      }
    }

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    if ($request->getControllerName() == 'admin-manageaccordion') {
      $this->addElement('Cancel', 'cancel', array(
          'label' => 'cancel',
          'onclick' => 'javascript:parent.Smoothbox.close()',
          'link' => true,
          'prependText' => ' or ',
          'decorators' => array(
              'ViewHelper',
          ),
      ));

      $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    }
  }

}
