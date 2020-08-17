<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_GroupsSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sesgroup()->getWidgetParams($this->view->identity);

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['criteria'] = $params['criteria'];
    $value['info'] = $params['info'];
    $value['order'] = $params['order'];
    $value['limit'] = 3;
    $value['left'] = 1;
    $value['category_id'] = isset($params['category_id']) ? $params['category_id'] : 0;;

    $selectLeft = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupSelect($value);
    $sesgroup_sesgroupwidget = Zend_Registry::isRegistered('sesgroup_sesgroupwidget') ? Zend_Registry::get('sesgroup_sesgroupwidget') : null;
    if(empty($sesgroup_sesgroupwidget)) {
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
    $selectRight = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupSelect($valueRight);
    $Select = "SELECT t.* FROM (($selectLeft) UNION  ($selectRight)) as t";
    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->groups = $db->query($Select)->fetchAll();
    if (count($this->view->groups) < 4)
      return $this->setNoRender();
  }

}
