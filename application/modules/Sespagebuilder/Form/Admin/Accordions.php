<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Accordions.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Accordions extends Engine_Form {

  public function init() {

    $accordions_array[] = '';
    $accordions = Engine_Api::_()->getItemTable('sespagebuilder_content')->getContent('accordion');
    foreach ($accordions as $accordion) {
      $accordions_array[$accordion['content_id']] = $accordion['title'];
    }

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

    $this->addElement('Radio', 'urlOpen', array(
        'label' => 'Open the URLs in same tab.',
        'multiOptions' => array(
            '0' => 'Yes, open in same tab.',
            '1' => 'No, open in new tab.',
        ),
        'value' => '1',
    ));

    $this->addElement('Select', 'tabName', array(
        'label' => 'Choose content to be shown in this widget.',
        'multiOptions' => $accordions_array,
    ));

    $this->addElement('Radio', 'tab_position', array(
        'label' => 'Choose alignment of menus.',
        'multiOptions' => array(
            'left' => 'Left',
            'center' => 'Center',
            'right' => 'Right'
        ),
        'value' => 'center',
    ));

    $this->addElement('Radio', 'customcolor', array(
        'label' => 'Do you want your own custom colors for this widget?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No, I want Theme based colors.',
        ),
        'value' => 0,
    ));

    $this->addElement('Text', 'accTabBgColor', array(
        'label' => 'Menu Background Color.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'accTabTextColor', array(
        'label' => 'Text Color of Menu.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'accTabTextFontSize', array(
        'label' => "Text Font Size Menu.",
        'value' => '14',
    ));

    $this->addElement('Text', 'subaccTabBgColor', array(
        'label' => 'Sub Menu Background Color',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'subaccTabTextColor', array(
        'label' => 'Text Color of Sub Menu.',
        'value' => 'fffff',
        'class' => 'SEScolor',
    ));

    $this->addElement('Text', 'subaccTabTextFontSize', array(
        'label' => "Text Font Size of Sub Menu.",
        'value' => '14',
    ));

    $this->addElement('Radio', 'show_accordian', array(
        'label' => 'View Type',
        'multiOptions' => array(
            '0' => 'Horiontal',
            '1' => 'Vertical',
        ),
        'value' => 1,
    ));
		
		$this->addElement('Radio', 'accorImage', array(
        'label' => 'Do you want to show icon of menu?',
        'multiOptions' => array(
            '0' => 'No',
            '1' => 'Yes',
        ),
        'value' => 1,
   ));


    $this->addElement('Radio', 'subaccorImage', array(
        'label' => 'What do you want to show for sub Mmnu?',
        'multiOptions' => array(
            '0' => 'Bullets',
            '1' => 'Icon (Uploaded from admin panel).',
        ),
        'value' => 1,
    ));


    $this->addElement('Text', 'width', array(
        'label' => "Enter the width of this widget(in pixels).",
        'value' => '100',
    ));
  }

}
