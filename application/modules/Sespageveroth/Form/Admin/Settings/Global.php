<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageveroth_Form_Admin_Settings_Global extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
            ->setTitle('Global Settings')
            ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    if(!Engine_Api::_()->sesbasic()->isSkuExists('sespageveroth')) {
        $this->addElement('Text', "sespageveroth_licensekey", array(
            'label' => 'Enter License key',
            'description' => $descriptionLicense,
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sespageveroth.licensekey'),
        ));
        $this->getElement('sespageveroth_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    }

    if ($settings->getSetting('sespageveroth.pluginactivated')) {

      $member = '<a href="https://www.socialenginesolutions.com/social-engine/advanced-members-plugin/" target="_blank">Advanced Members Plugin</a>';
      $des = sprintf('Do you want to allow members on your website to verify Pages on your website?');


      $this->addElement('Radio', 'sespageveroth_enableverification', array(
        'label' => 'Allow Members to Verify Pages',
        'description' => $des,
        'multiOptions' => array(
          '2' => 'Yes, allow all members to verify Pages. (You can configure the settings from Member Level Settings of this plugin).',
          '1' => 'Yes, allow only Verified members to verify Pages. ("<a href="https://www.help.socialenginesolutions.com/faq/175/how-to-verify-members-on-my-site" target="_blank">How to verify Members on your Website?</a>")',
          '0' => 'No, do not allow members to verify Pages',
        ),
        'escape' => false,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.enableverification', 2),
      ));
      $this->getElement('sespageveroth_enableverification')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

      $files[] = '';
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
        $files['public/admin/' . $base_name] = $base_name;
      }

      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
      $fileLink = $view->baseUrl() . '/admin/files/';

      $this->addElement('Select', 'sespageveroth_verifybadge', array(
        'label' => 'Upload Verify Badge Image',
        'description' => 'Choose a photo for the verify badge which will display in “Verified Page Badge & Verify Page Button” widget on your website. [Note: You can add a new photo from the "<a href="' . $fileLink . '" target="_blank">File & Media Manager</a>" section. Leave the field blank if you do not want to change this default photo.]',
        'multiOptions' => $files,
        'escape' => false,
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.verifybadge', ''),
      ));
      $this->sespageveroth_verifybadge->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


      $this->addElement('Radio', 'sespageveroth_enablecomment', array(
        'label' => 'Enable Members to Add Comments',
        'description' => 'Do you want to enable members on your website to add comments while verifying Pages?',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'onchange' => 'enablecomment(this.value)',
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.enablecomment', 1),
      ));

      $this->addElement('Radio', 'sespageveroth_displaycomment', array(
        'label' => 'Display Comments For Verified Pages',
        'description' => 'Do you want to display comments for pages while verifying Pages on your website? If you choose Yes, then the comments will be displayed with each page who have been verified by the member - whose verification details are being viewed.',
        'multiOptions' => array(
          '1' => 'Yes',
          '0' => 'No',
        ),
        'value' => Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.displaycomment', 1),
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
