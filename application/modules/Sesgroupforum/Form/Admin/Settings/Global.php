<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Global.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupforum_Form_Admin_Settings_Global extends Engine_Form
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

    $this->addElement('Text', "sesgroupforum_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesgroupforum.licensekey'),
    ));
    $this->getElement('sesgroupforum_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if ($settings->getSetting('sesgroupforum.pluginactivated')) {

      $this->addElement('Text', 'sesgroupforum_forum_manifest', array(
          'label' => 'Singular "groupforum" Text in URL',
          'description' => 'Enter the text which you want to show in place of "groupforum" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesgroupforum.forum.manifest', 'groupforum'),
      ));

      $this->addElement('Text', 'sesgroupforum_forums_manifest', array(
          'label' => 'Plural "groupforums" Text in URL',
          'description' => 'Enter the text which you want to show in place of "groupforums" in the URLs of this plugin.',
          'value' => $settings->getSetting('sesgroupforum.forums.manifest', 'groupforums'),
      ));

//       $this->addElement('Text', 'sesgroupforum_text_singular', array(
//             'label' => 'Singular Text for "Forum"',
//             'description' => ' Enter the text which you want to show in place of "Forum" at various places in this plugin like activity feeds, etc.',
//             'allowEmpty' => false,
//             'required' => true,
//             'value' => $settings->getSetting('sesgroupforum.text.singular', 'forum'),
//         ));
// 
//       $this->addElement('Text', 'sesgroupforum_text_plural', array(
//             'label' => 'Plural Text for "Forums"',
//             'description' => 'Enter the text which you want to show in place of "Forums" at various places in this plugin like search form, navigation menu, etc.',
//             'allowEmpty' => false,
//             'required' => true,
//             'value' => $settings->getSetting('sesgroupforum.text.plural', 'forums'),
//         ));

      $this->addElement('Radio', 'sesgroupforum_bbcode', array(
          'label' => 'Enable BBCode',
      'description' => 'Do you want to enable users to use BBCode in their posts?',
          //'description' => 'Do you want to allow thanks.',
          'multiOptions' => array(
              1 => 'Yes, members can use BBCode tags.',
              0 => 'No, do not let members use BBCode.'
          ),
          'value' => $settings->getSetting('sesgroupforum.bbcode', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_html', array(
          'label' => 'Enable HTML',
          'description' => 'Do you want to enable users to use HTML in their posts?',
          'multiOptions' => array(
              1 => 'Yes, members can use HTML in their posts.',
          0 => 'No, members cannot use HTML in their Posts.'
          ),
          'value' => $settings->getSetting('sesgroupforum.html', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_thanks', array(
          'label' => 'Enable "Say Thanks"',
          'description' => 'Do you want to enable users to "Say Thanks" to the members on their topic posts?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroupforum.thanks', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_rating', array(
          'label' => 'Enable Rating',
          'description' => 'Do you want to enable users to give rating on the Forum Topics?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroupforum.rating', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_reputation', array(
          'label' => 'Enable "Reputations"',
          'description' => 'Do you want to enable users to increase/decrease reputation of members for their posts in forum topics?',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroupforum.reputation', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_subscribe', array(
          'label' => 'Allow to Subscribe Topics',
          'description' => 'Do you want to allow members to subscribe to the Forum Topics? If members subscribe, then they will receive notifications when other members reply to their subscribed topics. ',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroupforum.subscribe', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_tag_mandatory', array(
          'label' => 'Make Tags Mandatory',
          'description' => 'Do you want to make tags mandatory for the Topics on your website? Users will be able to enter the tags for their topics while creating or editing topics.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroupforum.tag.mandatory', 1),
      ));

      $this->addElement('Radio', 'sesgroupforum_enable_WYSIWYG', array(
          'label' => 'WYSIWYG Editor',
          'description' => 'Do you want to enable WYSIWYG Editor for forum topics & posts? If you choose No, then simpel text area will be shown.',
          'multiOptions' => array(
              '1' => 'Yes',
              '0' => 'No',
          ),
          'value' => $settings->getSetting('sesgroupforum.enable.WYSIWYG', 1),
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
