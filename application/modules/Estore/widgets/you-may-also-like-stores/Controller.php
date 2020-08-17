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

class Estore_Widget_YouMayAlsoLikeStoresController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);

    $show_criterias = $params['information'];
    $this->view->height_list = $params['height_list'] ? $params['height_list'] : 230;
    $this->view->width_list = $params['width_list'] ? $params['width_list'] : 260;
     $this->view->height_grid = $params['height_grid'] ? $params['height_grid'] : 230;
    $this->view->width_grid = $params['width_grid'] ? $params['width_grid'] : 260;
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value = array();
    $value['limit'] = $params['limit_data'];
    $value['popularity'] = 'You May Also Like';
    $value['fetchAll'] = 'true';
    $value['category_id'] = $params['category_id'];

    $this->view->results = $results = Engine_Api::_()->getDbTable('stores', 'estore')->getStoreSelect($value);

    if (count($results) <= 0)
      return $this->setNoRender();
  }

}
