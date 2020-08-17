<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminLocation.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesweather_Form_Admin_AdminLocation extends Engine_Form {

  public function init() {

    $this->addElement('Radio', 'sesweather_isintegrate', array(
        'label' => 'Do you want to integrate user\'s location in this widget which is entered by users of your website through Advanced Members Plugin?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => 1,
    ));
    $this->addElement('Text', 'location', array(
        'label' => 'Enter location associated to which weather will be displayed in this widget.',
        'id' => 'locationSesList',
    ));
    $this->addElement('Text', 'lat', array(
        'label' => 'Lat',
        'id' => 'latSesList',
    ));
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $headScript = new Zend_View_Helper_HeadScript();
    $headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
    $script = '
    sesJqueryObject(document).ready(function(){
    var params = parent.pullWidgetParams();
    sesJqueryObject("#locationSesList").val(params["location"]);
    sesJqueryObject("#latSesList").val(params["lat"]);
    sesJqueryObject("#lngSesList").val(params["lng"]);
    })';
    $view->headScript()->appendScript($script);

    $this->addElement('Text', 'lng', array(
        'label' => 'Lng',
        'id' => 'lngSesList',
    ));
    $this->addElement('dummy', 'location-data', array(
        'decorators' => array(array('ViewScript', array(
                    'viewScript' => 'application/modules/Sesweather/views/scripts/location.tpl',
                )))
    ));
  }

}
