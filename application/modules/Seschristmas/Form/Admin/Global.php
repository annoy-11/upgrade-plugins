<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Form_Admin_Global extends Engine_Form {

  public function init() {
	$settings = Engine_Api::_()->getApi('settings', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $URL = "http://" . $_SERVER['SERVER_NAME'] . $view->baseUrl();
    
    $tempalte1 = $URL . '/application/modules/Seschristmas/externals/images/template_1.jpg';
    $tempalte2 = $URL . '/application/modules/Seschristmas/externals/images/template_2.jpg';
    
    $api_settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
		$sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
		$descriptionLicense = sprintf('Enter the your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
		$this->addElement('Text', "seschristmas_licensekey", array(
		'label' => 'Enter License key',
		'description' => $descriptionLicense,
		'allowEmpty' => false,
		'required' => true,
		'value' => $settings->getSetting('seschristmas.licensekey'),
		));
		$this->getElement('seschristmas_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($api_settings->getSetting('seschristmas.pluginactivated')) {


      $this->addElement('Radio', 'seschristmas_snoweffect', array(
          'label' => 'Enable Snow Effect',
          'description' => 'Do you want to enable the snow effect on your website? If you select Yes, then below you will also be able to choose the design and quantity of the snow.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'showeffect(this.value)',
          'value' => $api_settings->getSetting('seschristmas.snoweffect', 1),
      ));

      $this->addElement('Radio', 'seschristmas_snowimages', array(
          'label' => 'Snow Effect Image',
          'description' => 'Choose from below the image for snow effect which will fall on the pages of your website. (Note: This setting will not affect on the snow on Welcome Page.)',
          'multiOptions' => array(
              1 => "Image 1 " . '<img src="application/modules/Seschristmas/externals/images/snow1.png" alt="Snow 1" width="16" />',
              2 => "Image 2 " . '<img src="application/modules/Seschristmas/externals/images/snow2.png" alt="Snow 2" width="16" />',
              3 => "Image 3 " . '<img src="application/modules/Seschristmas/externals/images/snow3.png" alt="Snow 3" width="16" />',
              4 => "Image 4 " . '<img src="application/modules/Seschristmas/externals/images/snow4.png" alt="Snow 4" width="16" />',
              5 => "Image 5 " . '<img src="application/modules/Seschristmas/externals/images/snow5.png" alt="Snow 5" width="16" />',
              6 => "Image 6 " . '<img src="application/modules/Seschristmas/externals/images/snow6.png" alt="Snow 6" width="16" />',
          ),
          'escape' => false,
          'value' => $api_settings->getSetting('seschristmas.snowimages', 1),
      ));

      $this->addElement('Select', 'seschristmas_snowquantity', array(
          'label' => 'Snow Quantity',
          'description' => 'Choose from below the quantity of snow which will fall on the pages on your website.',
          'multiOptions' => array(
              10 => '10',
              20 => '20',
              30 => '30',
              40 => '40',
              50 => '50',
              60 => '60',
          ),
          'value' => $api_settings->getSetting('seschristmas.snowquantity', 30),
      ));

      $this->addElement('Radio', 'seschristmas_template', array(
          'label' => 'Header Footer Design Elements',
          'description' => 'Choose from below the template which you want to enable on your website. Templates contain various design elements which will reflect on your website. You can click on “view design and placement of elements” link to view the design and placement of various elements on your website.',
          'multiOptions' => array(
              1 => "Template - 1 " . '<a href="'.$tempalte1.'" title="View Screenshot" class="" target="_blank">Template - 1</a>',
              0 => "Template - 2 " . '<a href="'.$tempalte2.'" title="View Screenshot" class="" target="_blank">Template - 2</a>',
              2 => 'None',
          ),
          'escape' => false,
          'onchange' => 'choosetemplate(this.value)',
          'value' => $api_settings->getSetting('seschristmas.template', 0),
      ));

      $template1 = array('header_before' => 'Element in top-left of header', 'header_after' => 'Element in top-right of header', 'footer_before' => 'Element in bottom-left of footer', 'footer_after' => 'Element in bottom-right of footer');
      $seschristmas_template1 = $api_settings->getSetting('seschristmas.template1', 'a:4:{i:0;s:13:"header_before";i:1;s:12:"header_after";i:2;s:13:"footer_before";i:3;s:12:"footer_after";}');
      $template1_value = unserialize($seschristmas_template1);


      $this->addElement('MultiCheckbox', 'seschristmas_template1', array(
          'description' => 'Choose from below the elements to be shown on your website.',
          'multiOptions' => $template1,
          'value' => $template1_value,
      ));

      $template2 = array('header_before' => 'Element in Header', 'left_right_bell' => 'Element (Bell) in Left / Right', 'footer_before' => 'Element in Footer');
      $seschristmas_template2 = $api_settings->getSetting('seschristmas.template2', 'a:3:{i:0;s:13:"header_before";i:1;s:15:"left_right_bell";i:2;s:13:"footer_before";}');
      $template2_value = unserialize($seschristmas_template2);

      $this->addElement('MultiCheckbox', 'seschristmas_template2', array(
          'description' => 'Choose from below the elements to be shown on your website.',
          'multiOptions' => $template2,
          'value' => $template2_value,
      ));



      $this->addElement('Radio', 'seschristmas_wish', array(
          'label' => 'Enable Wishes',
          'description' => 'Do you want to enable members on your website to write wishes on the Wish Boards? If you choose Yes, then a Wishes tab will appear in the Main Navigation Menu and users will be able to write and edit their wishes.',
          'multiOptions' => array(
              1 => 'Yes',
              0 => 'No'
          ),
          'onchange' => 'showwish(this.value)',
          'value' => $api_settings->getSetting('seschristmas.wish', 1),
      ));

      $this->addElement('Text', "seschristmas_wisheslimit", array(
          'label' => 'Default Number of Wishes to be Shown',
          'description' => 'Enter the number of wishes which will be shown when the Wishes page is opened. (Note: When user clicks on "View More Wishes" button or wishes are auto-loaded, then the number of new wishes shown will also be the same as you enter in the text box below.)',
          'allowEmpty' => false,
          'required' => true,
          'value' => $api_settings->getSetting('seschristmas.wisheslimit', 10),
      ));

      $this->addElement('Radio', 'seschristmas_showviewmore', array(
          'label' => 'Auto-Load Wishes',
          'description' => 'Do you want the wishes to be auto-loaded when users scroll down the Wishes Pages? (If you Select ‘No’, then users will have to click on “View More Wishes” button to view more wishes.)',
          'multiOptions' => array(
              1 => 'No, do not auto-load the wishes',
              2 => 'Yes, auto-load the wishes'
          ),
          'value' => $api_settings->getSetting('seschristmas.showviewmore', 2),
      ));

      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Save Changes',
          'type' => 'submit',
          'ignore' => true
      ));
    } else {
      // Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}