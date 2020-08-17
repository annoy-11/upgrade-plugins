<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Minimumshippingcost.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Dashboard_Minimumshippingcost extends Engine_Form {

  public function init() {
    $this->setTitle('&nbsp;&nbsp;Add Minimum Shipping Cost')
            ->setMethod("POST")
            ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()));
      $locale = Zend_Registry::get('Locale');
      $currencyName = Zend_Locale_Data::getContent($locale, 'nametocurrency', Engine_Api::_()->estore()->defaultCurrency());

      $this->addElement('Text', 'minimum_shipping_cost', array(
        'label' => 'Minimum Shipping Cost (In '.$currencyName.')',
        'allowEmpty' => true,
        'required' => false,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        ),
        'filters' => array(
            'StripTags',
            new Engine_Filter_Censor(),
        ),
    ));

    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array(
            'ViewHelper',
        ),
    ));
    $this->addDisplayGroup(array('submit'), 'buttons', array(
        'decorators' => array(
            'FormElements',
            'DivDivDivWrapper',
        ),
    ));
  }

}
