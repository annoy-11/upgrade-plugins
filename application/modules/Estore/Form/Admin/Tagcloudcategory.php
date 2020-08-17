<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Tagcloudcategory.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_Admin_Tagcloudcategory extends Engine_Form {

  public function init() {

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $script = "var hashSign = '#';";
    $view->headScript()->appendScript($script);

    $this->addElement('Text', "color", array(
        'label' => 'Choose the Color of Category Text for "Cloud View".',
        'value' => '#00f',
        'class' => 'SEScolor',
    ));
    $this->getElement('color')->getDecorator('Label')->setOptions(array('placement' => 'PREPEND', 'escape' => false));


    $this->addElement('Select', 'showType', array(
        'label' => 'View Type',
        'multiOptions' => array(
            'simple' => 'Hierarchy View(If hierarchy View is chosen then make below dependent setting)',
            'tagcloud' => 'Cloud View',
        ),
        'value' => 'simple',
    ));

    $this->addElement('Select', 'placement', array(
        'label' => 'Placement Type (Hierarchy view)',
        'multiOptions' => array(
            'horizontal' => 'Horizontal',
            'vertical' => 'Vertical',
        ),
        'value' => 'vertical',
    ));

    $this->addElement('Radio', 'showSubcategory', array(
        'label' => 'Do you want to show 2nd level categories?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => '1',
    ));

    $this->addElement('Radio', 'showsubsubcategory', array(
        'label' => 'Do you want to show 3rd level categories? (This setting is dependent upon above setting)',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => '1',
    ));

    $this->addElement('Radio', 'styleType', array(
        'label' => 'In collapsed form Showing 2nd level and 3rd level categories',
        'multiOptions' => array(
            '1' => 'On mouse click',
            '0' => 'On mouseover',
        ),
        'value' => '1',
    ));

    $this->addElement('Text', "text_height", array(
        'label' => 'Choose height of category text for ["Cloud View".]',
        'value' => '15',
    ));

    $this->addElement('Text', "height", array(
        'label' => 'Choose height of category container for “Cloud View” (in pixels).',
        'value' => '150',
    ));

    $this->addElement('Text', "count_category", array(
        'label' => 'Count (number of categories to show)',
        'value' => '10',
    ));

//     $this->addElement('Radio', 'seeAllCategory', array(
//         'label' => 'Do you want to show see all link to view all categories?',
//         'multiOptions' => array(
//             '1' => 'Yes',
//             '0' => 'No',
//         ),
//         'value' => '1',
//     ));

    $this->addElement('Text', "count_subcategory", array(
        'label' => 'Count (number of 2nd level categories to show)',
        'value' => '10',
    ));

    $this->addElement('Radio', 'seeAllSubcategory', array(
        'label' => 'Do you want to show see all link to view all 2nd level categories?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => '1',
    ));

    $this->addElement('Text', "count_subsubcategory", array(
        'label' => 'Count (number of 3rd level categories to show)',
        'value' => '10',
    ));

    $this->addElement('Radio', 'seeAllSubsubcategory', array(
        'label' => 'Do you want to show see all link to view all 3rd level categories?',
        'multiOptions' => array(
            '1' => 'Yes',
            '0' => 'No',
        ),
        'value' => '1',
    ));
 /*   $this->addElement('Text', "height_categorytext", array(
        'label' => 'Choose height of category text for Hierarchy view',
        'value' => '10',
        'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
        )
    ));
    $this->addElement('Text', "width_categorytext", array(
        'label' => 'Choose width of category text for Hierarchy view.',
        'value' => '10',
        'validators' => array(
                    array('Int', true),
                    array('GreaterThan', true, array(0)),
        )
    ));*/

  }

}
