<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Searchreport.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Dashboard_Searchreport extends Engine_Form {

  public function init() {
    if (Engine_Api::_()->core()->hasSubject('epetition'))
      $page = Engine_Api::_()->core()->getSubject();
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('')
            ->setAttrib('id', 'epetition_search_form_sale_report')
            ->setAttrib('class', 'global_form_box')
            ->setMethod("GET")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $this->addElement('Select', 'type', array(
        'label' => 'Duration',
        'multiOptions' => array('week' => 'Week Wise', 'day' => 'Day Wise', 'month' => 'Month Wise'),
        'value' => 'week',
    ));
    $this->addElement('Hidden', 'csv', array(
        'value' => '',
        'order' => 10000
    ));
    $this->addElement('Hidden', 'excel', array(
        'value' => '',
        'order' => 10001
    ));
    $this->addElement('Text', 'startdate', array(
        'label' => 'Start Date',
        'style' => 'width:70px;'
    ));
    $this->addElement('Text', 'enddate', array(
        'label' => 'End Date',
        'style' => 'width:70px;'
    ));
    $this->addElement('Select', 'report_type', array(
        'label' => 'Report Format',
        'multiOptions' => array('excel' => 'Excel (.xls)', 'csv' => 'CSV'),
        'value' => 'excel',
    ));
    // Buttons
    $this->addElement('Button', 'submit_form_sales_report', array(
        'label' => 'Download Report',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
