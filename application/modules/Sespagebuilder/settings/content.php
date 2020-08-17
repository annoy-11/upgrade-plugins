<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
//get All popups
$popups = Engine_Api::_()->getItemTable('sespagebuilder_popup')->getContent();
$popupsVals = array();
foreach($popups as $val){
		$popupsVals[$val['popup_id']] = $val['title'];
}
return array(
    array(
        'title' => 'Page Builder - Widgetized Page',
        'description' => 'This widget displays widgetized pages created by you using this plugin.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.pages',
        'adminForm' => 'Sespagebuilder_Form_Admin_Staticpage',
    ),
		array(
        'title' => 'Page Builder - Modal Windows (Popups)',
        'description' => 'This widget displays modal window (popup) created by you from the Admin Panel of this plugin.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.popup',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'popup_id',
                    array(
                        'label' => "Choose popup to be shown in this widget.",
                        'multiOptions' => $popupsVals,
                    )
                ),
								array(
                    'Select',
                    'show_button',
                    array(
                        'label' => "Do you want to show a button clicking on which the chosen popup will open?",
                        'multiOptions' => array(
                            '1' => 'Yes, show button',
                            '0' => 'No, don not show button',
                        ),
                        'value' => '1',
                    )
                ),
								array(
                    'Select',
                    'auto_open',
                    array(
                        'label' => "Do you want the popup to be auto opened?",
                        'multiOptions' => array(
                            '1' => 'Yes, auto open the popup',
                            '0' => 'No, do not auto open the popup',
                        ),
                        'value' => '0',
                    )
                ),
								 array(
                    'Text',
                    'time_execution',
                    array(
                        'label' => 'If you choose to show popup auto-open, then after how much time should the popup be auto-opened??',
                        'value' => 5000,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    )
                ),
            )
				),
    ),
    array(
        'title' => 'Page Builder - Advanced Generic Menu',
        'description' => 'This widget shows a selected menu. You can edit this widget to configure various settings.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.advancedmenu-generic',
        'adminForm' => 'Sespagebuilder_Form_Admin_MenuGeneric',
    ),
    array(
        'title' => 'Page Builder - Page Loading Progress Image',
        'description' => 'This widget displays a loading image when any page of your website is being loaded.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.page-progress-bar',
        'adminForm' => 'Sespagebuilder_Form_Admin_Progressbar',
    ),
    array(
        'title' => 'Page Builder - Accordion Menu',
        'description' => 'This widget displays accordion menu as configured by you from the admin panel of this plugin. You can edit this widget to choose which accordion menu to show in this widget and configure various settings for it.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.accordions',
        'adminForm' => 'Sespagebuilder_Form_Admin_Accordions',
    ),
    array(
        'title' => 'Page Builder - Accordions or Tab Container',
        'description' => 'This widget displays accordion or tab container as chosen by you. You can edit this widget to choose which accordion or tab container to show in this widget and configure various settings for it.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.tabs',
        'adminForm' => 'Sespagebuilder_Form_Admin_Tab'
    ),
    array(
        'title' => 'Page Builder - Pricing Table',
        'description' => 'This widget displays pricing table as chosen by you. You can edit this widget to choose which pricing table to show in this widget and configure various settings for it.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.pricing-table',
        'adminForm' => 'Sespagebuilder_Form_Admin_Pricetable',
    ),
    array(
        'title' => 'Page Builder - Progress Bars',
        'description' => 'This widget displays progress bars as chosen by you. You can edit this widget to choose which progress bar to show in this widget and configure various settings for it.',
        'category' => 'Page Builder and Shortcodes',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sespagebuilder.progressbar',
        'adminForm' => 'Sespagebuilder_Form_Admin_Progressbars'
    )
);
