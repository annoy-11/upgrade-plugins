<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Widget_PagesSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['criteria'] = $params['criteria'];
    $value['info'] = $params['info'];
    $value['order'] = $params['order'];
    $value['limit'] = 3;
    $value['left'] = 1;
    $value['category_id'] = $params['category_id'];

    $selectLeft = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageSelect($value);
    $sespage_sespagewidget = Zend_Registry::isRegistered('sespage_sespagewidget') ? Zend_Registry::get('sespage_sespagewidget') : null;
    if(empty($sespage_sespagewidget)) {
      return $this->setNoRender();
    }
    $limit = $params['limit_data'];
    $valueRight['criteria'] = $params['criteria_right'];
    $valueRight['info'] = $params['info_right'];
    $valueRight['order'] = $params['order'];
    $valueRight['right'] = 1;
    $valueRight['category_id'] = $params['category_id'];
    if ($params['enableSlideshow']) {
      $valueRight['limit'] = $limit;
    } else {
      $valueRight['limit'] = 1;
    }
    $selectRight = Engine_Api::_()->getDbTable('pages', 'sespage')->getPageSelect($valueRight);
    $Select = "SELECT t.* FROM (($selectLeft) UNION  ($selectRight)) as t";
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->pages = $db->query($Select)->fetchAll();
    if (count($this->view->pages) < 4)
      return $this->setNoRender();
  }

}
