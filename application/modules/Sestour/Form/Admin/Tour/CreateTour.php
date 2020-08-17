<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreateTour.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_Form_Admin_Tour_CreateTour extends Engine_Form {

  public function init() {

    $this->setTitle('Create New Tour')
        ->setDescription("Choose a widgetized page from the dropdown for which you want to create the introduction tour.")
        ->setMethod('post');

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    
    if($id) {
      $all_widgetize_pages = Engine_Api::_()->sestour()->getAllWidgetizePages($id);
      $this->addElement('Select', 'page_id', array(
        'multiOptions' => $all_widgetize_pages,
        'allowEmpty' => true,
        'required' => false,
        'disabled' => true,
      ));
    } else {
      $all_widgetize_pages = Engine_Api::_()->sestour()->getAllWidgetizePages();
      $this->addElement('Select', 'page_id', array(
        'multiOptions' => $all_widgetize_pages,
        'allowEmpty' => false,
        'required' => true,
      ));
    }
    
    $this->addElement('Select', 'showpreviousbutton', array(
      'description' => 'Do you want to show the Previous button in this tour?',
      'multiOptions' => array(
        '1' => "Yes",
        "0" => "No",
      ),
    ));
    
    $this->addElement('Text', 'previousbutton_text', array(
      'description' => 'Enter the text for the "Previous" button in tour tip.',
      'allowEmpty' => true,
      'required' => false,
      'value' => 'Prev'
    ));
    
    $this->addElement('Select', 'shownextbutton', array(
      'description' => 'Do you want to show the Next button in this tour?',
      'multiOptions' => array(
        '1' => "Yes",
        "0" => "No",
      ),
    ));
    
    $this->addElement('Text', 'nextbutton_text', array(
      'description' => 'Enter the text for the "Next" button in tour tip.',
      'allowEmpty' => true,
      'required' => false,
      'value' => 'Next',
    ));
    
    $this->addElement('Select', 'showpausebutton', array(
      'description' => 'Do you want to show the Pause and Resume button in this tour?',
      'multiOptions' => array(
        '1' => "Yes",
        "0" => "No",
      ),
    ));
    
    $this->addElement('Text', 'pausebutton_text', array(
      'description' => 'Enter the text for the "Pause" button in tour tip.',
      'allowEmpty' => true,
      'required' => false,
      'value' => 'Pause',
    ));

    $this->addElement('Text', 'resumebutton_text', array(
      'description' => 'Enter the text for the "Resume" button in tour tip.',
      'allowEmpty' => true,
      'required' => false,
      'value' => 'Resume',
    ));
    
    $this->addElement('Select', 'showendbutton', array(
      'description' => 'Do you want to show the End button in this tour?',
      'multiOptions' => array(
        '1' => "Yes",
        "0" => "No",
      ),
    ));
    
    $this->addElement('Text', 'endbutton_text', array(
      'description' => 'Enter the text for the "End" button in tour tip.',
      'allowEmpty' => true,
      'required' => false,
      'value' => 'End Tour',
    ));
    
    $this->addElement('Select', 'automaticopen', array(
      'description' => "Do you want to show introduction tour automatically whenever user visits this page?",
      'multiOptions' => array(
        'true' => 'Yes, automatically start tour for 1st time. After this users will click on the "Start Tour" button.',
        'false' => 'Yes, start tour automatically whenever user visit this page.',
        'nostart' => 'No, do not start automatically. Users will click on the “Start Tour” button.',
      ),
    ));
    
    $this->addElement('Select', 'showstartbutton', array(
      'description' => 'Do you want to show the "Start Tour" button? (This setting will work if the tour will start automatically.)',
      'multiOptions' => array(
        '1' => "Yes",
        "0" => "No",
      ),
    ));
    
    $this->addElement('Text', 'duration', array(
      'description' => 'Enter the duration for staying on 1 step of tour in milliseconds. After this time, users will be automatically sent to the next step of the tour.',
      'allowEmpty' => true,
      'required' => false,
      'value' => '5000',
    ));
    
    
    
    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}