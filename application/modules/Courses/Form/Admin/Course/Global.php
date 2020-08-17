<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Global.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Courses_Form_Admin_Course_Global extends Engine_Form {

  public function init() {
  
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Course Global Settings')
            ->setDescription('These settings controls the Courses functionality and also affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "courses_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('courses.licensekey'),
    ));
    $this->getElement('courses_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
   if (Engine_Api::_()->getApi('settings', 'core')->getSetting('courses.pluginactivated')) {
   
    $this->addElement('Radio', 'courses_enable_welcome', array(
    'label'=>'Course Main Menu Redirection',
        'description' => 'Choose from below where do you want to redirect users when Courses Menu item is clicked in the Main Navigation Menu Bar.',
        'multiOptions' => array(2 => 'Course Browse Page',0 => 'Course Home Page',3 => 'Course Category Page',1 => 'Welcome Page'),
        'value' => $settings->getSetting('courses.enable.welcome', 1),
    ));
    $this->addElement('Radio', 'courses_check_welcome', array(
        'label' => 'Welcome Page Visibility',
        'description' => 'Who all users do you want to see this "Welcome Page"?',
        'multiOptions' => array(
            0 => 'Only logged in users',
            1 => 'Only non-logged in users',
            2 => 'Both, logged-in and non-logged in users',
        ),
        'value' => $settings->getSetting('courses.check.welcome', 2),
    ));
    $this->addElement('Text', 'courses_plural_manifest', array(
        'label' => 'Plural Text for "Courses" in URL',
        'description' => 'Enter the text which you want to show in place of "Courses" in the URLs of this plugin.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('courses.plural.manifest', 'courses'),
    ));
    $this->addElement('Text', 'courses_singular_manifest', array(
        'label' => 'Singular Text for "Course" in URL',
        'description' => 'Enter the text which you want to show in place of "Course" in the URLs of this plugin.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('courses.singular.manifest', 'course'),
    ));
    $this->addElement('Text', 'courses_text_singular', array(
          'label' => 'Singular Text for "Course"',
          'description' => 'Enter the text which you want to show in place of "Course" at various places in this plugin like activity feeds, etc.',
          'allowEmpty' => false,
          'required' => true,
          'value' => $settings->getSetting('courses.text.singular', 'course'),
    ));
    $this->addElement('Text', 'courses_text_plural', array(
        'label' => 'Plural Text for "Courses"',
        'description' => 'Enter the text which you want to show in place of "Courses" at various places in this plugin like search form, navigation menu, etc.',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('courses.text.plural', 'courses'),
    ));
    $this->addElement('Select', 'courses_watermark_enable', array(
        'label' => 'Add Watermark to Photos',
        'description' => 'Do you want to add watermark to photos (from this plugin) on your website? If you choose Yes, then you can upload watermark image to be added to the photos from the Member Level Settings.',
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.watermark.enable', 1),
        'onclick' => 'showCourseWatermark(this.value);',
    ));
    $this->addElement('Select', 'courses_position_watermark', array(
            'label' => 'Watermark Position',
            'description' => 'Choose the position for the watermark.',
            'multiOptions' => array(
              0 => 'Middle ',
              1 => 'Top Left',
              2 => 'Top Right',
              3 => 'Bottom Right',
              4 => 'Bottom Left',
              5 => 'Top Middle',
              6 => 'Middle Right',
              7 => 'Bottom Middle',
              8 => 'Middle Left',
          ),
          'value' => $settings->getSetting('courses.position.watermark', 1),
    ));
    $this->addElement('Text', 'courses_mainheight', array(
        'label' => 'Large Photo Height',
        'description' => 'Enter the maximum height of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Course Photo View Page". Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('courses.mainheight', 1600),
    ));
    $this->addElement('Text', 'courses_mainwidth', array(
        'label' => 'Large Photo Width',
        'description' => 'Enter the maximum width of the large main photo (in pixels). [Note: This photo will be shown in the lightbox and on "Course Photo View Page". Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('courses.mainwidth', 1600),
    ));
    $this->addElement('Text', 'courses_normalheight', array(
        'label' => 'Medium Photo Height',
        'description' => 'Enter the maximum height of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('courses.normalheight', 500),
    ));
    $this->addElement('Text', 'courses_normalwidth', array(
        'label' => 'Medium Photo Width',
        'description' => 'Enter the maximum width of the medium photo (in pixels). [Note: This photo will be shown in the various widgets and pages. Also, this setting will apply on new uploaded photos.]',
        'value' => $settings->getSetting('courses.normalwidth', 500),
    ));
    
//     $this->addElement('Radio', 'courses_nonLogged_details', array(
//         'label' => 'Display Contact Details to Non-logged In Users',
//         'description' => 'Do you want to display contact details of Courses to non-logged in users of your website? If you choose No, then non-logged in users will be asked to login when they try to view the contact details of courses in various widgets and places on your website ?',
//         'multiOptions' => array('1' => 'Yes','0' => 'No'),
//         'value' => $settings->getSetting('courses.nonLogged.details', 1),
//     ));
    
    $this->addElement('Radio', "courses_allow_favourite", array(
        'label' => 'Allow to Favorite Courses',
        'description' => "Do you want to allow users to favourite Courses on your website?",
        'multiOptions' => array('1' => 'Yes','0' => 'No'),
        'value' => $settings->getSetting('courses.allow.favourite', 1),
    ));
    $this->addElement('Radio', "courses_allow_like", array(
          'label' => 'Allow to Like Courses',
          'description' => "Do you want to allow members to like Courses on your website.",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('courses.allow.like', 1),
    ));
    $this->addElement('Radio', "courses_allow_wishlists", array(
          'label' => 'Enable Courses Add to Wishlist',
          'description' => "Do you want to allow users to add Courses in their Wishlists on your website?",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('courses.allow.wishlists', 1),
    ));

      
// 		$this->addElement('Radio', "lectures_allow_list", array(
//           'label' => 'Enable Lectures Add to List',
//           'description' => "Do you want to enable users to Save Lectures to their saved list on your website? [If Yes, then users will be able to save the Lectures from Lecture View Page.]",
//           'multiOptions' => array('1' => 'Yes','0' => 'No'),
//           'value' => $settings->getSetting('lectures.allow.lists', 1),
//     ));
// 		$this->addElement('Radio', "tests_allow_list", array(
//           'label' => 'Enable Tests Add to List',
//           'description' => "Do you want to enable users to Save Tests to their saved list on your website? [If Yes, then users will be able to save the Tests from Test View Page.]",
//           'multiOptions' => array('1' => 'Yes','0' => 'No'),
//           'value' => $settings->getSetting('tests.allow.lists', 1),
//     ));
    $this->addElement('Radio', "courses_enable_report", array(
          'label' => 'Allow to Report Courses',
          'description' => "Do you want to allow users to Report against Courses on your website?",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('courses.enable.report', 1),
    ));
//     $this->addElement('Radio', "courses_sale_label", array(
//           'label' => 'Allow to Report Courses',
//           'description' => "Do you want to allow users to Report against Courses on your website?",
//          'multiOptions' => array('1' => 'Yes','0' => 'No'),
//           'value' => $settings->getSetting('courses.sale.label', 1),
//     ));
    $this->addElement('Radio', "courses_allow_share", array(
          'label' => 'Allow to Share Courses',
          'description' => "Do you want to allow users to share Courses of your website inside on your website and outside on other social networking sites?",
          'multiOptions' => array(
              '2' => 'Yes, allow sharing on this site and on social networking sites both.',
              '1' => 'Yes, allow sharing on this site and do not allow sharing on other Social sites.',
              '0' => 'No, do not allow sharing of Courses.',
          ),
          'value' => $settings->getSetting('courses.allow.share', 1),
    ));
    $this->addElement('Radio', "courses_cartdropdown", array(
          'label' => 'Enable Dropdown for Cart',
          'description' => "Do you want to enable dropdown when someone clicks Cart in the Mini Navigation menu on your website? If you choose No, then users will be redirected to their Cart page.",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('courses.cartdropdown', 1),
    ));
    $this->addElement('Radio', "courses_cartviewtype", array(
          'label' => 'Cart View Style',
          'description' => "Choose from below how do you want to display the cart option in the Mini Navigation Menu of your website.",
          'multiOptions' => array(1 => 'Only Text ',2 => 'Only Icon',3 => 'Both Icon & Text'),
          'value' => $settings->getSetting('courses.cartviewtype', 1),
    ));
    $this->addElement('Radio', 'courses_enablecomparision', array(
        'label' => 'Enable Comparison of Courses',
        'description' => 'Do you want to allow users to compare various courses on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'value' => $settings->getSetting('courses.enablecomparision', 1),
    ));
    $paymentMultiOptions = array();
    $table = Engine_Api::_()->getDbTable('gateways','payment');
    $select = $table->select()->where('plugin =?','Payment_Plugin_Gateway_PayPal')->where('enabled =?',1);
    $paypal = $table->fetchRow($select);
     $select = $table->select()->where('plugin =?','Sesadvpmnt_Plugin_Gateway_Stripe')->where('enabled =?',1);
    $stripe = $table->fetchRow($select);
    if(!empty($paypal)){
      $paymentMultiOptions['paypal'] = 'Payment By PayPal';
    }elseif(!empty($stripe)) {
      $paymentMultiOptions['stripe'] = 'Payment By Stripe';
    }
    $this->addElement('MultiCheckbox', 'courses_payment_siteadmin', array(
            'label' => 'Payment Gateways',
            'description' => 'Choose from below the Payment Gateways through which you want to receive payment from buyers for the orders from your website. [You can enable the  payment gateways from <a href="admin/payment/gateway" target="_blank">here</a> .]',
            'multiOptions' => $paymentMultiOptions,
            'value' => $settings->getSetting('courses.payment.siteadmin', array('paypal','stripe')),
    ));
    $this->courses_payment_siteadmin->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
    
//     $this->addElement('Radio', "courses_buyer_ipaddress", array(
//           'label' => 'Display Buyer\'s IP Address in Orders',
//           'description' => "Do you want to display the IP address of buyer's on their orders? If you choose Yes, then the IP from which buyers will make purchase will show in their orders.",
//           'multiOptions' => array('1' => 'Yes','0' => 'No'),
//           'value' => $settings->getSetting('courses.buyer.ipaddress', 1),
//     ));
//     
    $this->addElement('Textarea', "courses_receivenewalertemails", array(
        'label' => 'Email Alert for New Courses',
        'description' => 'Below, you can enter the email on which you want to receive the email alert when new Course created on your website.',
        'value' => $settings->getSetting('courses.receivenewalertemails'),
    ));
    $this->addElement('Radio', "courses_activate_orders", array(
        'label' => 'Activate Courses Orders',
        'description' => "Do you want to enable orders immediately after payment, before the payment passes the gateways' fraud checks? This may take anywhere from 20 minutes to 4 days, depending on the circumstances and the gateway.",
        'multiOptions' => array(
              'all' => 'Enable Orders immediately.',
              'some' => 'Enable if user has an existing successful transaction, wait if this is their first.',
              'none' => 'Wait until the gateway signals that the payment has been completed successfully.',
          ),
        'value' => $settings->getSetting('courses.activate.orders','all'),
    ));
    $this->addElement('Radio', "courses_terms_conditions", array(
          'label' => 'Allow "Terms & Conditions"',
          'description' => "Do you want to enable Courses owners to add 'Terms & Conditions' in their Courses?",
          'multiOptions' => array('1' => 'Yes','0' => 'No'),
          'value' => $settings->getSetting('courses.terms.conditions', 1),
    ));
    $this->addElement('Text', 'video_ffmpeg_path', array(
          'label' => 'Path to FFMPEG',
          'description' => 'Please enter the full path to your FFMPEG installation. (Environment variables are not present)',
          'value' => $settings->getSetting('video.ffmpeg.path', ''),
    ));
    $this->addElement('Radio', 'courses_test_tmlimit', array(
        'label' => 'Enable Time limit?',
        'description' => 'Do you want to enable the time limit for a test? If Yes, then at user-end users will enter Time for their Test.',
        'multiOptions' => array(1 => 'Yes',0 => 'No',
        ),
        'value' =>$settings->getSetting('courses.test.tmlimit', 1),
    ));
    $this->addElement('Text', 'courses_ptest_pass', array(
        'label' => 'Enter Score for Pass [in percentage]',
        'description' => 'Enter the score/marks for users to pass in the Test.',
        'validators' => array(
              array('NotEmpty', true),
              array('Float', true),
              array('GreaterThan', false, array(0))
        ),
        'value' => $settings->getSetting('courses.ptest.pass', 1),
    ));

// 		$this->addElement('Text', 'ftest_fail', array(
//         'label' => 'Enter Score for Fail [in percentage]',
//         'description' => 'Enter the score/marks when users failed in the Test.',
//     ));
// 		$this->addElement('Text', 'courses_ctst_certi', array(
//         'label' => 'Enter Score for Certificate Criteria [In Percentage]',
//         'description' => 'Enter the score/marks for users to achieve a Certificate for the Test.',
//         'validators' => array(
//               array('NotEmpty', true),
//               array('Float', true),
//               array('GreaterThan', false, array(0))
//         ),
//         'value' => $settings->getSetting('courses.ctst.certi', 1),
//     ));
// 		$this->addElement('Radio', 'save_tests', array(
//         'label' => 'Enable Save & Resume?',
//         'description' => 'Do you want to allow users to save test and complete late? The Save functionality of Test enable "Add to Savelist" button and Resume action perform with Resume button on Test page."',
//         'multiOptions' => array(1 => 'Yes',0 => 'No',
//         ),
//         'value' =>1,
//     ));
// 		$this->addElement('Radio', 'editt_test', array(
//         'label' => 'Edit Answer in Test',
//         'description' => 'Do you want to modify answer before completing the Test?',
//         'multiOptions' => array(1 => 'Yes',0 => 'No',
//         ),
//         'value' =>1,
//     ));
      
          //default photos
    $default_photos_main = array();
    $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
    foreach ($path as $file) {
      if ($file->isDot() || !$file->isFile())
        continue;
      $base_name = basename($file->getFilename());
      if (!($pos = strrpos($base_name, '.')))
        continue;
      $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
      if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
        continue;
      $default_photos_main['public/admin/' . $base_name] = $base_name;
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
    //no Courses default photo
    if (count($default_photos_main) > 0) {
      $default_photos = array_merge(array('application/modules/Courses/externals/images/courses-icon.png' => ''), $default_photos_main);
      $this->addElement('Select', 'courses_no_photo', array(
          'label' => 'Default Photo for No Courses Tip',
          'description' => 'Choose a default photo for No Courses tip on your website. [Note: You can add a new photo from the "File & Media Manager" section from here:  <a target="_blank" href="' . $fileLink . '">File & Media Manager</a>. Leave the field blank if you do not want to change this default photo.]',
          'multiOptions' => $default_photos,
          'value' => $settings->getSetting('courses.no.photo',0),
      ));
    } else {
      $description = "<div class='tip'><span>" . 'There are currently no photos in the File & Media Manager. So, photo should be first uploaded from the "Layout" >> "<a target="_blank" href="' . $fileLink . '">File & Media Manager</a>" section.' . "</span></div>";
      //Add Element: Dummy
      $this->addElement('Dummy', 'courses_no_photo', array(
          'label' => 'Default Photo for No Courses Tip',
          'description' => $description,
          'value'=> 0,
      ));
    }
    $this->courses_no_photo->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));
		$this->addElement('MultiCheckbox', 'courses_result_tests', array(
        'label' => 'Test Results',
        'description' => 'Select the Options for Test Result.',
        'multiOptions' => array(
          'after' => 'Show only the final results to users after completing Test.',
          'result'=> 'Do not show Results',
          'print' => 'Print Result',
        ),
        'value' => $settings->getSetting('courses.result.tests',  array('after','result', 'print')),
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
