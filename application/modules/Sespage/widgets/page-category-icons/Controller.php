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
 
class Sespage_Widget_PageCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;

    if (in_array('countPages', $show_criterias) || $params['criteria'] == 'most_page')
      $params['countPages'] = true;
    $this->view->params = $params;
    $params['fetchAll'] = true;

    // Get pages category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sespage')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
