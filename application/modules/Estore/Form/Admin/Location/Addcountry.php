<?php
class Estore_Form_Admin_Location_Addcountry extends Engine_Form {

  public function init() {

    $this->setTitle('Add Country / States')
            ->setMethod('post')
            ->setAttrib('class', 'global_form_box global_form');


      $table = Engine_Api::_()->getDbtable('countries', 'estore');
      $select = $table->select()->order('name');
      $countries = array();
      foreach($table->fetchAll($select) as $val){
          $countries[$val["country_id"]] = $val['name'];
      }

    $this->addElement('Select', 'country', array(
        'label' => 'Country',
        'multiOptions' => $countries,
        'value' => key($countries),
    ));


    $this->addElement('Text', 'states', array(
        'label' => 'States',
        'style' => 'display:none;',
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Add States',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'cancel',
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