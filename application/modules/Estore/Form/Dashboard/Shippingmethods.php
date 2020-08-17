<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Shippingmethods.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Dashboard_Shippingmethods extends Engine_Form {

  public function init() {
    $this
            ->setTitle('Create Shipping Method')
            ->setMethod('post')
            ->setAttrib('onsubmit','return submitShippingCreateForm(this);')
            ->setAttrib('id','estore_shipping_method_create')
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));

    $shipping = false;
      $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id');
    if($id){
        $shipping = Engine_Api::_()->getItem('estore_shippingmethod',$id);
    }
      $this->addElement('Text','title',array(
          'label'=>'Title',
          'description' => '',
          'allowEmpty'=>false,
          'required'=>true,
      ));
    $this->addElement('Text','delivery_time',array(
        'label'=>'Delivery Time',
        'description' => '',
        'allowEmpty'=>false,
        'required'=>true,
    ));

      $this->addElement('Text','title',array(
          'label'=>'Title',
          'description' => '',
          'allowEmpty'=>false,
          'required'=>true,
      ));
      $table = Engine_Api::_()->getDbtable('countries', 'estore');
      $select = $table->select()->where('status =?',1)->order('name');
      $countries = array('0'=>'All Countries');
      foreach($table->fetchAll($select) as $val){
          $countries[$val["country_id"]] = $val['name'];
      }

      $this->addElement('Select', 'country', array(
          'label' => 'Country',
          'multiOptions' => $countries,
          'value' => key($countries),
          'onchange'=>'changeCountriesShipping(this.value,this);'
      ));
      $this->addElement('Select', 'state', array(
          'label' => 'State',
          'disabled'=>'disabled',
      ));

      $this->addElement('Radio', 'location_type', array(
          'label' => 'Enable Shipping Method For All Locations',
          'multiOptions' => array("1" => "Yes", "0" => "No"),
          'value' => '0',
      ));
      $this->addElement('Multiselect', 'state_id', array(
          'allowEmpty' => true,
          'required' => false,
          'label' => 'States',
          'description' => '',
          'RegisterInArrayValidator' => false,
      ));

      $this->addElement('Select', 'types', array(
          'label' => 'Method Types',
          'multiOptions' => array(0=>'Cost & Weight','1'=>'Weight Only',2=>'Product Quantity & Weight'),
          'onChange'=>'changeTypeShipping(this.value)',
          'value' => 0,
      ));
      $this->addElement('Text', 'product', array(
          'label' => '',
          'decorators' => array(array('ViewScript', array(
              'viewScript' => '_productQuatity.tpl',
              'shipping' => $shipping,
              'class' => 'form element'))),
      ));

      $this->addElement('Text', 'cost', array(
          'label' => '',
          'decorators' => array(array('ViewScript', array(
              'viewScript' => '_shippingCost.tpl',
              'shipping' => $shipping,
              'class' => 'form element'))),
      ));

      $this->addElement('Text', 'weight', array(
          'label' => '',
          'decorators' => array(array('ViewScript', array(
              'viewScript' => '_shippingWeight.tpl',
              'shipping' => $shipping,
              'class' => 'form element'))),
      ));

      $this->addElement('Select', 'deduction_type', array(
          'label' => 'Deduction Type',
          'onchange'=>'changeDeductionType(this.value)',
          'multiOptions' => array(0=>'Per Item','1'=>'Per Order'),
          'value' => 0,
      ));

      $this->addElement('Select', 'price_type', array(
          'label' => 'Price Type',
          'onchange'=>'changePriceShipping(this.value)',
          'multiOptions' => array(0=>'Fixed','1'=>'Percentage'),
          'registerInArrayValidator' => false,
          'value' => 0,
      ));
      $locale = Zend_Registry::get('Locale');
      $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency());
      $this->addElement('Text', 'fixed_price', array(
          'label' => sprintf(Zend_Registry::get('Zend_Translate')->_('Price (%s)'), $currencyName),
          'allowEmpty' => false,
          'value' => '0',
          'filters' => array(
              'StripTags',
              new Engine_Filter_Censor(),
          ),
      ));

      $this->addElement('Text', 'percentage_price', array(
          'label' => 'Price (%)',
          'allowEmpty' => false,
          'value' => '0',
          'filters' => array(
              'StripTags',
              new Engine_Filter_Censor(),
          ),
      ));


      $this->addElement('Checkbox', 'status', array(
          'label' => "Do you want to enable this shipping method?",
          'value' => 1,
      ));

    // Element: submit
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
    ));



  }

}
