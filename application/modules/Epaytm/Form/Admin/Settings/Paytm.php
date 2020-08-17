<?php
 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epaytm
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Paytm.php 2019-11-05 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Epaytm_Form_Admin_Settings_Paytm extends Engine_Form {
  public function init() {
    $this->setTitle('Payment Gateway: Paytm');
    $description = $this->getTranslator()->translate('EPAYTM_FORM_ADMIN_GATEWAY_PAYTM_DESCRIPTION');
     $description = vsprintf($description, array('https://dashboard.stripe.com/register'));
    $this->setDescription($description);
    // Decorators
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    $this->setTitle('Manage Your Paytm Account');
    $this->addElement('Text', "paytm_marchant_id", array(
        'label' => 'Paytm Merchant ID',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('Text', "paytm_secret_key", array(
        'label' => 'Paytm Account Secret Key',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('Text', "paytm_website", array(
        'label' => 'Website',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('Text', "paytm_industry_type", array(
        'label' => 'Industry Type',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->addElement('Text', "paytm_channel_id", array(
        'label' => 'Channel Id',
        'description'=> 'This parameter is used to control the theme of the payment page. Based on the channel passed, Paytm will render the layout           suitable for that specific platform<br />
        For websites, the value is WEB<br />
        For Mobile websites/App, the value is WAP',
        'required' => true,
        'allowEmpty' => false,
    ));
    $this->paytm_channel_id->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    $this->addElement('Radio', "enabled", array(
            'label' => 'Enable?',
            'multiOptions' => array('1' => 'Yes', '0' => 'No'),
    ));
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
