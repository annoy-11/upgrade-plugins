<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FooterSettings.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesfooter_Form_Admin_FooterSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Footer Design Style')
            ->setDescription('Below, choose a design style for the Footer of your website. You can configure the Footer Links and other sections included in the design from other sections of this plugin.');

    $this->addElement('Radio', 'ses_footer_design', array(
        'label' => 'Footer Design',
        'description' => 'Choose Footer Design',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-1.jpg" alt="Footer Design - 1" />',
            2 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-2.jpg" alt="Footer Design - 2" />',
            3 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-3.jpg" alt="Footer Design - 3" />',
            4 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-4.jpg" alt="Footer Design - 4" />',
						5 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-5.jpg" alt="Footer Design - 5" />',
						6 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-6.jpg" alt="Footer Design - 6" />',
            7 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-7.jpg" alt="Footer Design - 7" />',
			8 => '<img src="./application/modules/Sesfooter/externals/images/design/footer-8.jpg" alt="Footer Design - 8" />',
        ),
				'escape' => false,
        'onchange' => 'show_settings(this.value)',
        'value' => Engine_Api::_()->sesfooter()->getContantValueXML('ses_footer_design'),
    ));


    $this->addElement('Text', 'sesfooter_footer_aboutheading', array(
        'label' => 'About Heading',
        'description' => 'Enter About Heading',
        'value' => $settings->getSetting('sesfooter.footer.aboutheading', 'About Us'),
    ));

    $this->addElement('Radio', 'sesfooter_footer_choosecontent', array(
        'label' => 'Choose Content in Box',
        'description' => 'Choose from below the content which you want to show in the content box.',
        'multiOptions' => array(
          1 => "Site Members",
          2 => "HTML / Embed Code. You can enter your <a href='https://developers.facebook.com/docs/plugins/page-plugin/' target='_blank'>Facebook Page</a> embed code, <a href='https://publish.twitter.com/#' target='_blank'>Twitter Embed</a> code or any other embed code. Suggested width is 270px.",
        ),
        'escape' => false,
        'onchange' => 'choosecontent(this.value)',
        'value' => $settings->getSetting('sesfooter.footer.choosecontent', 1),
    ));




    $moduleEnable = Engine_Api::_()->sesfooter()->getModulesEnable();
    $this->addElement('Select', "sesfooter6_module", array(
        'label' => 'Choose Module',
        'description' => 'Choose the module whose content will show in this widget in small grids.',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => $moduleEnable,
        'value' => $settings->getSetting('sesfooter6.module', 'user'),
    ));

    $this->addElement('Textarea', 'ses_footer_footer5_description', array(
        'label' => 'Right Side Content',
        'description' => 'Right Side Content',
        'value' => $settings->getSetting('ses.footer.footer5.description', ''),
    ));

    $this->addElement('Text', 'sesfooter6_memberheading', array(
        'label' => 'Title',
        'description' => 'Enter the title to be shown above this Block. [Enter %s to show member count.]',
        'value' => $settings->getSetting('sesfooter6.memberheading', '%s Members and Counting...'),
    ));
    $this->addElement('Text', 'sesfooter5_memberheight', array(
        'label' => 'Content Image Height',
        'description' => 'Enter image height [in px].',
        'value' => $settings->getSetting('sesfooter5.memberheight', 60),
    ));
    $this->addElement('Text', 'sesfooter5_memberwidth', array(
        'label' => 'Content Image Width',
        'description' => 'Enter image width [in px].',
        'value' => $settings->getSetting('sesfooter5.memberwidth', 60),
    ));
    $this->addElement('Text', 'sesfooter5_membercount', array(
        'label' => 'Content Count',
        'description' => 'Enter number of content to be shown in this widget.',
        'value' => $settings->getSetting('sesfooter5.membercount', 12),
    ));
    $this->addElement('Select', "sesfooter5_popularity", array(
        'label' => 'Choose Popularity Criteria',
        'allowEmpty' => false,
        'required' => true,
        'multiOptions' => array(
          "creation_date" => "Recently Created",
          "modified_date" => "Recently Updated",
          "view_count" => "Most Viewed",
        ),
        'value' => $settings->getSetting('sesfooter5.popularity', 'creation_date'),
    ));

    $this->addElement('Textarea', 'sesfooter6_socialmediaembedcode', array(
      //'label' => 'HTML / Embed Code',
     // 'description' => 'You can enter your Facebook Page embed code, Twitter Embed code or any other embed code. Suggested width is 300px.',
      'value' => $settings->getSetting('sesfooter6.socialmediaembedcode', ''),
    ));

    $this->addElement('Text', 'sesfooter6_androidapplink', array(
        'label' => 'Android App Link',
        'value' => $settings->getSetting('sesfooter6.androidapplink', 'https://play.google.com/store/apps/details?id=com.sesolutions&hl=en'),
    ));

    $this->addElement('Text', 'sesfooter6_iosapplink', array(
      'label' => 'iOS App Link',
      'value' => $settings->getSetting('sesfooter6.iosapplink', 'https://itunes.apple.com/us/app/sesolutions/id1269496435?ls=1&mt=8&ign-mscache=1&ign-msr=https%3A%2F%2Fitunesconnect.apple.com%2FWebObjects%2FiTunesConnect.woa%2Fra%2Fng%2Fapp%2F1269496435'),
    ));

    $this->addElement('Textarea', 'sesfooter_footer_aboutdes', array(
        'label' => 'About Description',
        'description' => 'Enter About Description',
        'value' => $settings->getSetting('sesfooter.footer.aboutdes', ''),
    ));

    $this->addElement('Radio', 'sesfooter_enablelogo', array(
      'label' => 'Enable Logo?',
      'description' => 'Do you want to show site logo chosen from the Global Settings of this plugin in this design?',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'value' => $settings->getSetting('sesfooter.enablelogo', 1),
    ));


    $this->addElement('Radio', 'sesfooter_showcontactdetails', array(
      'label' => 'Show Contact Details',
      'description' => 'Do you want to show your contact details in this footer design? If you choose Yes, then you can enter the details in available settings.',
      'multiOptions' => array(
        1 => "Yes",
        0 => "No",
      ),
      'onchange' => 'showContactDetails(this.value);',
      'value' => $settings->getSetting('sesfooter.showcontactdetails', 1),
    ));

    $this->addElement('Text', 'sesfooter6_contactaddress', array(
      'label' => 'Address',
      'value' => $settings->getSetting('sesfooter6.contactaddress', ''),
    ));
    $this->addElement('Text', 'sesfooter6_contactphonenumber', array(
      'label' => 'Phone Number',
      'value' => $settings->getSetting('sesfooter6.contactphonenumber', ''),
    ));
    $this->addElement('Text', 'sesfooter6_contactemail', array(
      'label' => 'Email Address',
      'value' => $settings->getSetting('sesfooter6.contactemail', ''),
    ));
    $this->addElement('Text', 'sesfooter6_contactwebsiteurl', array(
      'label' => 'Website URL',
      'value' => $settings->getSetting('sesfooter6.contactwebsiteurl', ''),
    ));


    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
