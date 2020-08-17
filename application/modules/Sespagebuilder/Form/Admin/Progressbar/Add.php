<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Add.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Progressbar_Add extends Engine_Form {

  public function init() {
    $this->setMethod('post');
    $this->setTitle('Create New Progress Bar Value');
    $this->setDescription('Below, add new value for the progress bar. You can also choose various design settings for column.');
    $column_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    $content_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    if ($column_id)
      $column = Engine_Api::_()->getItem('sespagebuilder_progressbarcontent', $column_id);

    $type = Engine_Api::_()->getItem('sespagebuilder_progressbar', $content_id)->type;

    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'description' => 'Enter title of the progress bar value.',
        'allowEmpty' => false,
        'required' => true,
    ));
    if ($type == 'bar') {
      $this->addElement('Select', 'title_allign', array(
          'label' => 'Title Alignment',
          'description' => 'Choose the alignment of the title.',
          'multioptions' => array('t' => 'Outside Left', 'c' => 'Inside Center', 'l' => 'Inside Left', 'r' => 'Inside Right', 'b' => 'Inside Bottom'),
      ));
    } else {
      $this->addElement('Select', 'title_allign', array(
          'label' => 'Title Alignment',
          'description' => 'Choose the alignment of the title.',
          'multioptions' => array('t' => 'Outside Left', 'c' => 'Inside Center', 'b' => 'Inside Bottom'),
      ));
    }
    $this->addElement('Text', 'value', array(
        'label' => 'Progress Bar Value [in %age]',
        'description' => 'Enter progress bar value in percentage.',
        'allowEmpty' => false,
        'required' => true,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', 'width', array(
        'label' => 'Width',
        'description' => 'Enter the width of progress bar value in pixels.',
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', 'title_color', array(
        'label' => 'Title Text Color',
        'description' => 'Choose and enter the title text color of the progress bar value.',
        'class' => 'SEScolor',
    ));
    $this->addElement('Text', 'empty_bg_color', array(
        'label' => 'Percentage Remaining Background Color',
        'description' => 'Choose and enter the percentage remaining (subtracted from 100) background color of the progress bar value.',
        'class' => 'SEScolor',
    ));
    $this->addElement('Text', 'filled_bg_color', array(
        'label' => 'Percentage Background Color',
        'description' => 'Choose and enter the percentage background color of the progress bar value.',
        'class' => 'SEScolor',
    ));
    if ($type == 'bar') {
      $this->addElement('Select', 'gradient_setting', array(
          'label' => 'Gradient Effect',
          'description' => 'Choose from below the gradient effect to be shown for percentage background color of the progress bar value.',
          'multioptions' => array('moving' => 'Gradient Moving', 'fixed' => 'Gradient Fixed', 'single' => 'Single Color'),
      ));
      $this->addElement('Text', 'height', array(
          'label' => 'Bar Height',
          'description' => 'Choose the height of the progress bar.',
          'validators' => array(
              array('Int', true),
              array('GreaterThan', true, array(0)),
          )
      ));
      $this->addElement('Select', 'show_radius', array(
          'label' => 'Circular Borders',
          'description' => 'Do you want the borders of the bar to be circular?',
          'multioptions' => array('1' => 'Yes', '0' => 'No'),
      ));
    } else {
      $this->addElement('Text', 'circle_width', array(
          'label' => 'Circle Radius',
          'description' => 'Enter the radius of the circle.',
      ));
      $this->addElement('Select', 'show_count', array(
          'label' => 'Show Percentage in Center',
          'description' => 'Do you want to show percentage value in center of the circle?',
          'multioptions' => array('1' => 'Yes', '0' => 'No'),
      ));
    }
    $this->addElement('Select', 'enable', array(
        'label' => 'Status',
        'description' => 'Do you want to enable this progress bar value?',
        'multioptions' => array('1' => 'Yes', '0' => 'No'),
    ));
    $this->addElement('Button', 'save', array(
        'label' => 'Add',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Save & Exit',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage-progressbar', 'content_id' => $content_id)),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('save', 'submit', 'cancel'), 'buttons');
  }

}
