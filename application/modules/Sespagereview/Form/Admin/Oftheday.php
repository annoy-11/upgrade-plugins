<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Oftheday.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Form_Admin_Oftheday extends Engine_Form {

  public function init() {

    $param = Zend_Controller_Front::getInstance()->getRequest()->getParam('param');

    $this->setTitle("Review of the Day")
            ->setDescription('Here, choose the start date and end date for this review to be displayed as "Review of the Day".')
            ->setMethod('post')
            ->setAttrib('class', 'global_form_box');

    $start = new Engine_Form_Element_CalendarDateTime('starttime');
    $start->setLabel("Start Date");
    $start->setAllowEmpty(false);
    $start->setRequired(true);
    $this->addElement($start);

    $end = new Engine_Form_Element_CalendarDateTime('endtime');
    $end->setLabel("End Date");
    $end->setRequired(true);
    $end->setAllowEmpty(false);
    $this->addElement($end);

    if (!$param) {
      $this->addElement('Checkbox', 'remove', array(
          'label' => "Remove as Review of the Day",
      ));
    }
    
    $this->addElement('Button', 'submit', array(
        'label' => 'Save',
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
