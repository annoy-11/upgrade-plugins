<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: BannerSearch.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Estore_Form_BannerSearch extends Engine_Form {

  protected $_widgetId;

  public function getWidgetId() {
    return $this->_widgetId;
  }

  public function setWidgetId($widgetId) {
    $this->_widgetId = $widgetId;
    return $this;
  }

  public function init() {
    $params = Engine_Api::_()->estore()->getWidgetParams($this->getWidgetId());
    $show_criterias = $params['show_criteria'];
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $identity = $view->identity;
    $params = Engine_Api::_()->estore()->getWidgetParams($identity);
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'estore_banner_search_form'))->setMethod('GET');
    $this->setAction($view->url(array('action' => 'browse'), 'estore_general', true));
    if (in_array('title', $show_criterias)) {
      $this->addElement('Text', 'search', array(
          'placeholder' => 'What are you looking for',
      ));
    }
    if (in_array('location', $show_criterias)) {
      $cookiedata = Engine_Api::_()->sesbasic()->getUserLocationBasedCookieData();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('estore_enable_location', 1)) {
        $this->addElement('Text', 'location', array(
            'placeholder' => 'Your Location',
            'id' => 'locationSesList',
            'class' => '',
            'value' => !empty($cookiedata['location']) ? $cookiedata['location'] : '',
            'class' => in_array('location', $show_advSearch) ? $hideClass : '',
            'filters' => array(
                new Engine_Filter_Censor(),
                new Engine_Filter_HtmlSpecialChars(),
            ),
        ));
        $this->addElement('Text', 'lat', array(
            'id' => 'latSesList',
            'style' => 'display:none',
            'value' => !empty($cookiedata['lat']) ? $cookiedata['lat'] : '',
            'filters' => array(
                new Engine_Filter_Censor(),
                new Engine_Filter_HtmlSpecialChars(),
            ),
        ));
        $this->addElement('Text', 'lng', array(
            'id' => 'lngSesList',
            'style' => 'display:none',
            'value' => !empty($cookiedata['lng']) ? $cookiedata['lng'] : '',
            'filters' => array(
                new Engine_Filter_Censor(),
                new Engine_Filter_HtmlSpecialChars(),
            ),
        ));
      }
    }
    if (in_array('category', $show_criterias)) {
      $categories = Engine_Api::_()->getDbTable('categories', 'estore')->getCategoriesAssoc();
      if (count($categories) > 0) {
        $categories = array('' => 'Select Category') + $categories;
        $this->addElement('Select', 'category_id', array(
            'multiOptions' => $categories,
            'onchange' => "showSubCategory(this.value);",
            'class' => in_array('categories', $show_advSearch) ? $hideClass : '',
        ));
      }
    }
    $this->addElement('Button', 'submit', array(
        'label' => 'Search Now',
        'type' => 'submit'
    ));
  }

}
