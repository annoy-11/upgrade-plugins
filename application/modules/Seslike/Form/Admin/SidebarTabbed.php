<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SidebarTabbed.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Form_Admin_SidebarTabbed extends Engine_Form {

    public function init() {

        $moduleEnable = Engine_Api::_()->seslike()->getModulesEnable();
        $this->addElement('Select', "type", array(
            'label' => "Choose Content Type.",
            'multiOptions' => $moduleEnable,
        ));


        $this->addElement('MultiCheckbox', "search_type", array(
            'label' => "Choose from below the Tabs that you want to show in this widget.",
            'multiOptions' => array(
                'week' => 'This Week',
                'month' => 'This Month',
                'overall' => 'Overall',

            ),
        ));

        // setting for This Week
        $this->addElement('Dummy', "dummy1", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'This Week' Tab</span>",
        ));
        $this->getElement('dummy1')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
        $this->addElement('Text', "week_order", array(
            'label' => "Order of this Tab.",
            'value' => '1',
        ));
        $this->addElement('Text', "week_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'This Week',
        ));

        //setting for This Month
        $this->addElement('Dummy', "dummy2", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'This Month' Tab</span>",
        ));
        $this->getElement('dummy2')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "month_order", array(
            'label' => 'Order of this Tab.',
            'value' => '2',
        ));
        $this->addElement('Text', "month_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'This Month',
        ));

        //Setting for Overall
        $this->addElement('Dummy', "dummy3", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Overall' Tab</span>",
        ));
        $this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

        $this->addElement('Text', "overall_order", array(
            'label' => 'Order of this Tab.',
            'value' => '3',
        ));
        $this->addElement('Text', "overall_label", array(
            'label' => 'Title of this Tab.',
            'value' => 'Overall',
        ));

        $this->addElement('Text', "limit", array(
            'label' => 'Number of content to show in this widget.',
            'value' => 3,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
        ));
    }
}
