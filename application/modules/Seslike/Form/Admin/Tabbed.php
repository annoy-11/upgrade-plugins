<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tabbed.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Form_Admin_Tabbed extends Engine_Form {

    public function init() {

        $moduleEnable = Engine_Api::_()->seslike()->getModulesEnable();
        $moduleEnable = array_merge(array('' => 'All'), $moduleEnable);
        $this->addElement('Select', "type", array(
            'label' => "Choose Content Type.",
            'multiOptions' => $moduleEnable,
        ));

        $this->addElement('MultiCheckbox', "show_criteria", array(
        'label' => "Choose from below the details that you want to show in this widget.",
        'multiOptions' => array(
            'likeButton' => 'Like Button',
            'like' => 'Like Counts',
            'title' => 'Content Title',
            'by' => 'Item Owner Name',
        ),
        'escape' => false,
        ));

        $this->addElement('Select', "show_limited_data", array(
            'label' => 'Show only the number of blogs entered in above setting. [If you choose No, then you can choose how do you want to show more blogs in this widget.]',
            'multiOptions' => array(
                '1' => 'Yes',
                '0' => 'No',
            ),
            'value' => '0',
        ));

        $this->addElement('Radio', "pagging", array(
            'label' => "Do you want the blogs to be auto-loaded when users scroll down the page?",
            'multiOptions' => array(
                'auto_load' => 'Yes, Auto Load',
                'button' => 'No, show \'View more\' link.',
                'pagging' => 'No, show \'Pagination\'.'
            ),
            'value' => 'auto_load',
        ));


        $this->addElement('MultiCheckbox', "search_type", array(
            'label' => "Choose from below the Tabs that you want to show in this widget.",
            'multiOptions' => array(
                'recent' => 'Recent',
                'popular' => 'Popular',
                'random' => 'Random',
                'week'=>'This Week',
                'month'=>'This Month',
                'overall' => 'Overall',
            ),
        ));

		$this->addElement('Dummy', "dummy1", array(
            'label' => "<span style='font-weight:bold;'>Order and Title of 'Recent' Tab</span>",
        ));
		$this->getElement('dummy1')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

   		$this->addElement('Text', "recent_order", array(
			'label' => "Order of this Tab.",
  			'value' => '1',
        ));
  		$this->addElement('Text', "recent_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Recent',
        ));

		$this->addElement('Dummy', "dummy2", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Popular' Tab</span>",
        ));
		$this->getElement('dummy2')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "popular_order", array(
			'label' => "Order of this Tab.",
			'value' => '2',
        ));
		$this->addElement('Text', "popular_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Popular',
        ));

		$this->addElement('Dummy', "dummy3", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Random' Tab</span>",
        ));
		$this->getElement('dummy3')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "random_order", array(
			'label' => "Order of this Tab.",
			'value' => '3',
        ));
		$this->addElement('Text', "random_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Random',
        ));

		$this->addElement('Dummy', "dummy4", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'This Week' Tab</span>",
        ));
		$this->getElement('dummy4')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "week_order", array(
			'label' => "Order of this Tab.",
			'value' => '4',
        ));
		$this->addElement('Text', "week_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'This Week',
        ));

	  // setting for This Month
		$this->addElement('Dummy', "dummy5", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'This Month' Tab</span>",
        ));
		$this->getElement('dummy5')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "month_order", array(
			'label' => 'Order of this Tab.',
			'value' => '5',
        ));
		$this->addElement('Text', "month_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'This Month',
        ));

        // setting for This Month
		$this->addElement('Dummy', "dummy6", array(
			'label' => "<span style='font-weight:bold;'>Order and Title of 'Overall' Tab</span>",
        ));
		$this->getElement('dummy6')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

		$this->addElement('Text', "overall_order", array(
			'label' => 'Order of this Tab.',
			'value' => '6',
        ));
		$this->addElement('Text', "overall_label", array(
			'label' => 'Title of this Tab.',
			'value' => 'Overall',
        ));


        $this->addElement('Text', "limit", array(
            'label' => 'Number of contents to show.',
            'value' => 10,
            'validators' => array(
                array('Int', true),
                array('GreaterThan', true, array(0)),
            ),
        ));
    }
}
