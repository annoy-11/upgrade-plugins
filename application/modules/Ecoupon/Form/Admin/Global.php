<?php

class Ecoupon_Form_Admin_Global extends Engine_Form {
  public function init() {
    $this->setTitle('General Settings')
            ->setDescription('These settings affect all members in your community.');
     $settings = Engine_Api::_()->getApi('settings', 'core');
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('ecoupon.pluginactivated',1)) {
//       $this->addElement('Radio', 'ecoupon_enable_menu', array(
//         'label'=>'Coupon Menu display',
//          'description' => 'Coupon MWhere do you want to display coupons on your site? Note: At user end when user clicked on coupon then navigate to the Browse coupon page.',
//         'multiOptions' => array(0 => 'Main Navigation Menu',1 => 'Mini Navigation Menu',2 => 'Member Home page at left side'),
//         'value' => $settings->getSetting('ecoupon.enable.menu', 1),
//       ));
      $this->addElement('Radio', 'ecoupon_enable_addcourseshortcut', array(
        'label'=>'Show "Create New Coupon" Icon', 
        'description' => 'Do you want to show "Create New Coupon" icon in the bottom right side of all pages of this plugin?',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.enable.addcourseshortcut', 1),
      ));
      $this->addElement('Radio', 'ecoupon_icon_open_smoothbox', array(
        'label' => 'Page or Popup From Create Icon',
        'description' => "Do you want to open the 'Create New Coupon' form in popup or page, when users click on the 'Create New Coupon Icon' in the bottom right side of all pages of this plugin?",
        'multiOptions' => array('1' => 'Open Create Coupon Form in popup','0' => 'Open Create Coupon Form in page',),
        'value' => $settings->getSetting('ecoupon.icon.open.smoothbox', 1),
      ));
      $this->addElement('Select', "ecoupon_allow_integration", array(
          'label' => 'Coupon Integration with  Plugins',
          'description' => "Please select the plugins to apply coupons.",
           'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('ecoupon.allow.integration', 1),
      ));
      $this->addElement('Radio', "ecoupon_allow_like", array(
          'label' => 'Allow to like',
          'description' => "Do you want to allow users to like coupon?",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('ecoupon.allow.like', 1),
      ));
      $this->addElement('Radio', "ecoupon_allow_favourite", array(
        'label' => 'Allow to favorite',
        'description' => "Do you want to allow users to favorite coupon?",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('ecoupon.allow.favourite', 1),
      ));
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate Your Plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }
}
?>
