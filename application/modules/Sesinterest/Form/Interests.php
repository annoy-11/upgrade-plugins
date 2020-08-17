<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Interests.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Form_Interests extends Engine_Form {

    public function init() {

        $this->setTitle('Edit Interests')
                ->setDescription('From below you can choose interests.');

        $user_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('user_id', 0);

        $getUserInterests = Engine_Api::_()->getDbTable('userinterests', 'sesinterest')->getUserInterests(array('user_id' => $user_id));
        $userInterestsArray = array();
        foreach($getUserInterests as $getUserInterest) {
            $userInterestsArray[] = $getUserInterest->interest_id;
        }

        $interests = Engine_Api::_()->getDbtable('interests', 'sesinterest')->getResults(array('column_name' => '*', 'approved' => 1));
        $interestsArray = array();
        foreach($interests as $interest) {
            $interestsArray[$interest->interest_id] = $interest->interest_name;
        }

        $this->addElement('MultiCheckbox', 'interests', array(
            'multiOptions' => $interestsArray,
            'registerInArrayValidator' => false,
            'value' => $userInterestsArray,
        ));

        if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.userdriven', 0)) {
            $this->addElement('Textarea', "custom_interests", array(
                'label' => 'Custom Interests',
                'description' => 'If you did not found interest above list then, enter your interest separated by comma. EX: Singing, Caring, Dance, Single',
                'allowEmpty' => true,
                'required' => false,
            ));
        }

        $this->addElement('Button', 'submit', array(
            'label' => 'Save',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array('ViewHelper')
        ));
        $this->addDisplayGroup(array('submit'), 'buttons');
    }
}
