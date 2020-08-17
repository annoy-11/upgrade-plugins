<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_Form_Admin_Filter extends Engine_Form {

  public function init() {
    $this
            ->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'))
    ;

    $this
            ->setAttribs(array(
                'id' => 'filter_form',
                'class' => 'global_form_box',
            ))
            ->setMethod('GET')
    ;

    // Element: query
    $this->addElement('Text', 'title', array(
        'label' => 'Search',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div')),
        ),
    ));

    // Element: gateway_id
    $gatewaysTable = Engine_Api::_()->getDbtable('gateways', 'payment');
    $select = $gatewaysTable->select()->from($gatewaysTable->info('name'))->where('enabled =?', 1);
    $multiOptions = array('' => '');
    foreach ($gatewaysTable->fetchAll($select) as $gateway) {
      $multiOptions[$gateway->gateway_id] = $gateway->title;
    }
    if ($multiOptions > 1) {
      $this->addElement('Select', 'gateway_id', array(
          'label' => 'Gateway',
          'multiOptions' => $multiOptions,
          'decorators' => array(
              'ViewHelper',
              array('Label', array('tag' => null, 'placement' => 'PREPEND')),
              array('HtmlTag', array('tag' => 'div')),
          ),
      ));
    }

//    // Element: type
//    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sesbusinesspackage');
//    $multiOptions = (array) $transactionsTable->select()
//                    ->from($transactionsTable->info('name'), 'gateway_type')
//                    ->distinct(true)
//                    ->query()
//                    ->fetchAll(Zend_Db::FETCH_COLUMN);
//
//    if (!empty($multiOptions)) {
//      $multiOptions = array_combine(
//              array_values($multiOptions), array_map('ucfirst', array_values($multiOptions))
//      );
//      if (false === $multiOptions) {
//        $multiOptions = array();
//      }
//    }
//    $multiOptions = array_merge(array('' => ''), $multiOptions);
//    $this->addElement('Select', 'type', array(
//        'label' => 'Type',
//        'multiOptions' => $multiOptions,
//        'decorators' => array(
//            'ViewHelper',
//            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
//            array('HtmlTag', array('tag' => 'div')),
//        ),
//    ));
    // Element: state
    $transactionsTable = Engine_Api::_()->getDbtable('transactions', 'sesbusinesspackage');
    $multiOptions = (array) $transactionsTable->select()
                    ->from($transactionsTable->info('name'), 'state')
                    ->distinct(true)
                    ->query()
                    ->fetchAll(Zend_Db::FETCH_COLUMN)
    ;
    if (!empty($multiOptions)) {
      $multiOptions = array_combine(
              array_values($multiOptions), array_map('ucfirst', array_values($multiOptions))
      );
      if (false === $multiOptions) {
        $multiOptions = array();
      }
    }
    $multiOptions = array_merge(array('' => ''), $multiOptions);
    $this->addElement('Select', 'state', array(
        'label' => 'State',
        'multiOptions' => $multiOptions,
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div')),
        ),
    ));


    // Element: order
    $this->addElement('Hidden', 'order', array(
        'order' => 10004,
    ));

    // Element: direction
    $this->addElement('Hidden', 'direction', array(
        'order' => 10005,
    ));

    // Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Search',
        'type' => 'submit',
        'decorators' => array(
            'ViewHelper',
            array('HtmlTag', array('tag' => 'div', 'class' => 'buttons')),
            array('HtmlTag2', array('tag' => 'div')),
        ),
    ));
  }

}
