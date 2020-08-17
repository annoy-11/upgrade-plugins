<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Ecoupon
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Create.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Ecoupon_Form_Admin_Create extends Engine_Form {
  public function init() {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Creation Settings')
            ->setDescription('Here, you can choose the settings which are related to the creation of Coupons on your website. The settings enabled or disabled will affect Coupon creation page and edit page.');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->addElement('Radio', 'ecoupon_page_redirect', array(
          'label' => 'Redirection After Coupon Creation',
          'description'=>'Choose from below where you want to redirect users after a Coupon is successfully created.',
          'multiOptions' => array(0 => 'On Coupon Dashboard',1 => 'On Coupon View Page'),
          'value' => $settings->getSetting('ecoupon.page.redirect', 1),
    ));
    $this->addElement('Radio', 'ecoupon_create_accordian', array(
        'label' => 'Create Coupon Form Type',
        'description' => 'What type of Form you want to show on Create New Coupon?',
        'multiOptions' => array(0 => 'Default SE Form',1 => 'Designed Form'),
        'value' => $settings->getSetting('ecoupon.create.accordian', 1),
    ));
    $this->addElement('Radio', 'ecoupon_enable_description', array(
        'label' => ' Enable Coupon Description',
        'description' => 'Do you want to enable description of Coupon on your website?',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.enable.description', 1),
        'onclick' => 'showCouponDescription(this.value);',
    ));
    $this->addElement('Radio', 'ecoupon_wysiwyg_editor', array(
        'label' => 'Enable WYSIWYG editor for description',
        'description' => 'Do you want to enable the WYSIWYG Editor for the Coupon description? If you choose No, then simple text area will be displayed.',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.wysiwyg.editor', 1),
    ));
    $this->addElement('Radio', 'ecoupon_description_mandatory', array(
        'label' => 'Make Coupon Description Mandatory',
        'description' => 'Do you want to make Description field mandatory when users create or edit their Coupon ?',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.description.mandatory', 0),
    ));
    $this->addElement('Radio', 'ecoupon_main_photo', array(
        'label' => 'Enable Coupon Photo',
        'description' => 'Do you want to enable Coupon Photo field in create form?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.main.photo', 1),
        'onclick' => 'showCouponPhoto(this.value);',
    ));
    $this->addElement('Radio', 'ecoupon_mainPhoto_mandatory', array(
        'label' => 'Make Coupon Photo Mandatory',
        'description' => 'Do you want to make coupon photo field mandatory when users create or edit their Coupon ?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.mainPhoto.mandatory', 1),
    ));
    
    $this->addElement('Radio', 'ecoupon_coupon_code', array(
        'label' => 'Enable Coupon code',
        'description' => 'Do you want to enable Coupon code?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.coupon.code', 1),
        'onclick' => 'showCouponPhoto(this.value);',
    ));
    $this->addElement('Radio', 'ecoupon_coupon_mandatory', array(
        'label' => 'Make Coupon Code Mandatory',
        'description' => 'Do you want to make     coupon code mandatory?
          Note: If Yes selected then Marked with* symbol and have check availability button.',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.coupon.mandatory', 1),
    ));
    $this->addElement('Radio', 'ecoupon_enable_discount', array(
            'label' => 'Enable Discount',
            'description' => 'Do you want to enable discounts for Coupons on your website?',
            'multiOptions' => array('1' => 'Yes','0' => 'No'),
            'value' => $settings->getSetting('ecoupon.enable.discount', 1),
            'onclick'=>'showQuickOption(this.value);'
    ));
    $this->addElement('Radio', 'ecoupon_start_date', array(
        'label' => 'Enable Coupon Start Date',
        'description' => 'Do you want to enable Coupon Start Date ?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.start.date', 1),
    ));
    $this->addElement('Radio', 'ecoupon_end_date', array(
        'label' => 'Enable Coupon End Date',
        'description' => 'Do you want to enable Coupon End Date ?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.end.date', 1),
    ));
    $this->addElement('Radio', 'ecoupon_enable_coupon', array(
        'label' => 'Enable coupon',
        'description' => 'Do you want to allow users to enable coupon?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.enable.coupon', 1),
    ));
    $this->addElement('Radio', 'ecoupon_search', array(
        'label' => 'Enable "People can search for this Coupon" Field',
        'description' => 'Do you want to enable “People can search for this Coupon” field while creating and editing Coupon on your website?',
         'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.search', 1),
    ));
//     $this->addElement('Radio', 'ecoupon_enable_preview', array(
//         'label' => 'Enable "People can search for this Coupon" Field',
//         'description' => 'Do you want to enable “People can search for this Coupon” field while creating and editing Coupon on your website?',
//          'multiOptions' => array('1' => 'Yes','0' => 'No'),
//         'value' => $settings->getSetting('ecoupon.enable.preview', 1),
//     ));
      // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));

  }

}
