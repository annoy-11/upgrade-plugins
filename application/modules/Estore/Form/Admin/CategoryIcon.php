<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CategoryIcon.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Admin_CategoryIcon extends Engine_Form {

  public function init() {
    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $script = "var hashSign = '#';";
    $view->headScript()->appendScript($script);
    $this->addElement('Text', 'titleC', array(
        'label' => 'Enter the title for this block.',
        'value' => 'What are you in the mood for?',
    ));
    $this->addElement('Select', 'criteria', array(
        'label' => "Choose the order of categories to be shown in this widget.",
        'multiOptions' => array(
            'most_store' => 'Categories with maximum stores first',
            'alphabetical' => 'Alphabetical order',
            'admin_order' => 'Admin selected order for categories',
        ),
    ));
    $this->addElement('MultiCheckbox', 'show_criteria', array(
        'label' => "Choose from below the details that you want to show on each block.",
        'multiOptions' => array(
            'title' => 'Category title',
            'countStores' => 'Store count in each category',
            'followButton' => 'Follow Button',
        ),
    ));
    $this->addElement('Select', 'alignContent', array(
        'label' => "Where you want to show content of this widget?",
        'multiOptions' => array(
            'center' => 'In Center',
            'right' => 'In Right',
            'left' => 'In Left',
        ),
        'value' => 'center',
    ));
    $this->addElement('Select', 'viewType', array(
        'label' => "Choose what do you want to show in this widget.",
        'multiOptions' => array(
            'icon' => 'Category Icons',
            'image' => 'Category Images',
            'both' => 'Both (Icon & Images)',
        ),
    ));
    $this->addElement('Select', 'shapeType', array(
        'label' => "Choose the shape of the category blocks in this widget.",
        'multiOptions' => array(
            'circle' => 'Circle',
            'square' => 'Square',
        ),
    ));
    $this->addElement('Select', 'show_bg_color', array(
        'label' => "Do you want to show the background color of category in this widget?",
        'multiOptions' => array(
            1 => 'Yes, show choosen color (choose background color below).',
            2 => 'Yes, show category color which is chosen from admin panel.',
            0 => 'No, do not show background color.',
        ),
    ));
    $this->addElement('Text', "bgColor", array(
        'label' => 'Choose the background color of Category in this widget..',
        'value' => '#fff',
        'class' => 'SEScolor',
    ));
    $this->addElement('Text', 'height', array(
        'label' => 'Enter the height of one block (in pixels).',
        'value' => '160px',
    ));
    $this->addElement('Text', 'width', array(
        'label' => 'Enter the width of one block (in pixels).',
        'value' => '160px',
    ));

    $this->addElement('Text', 'limit_data', array(
        'label' => 'Count (number of categories to show.)',
        'value' => 10,
        'validators' => array(
            array('Int', true),
            array('GreaterThan', true, array(0)),
        )
    ));
  }

}
