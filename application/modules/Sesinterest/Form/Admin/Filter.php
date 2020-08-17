<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinterest_Form_Admin_Filter extends Engine_Form {

    public function init() {

        $this->clearDecorators()
                ->addDecorator('FormElements')
                ->addDecorator('Form')
                ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
                ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'));

        $this->setAttribs(array('id' => 'filter_form', 'class' => 'global_form_box'))->setMethod('GET');

        $title = new Zend_Form_Element_Text('interest_name');
        $title->setLabel('Interest Name')
            ->clearDecorators()
            ->addDecorator('ViewHelper')
            ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
            ->addDecorator('HtmlTag', array('tag' => 'div'));

        $status = new Zend_Form_Element_Select('approved');
        $status->setLabel('Approved')
                ->clearDecorators()
                ->addDecorator('ViewHelper')
                ->addDecorator('Label', array('tag' => null, 'placement' => 'PREPEND'))
                ->addDecorator('HtmlTag', array('tag' => 'div'))
                ->setMultiOptions(array(
                    '-1' => '',
                    '0' => 'No',
                    '1' => 'Yes',
                ))
                ->setValue('-1');

        $submit = new Zend_Form_Element_Button('search', array('type' => 'submit'));
        $submit
                ->setLabel('Search')
                ->clearDecorators()
                ->addDecorator('ViewHelper')
                ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'buttons'))
                ->addDecorator('HtmlTag2', array('tag' => 'div'));
        $this->addElement('Hidden', 'order', array(
            'order' => 10001,
        ));
        $this->addElement('Hidden', 'order_direction', array(
            'order' => 10002,
        ));

        $this->addElement('Hidden', 'interest_id', array(
            'order' => 10003,
        ));
        $this->addElements(array($title, $status, $submit));

        // Set default action without URL-specified params
        $params = array();
        foreach (array_keys($this->getValues()) as $key) {
            $params[$key] = null;
        }
        $this->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble($params));
    }
}
