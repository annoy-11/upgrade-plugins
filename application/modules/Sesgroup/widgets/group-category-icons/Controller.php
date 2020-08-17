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
 
class Sesgroup_Widget_GroupCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $params = Engine_Api::_()->sesgroup()->getWidgetParams($this->view->identity);

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;

    if (in_array('countGroups', $show_criterias) || $params['criteria'] == 'most_group')
      $params['countGroups'] = true;
    $this->view->params = $params;
    $params['fetchAll'] = true;

    // Get pages category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sesgroup')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
