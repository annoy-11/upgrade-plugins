<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Decisionmaker.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Form_Dashboard_Decisionmaker extends Engine_Form
 {
 	public function init()
 	{
        $this->setTitle('Decision Maker');

    $this->addElement('Text', 'name', array(
        'label' => 'User Name',
        'placeholder' => 'Enter User Name',
        'allowEmpty' => false,
        'required' => true,
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div'))
        ),
    ));
        $this->addElement('Hidden', 'user_id', array(
            'required'=>true,
        ));

		 $this->addElement('Button', 'search', array(
        'label' => 'Submit',
        'type' => 'submit',
        'ignore' => true,
    ));
        $this->addElement('Cancel', 'cancel', array(
            'label' => 'cancel',
            'link' => true,
            'prependText' => ' or ',
            'href' => '',
            'onclick' => 'parent.Smoothbox.close();',
            'decorators' => array(
                'ViewHelper'
            )
        ));
        $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
        $button_group = $this->getDisplayGroup('buttons');
 	}
}

?>