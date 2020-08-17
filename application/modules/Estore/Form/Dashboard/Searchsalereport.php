<?php

class Estore_Form_Dashboard_Searchsalereport extends Engine_Form {
 public function init() {
    if (Engine_Api::_()->core()->hasSubject('stores'))
      $store = Engine_Api::_()->core()->getSubject();
    //get current logged in user
    $user = Engine_Api::_()->user()->getViewer();
    $this->setTitle('')
            ->setAttrib('id', 'estore_search_form_sale_report')
						->setAttrib('class', 'global_form_box')
            ->setMethod("GET")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
//		$productDetails = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct')->getSesproductsSelect(array('fetchAll'=>'true','store_id'=>$store->store_id));
//		$productArray = array();
//     $productArray[''] = 'Choose Product';
//		if(count($productDetails)){
//		  foreach($productDetails as $valueTicket){
//              $productArray[$valueTicket['product_id']] = $valueTicket['title'];
//			}
//		}
//		$this->addElement('Select', 'eventTicketId', array(
//          'label' => 'Select Ticket',
//          'multiOptions' => $productArray,
//    ));
		$this->addElement('Select', 'type', array(
          'label' => 'Duration',
          'multiOptions' => array('month'=>'Month Wise','day'=>'Day Wise'),
					'value'=>'day',
    ));
		$this->addElement('Hidden', 'csv', array(
          'value'=>'',
					'order'=>10000
    ));
		$this->addElement('Hidden', 'excel', array(
          'value'=>'',
					'order'=>10001
    ));
		$this->addElement('Text', 'startdate', array(
        'label'=>'Start Date',
				'style'=>'width:70px;'
    ));
		$this->addElement('Text', 'enddate', array(
        'label'=>'End Date',
				'style'=>'width:70px;'
    ));
		// Buttons
    $this->addElement('Button', 'submit_form_sales_report', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
 }
}