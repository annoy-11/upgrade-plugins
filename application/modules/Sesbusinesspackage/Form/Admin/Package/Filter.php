<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspackage
 * @package    Sesbusinesspackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Filter.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspackage_Form_Admin_Package_Filter extends Engine_Form {

  public function init() {
    $this
            ->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('Form')
            ->addDecorator('HtmlTag', array('tag' => 'div', 'class' => 'search'))
            ->addDecorator('HtmlTag2', array('tag' => 'div', 'class' => 'clear'))
    ;

    $this
            ->setAttribs(array(
                'id' => 'filter_form',
                'class' => 'global_form_box',
            ))
            ->setMethod('GET')
    ;

    // Element: query
    $this->addElement('Text', 'query', array(
        'label' => 'Package Title',
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div')),
        ),
    ));

    // Element: enabled
    $this->addElement('Select', 'enabled', array(
        'label' => 'Enabled',
        'multiOptions' => array(
            '' => '',
            '1' => 'Yes',
            '0' => 'No',
        ),
        'decorators' => array(
            'ViewHelper',
            array('Label', array('tag' => null, 'placement' => 'PREPEND')),
            array('HtmlTag', array('tag' => 'div')),
        ),
    ));


    // Element: order
    $this->addElement('Hidden', 'order', array(
        'order' => 10004,
    ));

    // Element: direction
    $this->addElement('Hidden', 'direction', array(
        'order' => 10005,
    ));

    // Element: execute
    $this->addElement('Button', 'execute', array(
        'label' => 'Search',
        'type' => 'submit',
        'decorators' => array(
            'ViewHelper',
            array('HtmlTag', array('tag' => 'div', 'class' => 'buttons')),
            array('HtmlTag2', array('tag' => 'div')),
        ),
    ));
  }

}
