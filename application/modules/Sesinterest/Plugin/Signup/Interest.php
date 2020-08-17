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

class Sesinterest_Plugin_Signup_Interest extends Core_Plugin_FormSequence_Abstract {

 	protected $_name = 'interest';

 	protected $_formClass = 'Sesinterest_Form_Signup_Interest';

 	protected $_script = array('index/signupinterest.tpl', 'sesinterest');

 	protected $_adminFormClass = 'Sesinterest_Form_Admin_Signup_Interest';

 	protected $_adminScript = array('admin-signup/interest.tpl', 'sesinterest');

 	protected $_skip;

 	public function onSubmit(Zend_Controller_Request_Abstract $request) {

        // Form was valid
        $skip = $request->getParam("skip");
        $photoIsRequired = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesinterest.require.interests');
        $finishForm = $request->getParam("nextStep");
        $this->getSession()->coordinates = $request->getParam("coordinates");
        // do this if the form value for "skip" was not set
        // if it is set, $this->setActive(false); $this->onsubmisvalue and return true.

        if( $this->getForm()->isValid($request->getPost()) &&
            $skip != "skipForm" &&
            $finishForm != "finish" ) {
            $this->getSession()->data = $this->getForm()->getValues();
            $this->getSession()->Filedata = $this->getForm()->Filedata->getFileInfo();

            //$this->_resizeImages($this->getForm()->Filedata->getFileName());

            $this->getSession()->active = true;
            $this->onSubmitNotIsValid();
            return false;
        } else if( $skip != "skipForm" &&
            $finishForm == "finish" &&
            isset($_SESSION['TemporaryProfileImg']) ) {
            $this->setActive(false);
            $this->onSubmitIsValid();
            return true;
        } /*else if ( $photoIsRequired && $skip == "skipForm" ) {
            $this->getSession()->active = true;
            $this->onSubmitNotIsValid();
            return false;
        } */
        else if( $skip == "skipForm" || ($finishForm == "finish") ) {
            parent::onSubmit($request);
        }
        // Form was not valid
        else {
            $this->getSession()->active = true;
            $this->onSubmitNotIsValid();
            return false;
        }

	}

    public function onView() {
    }

    public function onProcess() {

        // In this case, the step was placed before the account step.
        // Register a hook to this method for onUserCreateAfter
        if( !$this->_registry->user ) {
            // Register temporary hook
            Engine_Hooks_Dispatcher::getInstance()->addEvent('onUserCreateAfter', array(
                'callback' => array($this, 'onProcess'),
            ));
            return;
        }

        $user = $this->_registry->user;
        // Process
        $data = $this->getSession()->data;
        $interestTable = Engine_Api::_()->getDbTable('interests', 'sesinterest');
        $table = Engine_Api::_()->getDbTable('userinterests', 'sesinterest');
        $form = $this->getForm();
        if( !$this->_skip && !$this->getSession()->skip ) {

            if( 1 ) {
            //if( $form->isValid($data) ) {
                $values = $form->getValues();
                if(count($values) > 0) {
                    $values['user_id'] = $user->getIdentity();
                    if(!empty($values['interests'])) {
                        foreach($values['interests'] as $interest) {

                            $getColumnName = $interestTable->getColumnName(array('column_name' => 'interest_name', 'interest_id' => $interest));
                            $values['interest_name'] = $getColumnName;
                            $values['interest_id'] = $interest;

                            $row = $table->createRow();
                            $row->setFromArray($values);
                            $row->save();
                        }
                    }
                }

                if(!empty($values['custom_interests'])) {
                    $custom_interests = explode(',', $values['custom_interests']);

                    foreach($custom_interests as $custom_interest) {
                        if(empty($custom_interest)) continue;
                        $interest_id = $interestTable->getColumnName(array('column_name' => 'interest_id', 'interest_name' => $custom_interest));
                        if(empty($interest_id)) {
                            $values['interest_name'] = $custom_interest;
                            $values['approved'] = '0';
                            $values['created_by'] = '0';
                            $values['user_id'] = $user->getIdentity();

                            $row = $interestTable->createRow();
                            $row->setFromArray($values);
                            $row->save();

                            //Entry in Userinterest table
                            $valuesUser['interest_name'] = $custom_interest;
                            $valuesUser['interest_id'] = $row->getIdentity();
                            $valuesUser['user_id'] = $user->getIdentity();
                            $rowUser = $table->createRow();
                            $rowUser->setFromArray($valuesUser);
                            $rowUser->save();
                        }
                    }
                }
            }
        }
    }

    public function onAdminProcess($form) {

        $step_table = Engine_Api::_()->getDbtable('signup', 'user');
        $step_row = $step_table->fetchRow($step_table->select()->where('class = ?', 'Sesinterest_Plugin_Signup_Interest'));
        $step_row->enable = $form->getValue('enable');
        $step_row->save();

        $settings = Engine_Api::_()->getApi('settings', 'core');
        $values = $form->getValues();
        $settings->sesinterest_require_interests = $values['require_interests'];

        $form->addNotice('Your changes have been saved.');
    }
}
