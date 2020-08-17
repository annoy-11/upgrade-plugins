<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Ecoupon
 * @package    ecoupon
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: DonerFaqs.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Ecoupon_Form_Admin_CouponFaqs extends Engine_Form {
  public function init() {
      $settings = Engine_Api::_()->getApi('settings', 'core');
      $this->setTitle('FAQs for Coupons')
          ->setDescription('Here, you can enter the FAQs for coupon on your website. These FAQs will display on the respective page at user end.');
      $this->addElement('Text', 'ecoupon_couponstitle', array(
          'label' => 'Title',
          'description' => 'Enter the title which you want to show to your users on FAQs page.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('ecoupon.couponstitle', 'FAQs for Coupons'),
      ));
      $this->addElement('TinyMce', 'ecoupon_couponsbody', array(
          'label' => 'FAQs',
          'description' => 'Enter the FAQs which you want to show to your users.',
          'required' => true,
          'editorOptions' => array(
              'html' => true,
          ),
          'allowEmpty' => false,
          'value' => $settings->getSetting('ecoupon.couponsbody', ''),
      ));
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
  }
}
