<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Otpsms
 * @package    Otpsms
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Otpsms.php  2018-11-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Otpsms_Form_Admin_Signup_Otpsms extends Engine_Form
{
  public function init()
  {
    // Get step and step number
    $stepTable = Engine_Api::_()->getDbtable('signup', 'user');
    $stepSelect = $stepTable->select()->where('class = ?', str_replace('_Form_Admin_', '_Plugin_', get_class($this)));
    $step = $stepTable->fetchRow($stepSelect);
    $stepNumber = 1 + $stepTable->select()
        ->from($stepTable, new Zend_Db_Expr('COUNT(signup_id)'))
        ->where('`order` < ?', $step->order)
        ->query()
        ->fetchColumn()
    ;
    $stepString = $this->getView()->translate('Step %1$s', $stepNumber);
    $this->setDisableTranslator(true);


    // Custom
    $this->setTitle($this->getView()->translate('%1$s: Mobile Phone Number Password Verification (OTP)', $stepString));

    $description = $this->getView()->translate('In the next step of the signup process, members will verify their mobile number. Click <a href="%s" target="_blank" >here</a> to enable mobile number during signup process.', Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'otpsms', 'controller' => 'settings'), 'admin_default', true).'#otpsms_signup_phonenumber-wrapper');
    $this->setDescription($description);
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->addElement('Radio', 'enable', array(
      'label' => 'Enable OTP Verification?',
      'description' => 'Do you want to enable OTP Verification option on your website? If you choose Yes, then your users will be able to verify their phone numbers during singup process?',
      'multiOptions' => array(
        1 => 'Yes',
        0 => 'No'
      ),
      'value' => 1,
    ));
    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
    ));
    $this->populate($settings->getSetting('user_signup'));
  }

}
