<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: ReviewSettings.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Admin_Review_ReviewSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->setTitle('Manage Reviews & Ratings Settings')
            ->setDescription('Here, you can configure settings for  reviews for stores on your website.');

    $this->addElement('Radio', 'estore_allow_review', array(
        'label' => 'Allow Reviews',
        'description' => 'Do you want to allow users to give reviews on stores on your website? (Users will also be able to rate events, if you choose "Yes" for this setting.)',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onchange' => 'allowReview(this.value)',
        'value' => $settings->getSetting('estore.allow.review', 1),
    ));

    $this->addElement('Radio', 'estore_allow_owner', array(
        'label' => 'Allow Reviews on Own Stores',
        'description' => 'Do you want to allow users to give reviews on own stores on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.allow.owner', 1),
    ));

    $this->addElement('Radio', 'estore_show_pros', array(
        'label' => 'Allow Pros in Reviews',
        'description' => 'Do you want to allow users to enter Pros in their reviews?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.show.pros', 1),
    ));

    $this->addElement('Radio', 'estore_show_cons', array(
        'label' => 'Allow Cons in Reviews',
        'description' => 'Do you want to allow users to enter Cons in their reviews?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.show.cons', 1),
    ));

    $this->addElement('Radio', 'estore_review_summary', array(
        'label' => 'Allow Description in Reviews',
        'description' => 'Do you want to allow users to enter description in their reviews?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'onchange' => "showEditor(this.value)",
        'value' => $settings->getSetting('estore.review.summary', 1),
    ));

    $this->addElement('Radio', 'estore_show_tinymce', array(
        'label' => 'Enable WYSIWYG Editor for Description',
        'description' => 'Do you want to enable WYSIWYG Editor for description for reviews?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.show.tinymce', 1),
    ));

    $this->addElement('Radio', 'estore_show_recommended', array(
        'label' => 'Allow Recommended Option',
        'description' => 'Do you want to allow users to choose to recommend the stores in their reviews?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.show.recommended', 1),
    ));

    $this->addElement('Radio', 'estore_allow_share', array(
        'label' => 'Allow Share Option',
        'description' => 'Do you want to allow users to share reviews on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.allow.share', 1),
    ));

    $this->addElement('Radio', 'estore_show_report', array(
        'label' => 'Allow Report Option',
        'description' => 'Do you want to allow users to report reviews on your website?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('estore.show.report', 1),
    ));

    /* text for rating starts */
    $this->addElement('Text', "estore_rating_stars_one", array(
        'label' => 'Mouseover Text for First Star',
        'description' => "Enter the text that you want to display when users mouse over on first rating star.",
        'value' => $settings->getSetting('estore.rating.stars.one', 'terrible'),
    ));
    $this->addElement('Text', "estore_rating_stars_two", array(
        'label' => 'Mouseover Text for Second Star',
        'description' => "Enter the text that you want to display when users mouse over on second rating star.",
        'value' => $settings->getSetting('estore.rating.stars.second', 'poor'),
    ));
    $this->addElement('Text', "estore_rating_stars_three", array(
        'label' => 'Mouseover Text for Third Star',
        'description' => "Enter the text that you want to display when users mouse over on third rating star.",
        'value' => $settings->getSetting('estore.rating.stars.three', 'average'),
    ));
    $this->addElement('Text', "estore_rating_stars_four", array(
        'label' => 'Mouse over rating text on fourth star',
        'description' => "Enter the text that you want to display when users mouse over on fourth rating star.",
        'value' => $settings->getSetting('estore.rating.stars.four', 'very good'),
    ));
    $this->addElement('Text', "estore_rating_stars_five", array(
        'label' => 'Mouseover Text for Fifth Star',
        'description' => "Enter the text that you want to display when users mouse over on fifth rating star.",
        'value' => $settings->getSetting('estore.rating.stars.five', 'excellent'),
    ));

     /* review votes */
    $this->addElement('Select', 'estore_review_votes', array(
        'label' => 'Enable Review Votes',
        'description' => 'Do you want user of your site give votes on given review.',
        'multiOptions' => array(
            1 => "Yes, allow review votes",
            0 => 'No, Don\'t allow review votes'
        ),
        'onchange' => 'showReviewVotes(this.value)',
        'value' => $settings->getSetting('estore.review.votes', 1),
    ));

    $this->addElement('Text', "estore_review_first", array(
        'label' => 'Text for review vote "Useful"',
        'description' => 'Enter the text for "Useful" for review votes',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('estore_review_first', 'Useful'),
    ));

    $this->addElement('Text', "estore_review_second", array(
        'label' => 'Text for review vote "Funny"',
        'description' => 'Enter the text for "Funny" for review votes',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('estore_review_second', 'Funny'),
    ));
    $this->addElement('Text', "estore_review_third", array(
        'label' => 'Text for review vote "Cool"',
        'description' => 'Enter the text for "Cool" for review votes',
        'allowEmpty' => false,
        'required' => true,
        'value' => $settings->getSetting('estore_review_third', 'Cool'),
    ));

    $this->addElement('Button', 'execute', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper'),
    ));

  }

}
