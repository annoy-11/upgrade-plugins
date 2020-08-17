<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Oftheday.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageoffer_Form_Admin_Oftheday extends Engine_Form {

  public function init() {

    $param = Zend_Controller_Front::getInstance()->getRequest()->getParam('param');
    $this->setMethod('post')->setAttrib('class', 'global_form_box');

    $start = new Engine_Form_Element_CalendarDateTime('startdate');
    $start->setLabel("Start Date");
    $start->setAllowEmpty(false);
    $start->setRequired(true);
    $this->addElement($start);

    $end = new Engine_Form_Element_CalendarDateTime('enddate');
    $end->setLabel("End Date");
    $end->setRequired(true);
    $end->setAllowEmpty(false);
    $this->addElement($end);

    if (!$param) {
      $this->addElement('Checkbox', 'remove', array(
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
