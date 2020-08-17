<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_StoreCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;
    if (in_array('countStores', $show_criterias) || $params['criteria'] == 'most_store')
      $params['countStores'] = true;
    $params['fetchAll'] = true;
    $params['limit'] = $params['limit_data'];
    // Get pages category
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'estore')->getCategory($params);

    if (count($paginator) == 0)
      return;
  }

}
