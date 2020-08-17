<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Interest.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Form_Signup_Interest extends Engine_Form {

    public function init() {

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $interestIsRequired = $settings->getSetting('sesinterest.require.interests', 0);
        $minchoint = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.minchoint', 3);
        // Init form
        $this->setTitle('Choose Your Interest');

        $this->setAttrib('enctype', 'multipart/form-data')
            ->setAttrib('id', 'SignupForm')
						->setAttrib('class', 'sesinterest_name');

        $interests = Engine_Api::_()->getDbtable('interests', 'sesinterest')->getResults(array('column_name' => '*', 'approved' => 1));
        $interestsArray = array();
        foreach($interests as $interest) {
            $interestsArray[$interest->interest_id] = $interest->interest_name;
        }

        if(!$interestIsRequired) {
            $this->addElement('MultiCheckbox', 'interests', array(
                'multiOptions' => $interestsArray,
                'registerInArrayValidator' => false,
            ));
        } else {
            $this->addElement('MultiCheckbox', 'interests', array(
                'multiOptions' => $interestsArray,
                'allowEmpty' => false,
                'required' => true,
                'registerInArrayValidator' => false,
            ));
        }

        if($settings->getSetting('sesinterest.userdriven', 0)) {
            $this->addElement('Textarea', "custom_interests", array(
                'label' => 'Custom Interests',
                'description' => 'If you did not found interest above list then, enter your interest separated by comma. EX: Singing, Caring, Dance, Single',
                'allowEmpty' => true,
                'required' => false,
            ));
        }

        $this->addElement('Hash', 'token');

        $this->addElement('Hidden', 'nextStep', array(
            'order' => 3
        ));
        $this->addElement('Hidden', 'skip', array(
            'order' => 4
        ));

        // Element: done
        $this->addElement('Button', 'done', array(
            'label' => 'Save Interests',
            'type' => 'submit',
            'onclick' => 'javascript:finishForm();',
            'decorators' => array(
            'ViewHelper',
            ),
        ));

        if(!$interestIsRequired) {
            // Element: skip
            $this->addElement('Cancel', 'skip-link', array(
                'label' => 'skip',
                'prependText' => ' or ',
                'link' => true,
                'href' => 'javascript:void(0);',
                'onclick' => 'skipForm(); return false;',
                'decorators' => array(
                'ViewHelper',
                ),
            ));
        }
    }
}
