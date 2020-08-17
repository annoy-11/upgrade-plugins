<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ReviewSettings.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Form_Admin_Manage_ReviewSettings extends Engine_Form {

  public function init() {

    $this->setDescription('Here, you can configure settings for  reviews of Businesses on your website.');
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $supportTicket = '<a href="http://www.socialenginesolutions.com/tickets" target="_blank">Support Ticket</a>';
    $sesSite = '<a href="http://www.socialenginesolutions.com" target="_blank">SocialEngineSolutions website</a>';
    $descriptionLicense = sprintf('Enter your license key that is provided to you when you purchased this plugin. If you do not know your license key, please drop us a line from the %s section on %s. (Key Format: XXXX-XXXX-XXXX-XXXX)',$supportTicket,$sesSite);
    $this->addElement('Text', "sesbusinessreview_licensekey", array(
        'label' => 'Enter License key',
        'description' => $descriptionLicense,
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('sesbusinessreview.licensekey'),
    ));
    $this->getElement('sesbusinessreview_licensekey')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinessreview.pluginactivated')) {

        $this->addElement('Text', 'sesbusinessreview_plural_manifest', array(
            'label' => 'Plural "businessreviews" Text in URL',
            'description' => 'Enter the text which you want to show in place of "businessreviews" in the URLs of this extension.',
            'value' => $settings->getSetting('sesbusinessreview.plural.manifest', 'businessreviews'),
        ));
        $this->addElement('Text', 'sesbusinessreview_singular_manifest', array(
            'label' => 'Singular "businessreview" Text in URL',
            'description' => 'Enter the text which you want to show in place of "businessreview" in the URLs of this extension.',
            'value' => $settings->getSetting('sesbusinessreview.singular.manifest', 'businessreview'),
        ));
        $this->addElement('Radio', 'sesbusinessreview_allow_review', array(
            'label' => 'Allow Reviews',
            'description' => 'Do you want to allow users to give reviews on businesses on your website? (Users will also be able to rate businesses, if you choose “Yes” for this setting.)',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'onchange' => "allowReview(this.value)",
            'value' => $settings->getSetting('sesbusinessreview.allow.review', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_allow_owner', array(
            'label' => 'Allow Reviews on Own Business',
            'description' => 'Do you want to allow users to give reviews on own business on your website?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.allow.owner', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_show_pros', array(
            'label' => 'Allow Pros in Reviews',
            'description' => 'Do you want to allow users to enter Pros in their reviews?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.show.pros', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_show_cons', array(
            'label' => 'Allow Cons in Reviews',
            'description' => 'Do you want to allow users to enter Cons in their reviews?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.show.cons', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_review_summary', array(
            'label' => 'Allow Description in Reviews',
            'description' => 'Do you want to allow users to enter description in their reviews?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'onchange' => "showEditor(this.value)",
            'value' => $settings->getSetting('sesbusinessreview.review.summary', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_show_tinymce', array(
            'label' => 'Enable WYSIWYG Editor for Description',
            'description' => 'Do you want to enable WYSIWYG Editor for description in reviews?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.show.tinymce', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_show_recommended', array(
            'label' => 'Allow Recommended Option',
            'description' => 'Do you want to allow users to choose to recommend the reviews?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.show.recommended', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_allow_share', array(
            'label' => 'Allow Share Option',
            'description' => 'Do you want to allow users to share reviews on your website?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.allow.share', 1),
        ));
        $this->addElement('Radio', 'sesbusinessreview_show_report', array(
            'label' => 'Allow Report Option',
            'description' => 'Do you want to allow users to report reviews on your website?',
            'multiOptions' => array(
                1 => 'Yes',
                0 => 'No'
            ),
            'value' => $settings->getSetting('sesbusinessreview.show.report', 1),
        ));
        /* text for rating starts */
        $this->addElement('Text', "sesbusinessreview_rating_stars_one", array(
            'label' => 'Mouse over rating text on first star',
            'description' => "Enter the text you want when user mouse over on first star.",
            'value' => $settings->getSetting('sesbusinessreview.rating.stars.one', 'terrible'),
        ));
        $this->addElement('Text', "sesbusinessreview_rating_stars_two", array(
            'label' => 'Mouse over rating text on second star',
            'description' => "Enter the text you want when user mouse over on second star.",
            'value' => $settings->getSetting('sesbusinessreview.rating.stars.two', 'poor'),
        ));
        $this->addElement('Text', "sesbusinessreview_rating_stars_three", array(
            'label' => 'Mouse over rating text on third star',
            'description' => "Enter the text you want when user mouse over on third star.",
            'value' => $settings->getSetting('sesbusinessreview.rating.stars.three', 'average'),
        ));
        $this->addElement('Text', "sesbusinessreview_rating_stars_four", array(
            'label' => 'Mouse over rating text on fourth star',
            'description' => "Enter the text you want when user mouse over on fourth star.",
            'value' => $settings->getSetting('sesbusinessreview.rating.stars.four', 'very good'),
        ));
        $this->addElement('Text', "sesbusinessreview_rating_stars_five", array(
            'label' => 'Mouse over rating text on fifth star',
            'description' => "Enter the text you want when user mouse over on fifth star.",
            'value' => $settings->getSetting('sesbusinessreview.rating.stars.five', 'excellent'),
        ));
        /* review votes */
        $this->addElement('Select', 'sesbusinessreview_review_votes', array(
            'label' => 'Enable Review Votes',
            'description' => 'Do you want user of your site give votes on given review.',
            'multiOptions' => array(
                1 => "Yes, allow review votes",
                0 => 'No, Don\'t allow review votes'
            ),
            'onchange' => 'showReviewVotes(this.value)',
            'value' => $settings->getSetting('sesbusinessreview.review.votes', 1),
        ));
        $this->addElement('Text', "sesbusinessreview_review_first", array(
            'label' => 'Text for review vote "Useful"',
            'description' => 'Enter the text for "Useful" for review votes.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesbusinessreview_review_first', 'Useful'),
        ));
        $this->addElement('Text', "sesbusinessreview_review_second", array(
            'label' => 'Text for review vote "Funny"',
            'description' => 'Enter the text for "Funny" for review votes.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesbusinessreview_review_second', 'Funny'),
        ));
        $this->addElement('Text', "sesbusinessreview_review_third", array(
            'label' => 'Text for review vote "Cool"',
            'description' => 'Enter the text for "Cool" for review votes.',
            'allowEmpty' => false,
            'required' => true,
            'value' => $settings->getSetting('sesbusinessreview_review_third', 'Cool'),
        ));
        $this->addElement('Button', 'execute', array(
            'label' => 'Save Changes',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array('ViewHelper'),
        ));
    } else {

      //Add submit button
      $this->addElement('Button', 'submit', array(
          'label' => 'Activate your plugin',
          'type' => 'submit',
          'ignore' => true
      ));
    }
  }

}
