<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Form_Admin_Settings_Global extends Engine_Form
{
  public function init()
  {
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this
      ->setTitle('Global Settings')
      ->setDescription('These settings affect all members in your community.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="https://socialnetworking.solutions/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="https://socialnetworking.solutions" target="_blank">SocialNetworking.Solutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);

    $this->addElement('Text', "sesforum_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesforum.licensekey'),
    ));
    $this->getElement('sesforum_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesforum.pluginactivated')) {

      $this->addElement('Text', 'sesforum_forum_manifest', array(
          'label' => 'Singular "forum" Text in URL',
          'description' => 'Enter the text which you want to show in place of "forum" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesforum.forum.manifest', 'forum'),
      ));

      $this->addElement('Text', 'sesforum_forums_manifest', array(
          'label' => 'Plural "forums" Text in URL',
          'description' => 'Enter the text which you want to show in place of "forums" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesforum.forums.manifest', 'forums'),
      ));

      $this->addElement('Text', 'sesforum_text_singular', array(
            'label' => 'Singular Text for "Forum"',
            'description' => ' Enter the text which you want to show in place of "Forum" at various places in this plugin like activity feeds, etc.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesforum.text.singular', 'forum'),
        ));

      $this->addElement('Text', 'sesforum_text_plural', array(
            'label' => 'Plural Text for "Forums"',
            'description' => 'Enter the text which you want to show in place of "Forums" at various places in this plugin like search form, navigation menu, etc.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesforum.text.plural', 'forums'),
        ));

      $this->addElement('Radio', 'sesforum_bbcode', array(
          'label' => 'Enable BBCode',
      'description' => 'Do you want to enable users to use BBCode in their posts?',
          //'description' => 'Do you want to allow thanks.',
          'multiOptions' => array(
              1 => 'Yes, members can use BBCode tags.',
              0 => 'No, do not let members use BBCode.'
          ),
          'value' => $settings->getSetting('sesforum.bbcode', 1),
      ));

      $this->addElement('Radio', 'sesforum_html', array(
          'label' => 'Enable HTML',
          'description' => 'Do you want to enable users to use HTML in their posts?',
          'multiOptions' => array(
              1 => 'Yes, members can use HTML in their posts.',
          0 => 'No, members cannot use HTML in their Posts.'
          ),
          'value' => $settings->getSetting('sesforum.html', 1),
      ));

      $this->addElement('Radio', 'sesforum_thanks', array(
          'label' => 'Enable "Say Thanks"',
          'description' => 'Do you want to enable users to "Say Thanks" to the members on their topic posts?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesforum.thanks', 1),
      ));

      $this->addElement('Radio', 'sesforum_rating', array(
          'label' => 'Enable Rating',
          'description' => 'Do you want to enable users to give rating on the Forum Topics?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesforum.rating', 1),
      ));

      $this->addElement('Radio', 'sesforum_reputation', array(
          'label' => 'Enable "Reputations"',
          'description' => 'Do you want to enable users to increase/decrease reputation of members for their posts in forum topics?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesforum.reputation', 1),
      ));

      $this->addElement('Radio', 'sesforum_subscribe', array(
          'label' => 'Allow to Subscribe Topics',
          'description' => 'Do you want to allow members to subscribe to the Forum Topics? If members subscribe, then they will receive notifications when other members reply to their subscribed topics. ',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesforum.subscribe', 1),
      ));

      $this->addElement('Radio', 'sesforum_tag_mandatory', array(
          'label' => 'Make Tags Mandatory',
          'description' => 'Do you want to make tags mandatory for the Topics on your website? Users will be able to enter the tags for their topics while creating or editing topics.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesforum.tag.mandatory', 1),
      ));

      $this->addElement('Radio', 'sesforum_enable_WYSIWYG', array(
          'label' => 'WYSIWYG Editor',
          'description' => 'Do you want to enable WYSIWYG Editor for forum topics & posts? If you choose No, then simpel text area will be shown.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesforum.enable.WYSIWYG', 1),
      ));

      // Add submit button
      $submit = new Engine_Form_Element_Button('submit');
      $submit->setAttrib('type', 'submit')
        ->setLabel('Save Changes');
      $this->addElement($submit);
    } else {
      // Add submit button
      $submit = new Engine_Form_Element_Button('submit');
      $submit->setAttrib('type', 'submit')
        ->setLabel('Activate Your Plugin');
      $this->addElement($submit);
    }
  }
}
