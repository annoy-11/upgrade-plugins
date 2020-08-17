<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CreateContent.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_Form_Admin_Tour_CreateContent extends Engine_Form {

  public function init() {
  
    $this->setTitle('Add New Tip')
        ->setDescription("From this page you can choose the widget on which the tip of this tour will show. For each tip you can enter title and description. You can also choose to redirect users to some other page by adding the URL for that page. To do so, you just have to enter the URL in the last tip of the tour of this page.")
        ->setMethod('post');
    
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', 0);
    $page_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('page_id', 0);
    $content_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('content_id', 0);
    
    if(empty($content_id))
      $getAllWidgets = Engine_Api::_()->sestour()->getAllWidgets($page_id, $id);
    else
      $getAllWidgets = Engine_Api::_()->sestour()->getAllWidgets($page_id);
    
    if($content_id) { 
      $this->addElement('Select', 'widget_id', array(
        'label' => 'Select Widget',
        'multiOptions' => $getAllWidgets,
        'allowEmpty' => true,
        'required' => false,
        'disabled' => true,
      ));
    } else {
      $this->addElement('Select', 'widget_id', array(
        'label' => 'Select Widget',
        'multiOptions' => $getAllWidgets,
        'allowEmpty' => false,
        'required' => true,
      ));
    }
    
    $this->addElement('Text', 'title', array(
        'label' => 'Title',
        'description' => 'Enter the title of the tour tip.',
        'allowEmpty' => true,
        'required' => false,
    ));
    
    $this->addElement('Textarea', 'description', array(
        'label' => 'Description',
        'description' => 'Enter the description of the tour tip.',
        'allowEmpty' => true,
        'required' => false,
    ));

    $this->addElement('Select', 'backdrop', array(
      'label' => 'Highlight with Overlay',
      'description' => "Do you want to highlight this tip with the dark overlay in background when the tour step reaches to this widget?",
      'multiOptions' => array(
        'true' => "Yes",
        'false' => "No",
      ),
    ));

    $this->addElement('Select', 'placement', array(
      'label' => 'Placement of the Tour Tip',
      'description' => 'Choose the placement of the tour tip. The tip will be placed at the selected position on this widget.',
      'multiOptions' => array(
        'right' => "Right Side",
        "left" => "Left Side",
        "top" => "Top",
        "bottom" => "Bottom",
      ),
    ));
    
    $this->addElement('Text', 'url', array(
        'label' => 'Next Page Redirect URL',
        'description' => 'If you want to redirect users to some other page after clicking on next button on this tip, then enter the URL of that page. But, if you do not want to redirect and want to stop the tour at current page, then leave this field blank. (Note: Enter the URL only if this is the last tip of the tour on this page, otherwise the next tip will never be shown. Also the redirected page has any tour, then that tour will work according to the setting of tour of that page tour.)',
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
        'href' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'index')),
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }
}