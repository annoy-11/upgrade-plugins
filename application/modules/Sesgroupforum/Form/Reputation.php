<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesgroupforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reputation.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesgroupforum_Form_Reputation extends Engine_Form {

    public function init() {

        $this->setTitle('Add Your Reputation')
                ->setDescription('Add your reputation to this user by submitting this form.');

        $this->addElement('Radio', 'reputation', array(
            'label' => 'Choose Option',
            'multiOptions' => array(
                '1' => 'Increase',
                '0' => 'Decrease',
            ),
            'value' => 1,
        ));

        $this->addElement('Button', 'submit', array(
        'label' => 'Submit ',
        'type' => 'submit',
        'decorators' => array(
            'ViewHelper',
        ),
        ));

        $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'decorators' => array(
            'ViewHelper',
        ),
        'onclick' => 'parent.Smoothbox.close();'
        ));

        $this->addDisplayGroup(array(
        'submit',
        'cancel'
        ), 'buttons', array(
        'decorators' => array(
            'FormElements'
        )
        ));

        $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))->setMethod('POST');
    }
}
