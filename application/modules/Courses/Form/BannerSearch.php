<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Courses
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: BannerSearch.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
class Courses_Form_BannerSearch extends Engine_Form {

  protected $_widgetId;

  public function getWidgetId() {
    return $this->_widgetId;
  }

  public function setWidgetId($widgetId) {
    $this->_widgetId = $widgetId;
    return $this;
  }

  public function init() {
    $params = Engine_Api::_()->courses()->getWidgetParams($this->getWidgetId());
    $show_criterias = $params['show_criteria'];
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $identity = $view->identity;
    $params = Engine_Api::_()->courses()->getWidgetParams($identity);
    $this->setAttribs(array('id' => 'filter_form', 'class' => 'courses_banner_search_form'))->setMethod('GET');
    $this->setAction($view->url(array('action' => 'browse'), 'courses_general', true));
    if (in_array('title', $show_criterias)) {
      $this->addElement('Text', 'search', array(
          'placeholder' => $view->translate('What are you looking for'),
      ));
    }
    if (in_array('category', $show_criterias)) {
      $categories = Engine_Api::_()->getDbTable('categories', 'courses')->getCategoriesAssoc();
      if (count($categories) > 0) {
        $categories = array('' => 'Select Category') + $categories;
        $this->addElement('Select', 'category_id', array(
            'multiOptions' => $categories,
            'onchange' => "showSubCategory(this.value);",
        ));
      }
    }
    $this->addElement('Button', 'submit', array(
        'label' => 'SEARCH NOW',
        'type' => 'submit'
    ));
  }

}
