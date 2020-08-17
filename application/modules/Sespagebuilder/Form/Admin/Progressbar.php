<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Progressbar.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Progressbar extends Engine_Form {

  public function init() {

    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');

    $this->addElement('Radio', 'progressbar', array(
        'label' => 'Choose Loading Image?',
        'description' => '',
        'multiOptions' => array(
            'minimal' => 'Minimal',
            'bigcounter' => 'Big Counter',
            'bounce' => 'Bounce',
            'centeratom' => 'center-atom',
            'centercircle' => 'Center Circle',
            'centerradar' => 'Center Radar',
            'centersimple' => 'center-simple',
            'cornerindicator' => 'Corner Indicator',
            'flash' => 'Flash',
            'flattop' => 'Flat Top',
            'loadingbar' => 'Loading Bar',
        ),
        'value' => "minimal",
    ));

    $this->addElement('Text', 'bg_progressbar_color', array(
        'label' => 'Choose & enter the color for the loading image.',
        'value' => "4eade3",
        'class' => 'SEScolor',
    ));
  }

}
