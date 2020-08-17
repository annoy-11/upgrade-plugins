<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesweather
 * @package    Sesweather
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Location.php  2018-08-24 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesweather_Form_Location extends Engine_Form {

  protected $_widgetId;

  public function getWidgetId() {
    return $this->_widgetId;
  }

  public function setWidgetId($widgetId) {
    $this->_widgetId = $widgetId;
    return $this;
  }

  public function init() {
    $this->setAttribs(array('id' => 'sesweather_search_'.$this->getWidgetId(), 'class' => ''))->setMethod('GET');
    $cookiedata = Engine_Api::_()->sesbasic()->getUserLocationBasedCookieData();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $this->addElement('Text', 'location', array(
        'placeholder' => $view->translate('Your Location'),
        'id' => 'locationSesList_'.$this->getWidgetId(),
        'class' => 'sesweather_search',
        'value' => !empty($cookiedata['location']) ? $cookiedata['location'] : '',
        'filters' => array(
            new Engine_Filter_Censor(),
            new Engine_Filter_HtmlSpecialChars(),
        ),
    ));
  }

}
