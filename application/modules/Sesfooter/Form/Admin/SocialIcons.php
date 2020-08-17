<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: SocialIcons.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfooter_Form_Admin_SocialIcons extends Engine_Form {

  public function init() {

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
    
    $this->addElement('Text', 'background_color', array(
        'label' => 'Background Color',
        'description' => 'Choose the color for the Background of this widget.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'value' => '#FFAB40',
        'required' => false,
    ));

    $this->addElement('Text', 'text_color', array(
        'label' => 'Title & Icon Color',
        'description' => 'Choose the color for the title and icons.',
        'class' => 'SEScolor',
        'allowEmpty' => true,
        'value' => '#ffffff',
        'required' => false,
    ));

  }

}
