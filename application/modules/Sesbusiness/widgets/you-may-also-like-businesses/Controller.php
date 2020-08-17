<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_YouMayAlsoLikeBusinessesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);

    $show_criterias = $params['information'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value = array();
    $value['limit'] = $params['limit_data'];
    $value['popularity'] = 'You May Also Like';
    $value['fetchAll'] = 'true';
    $value['category_id'] = $params['category_id'];

    $this->view->results = $results = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect($value);

    if (count($results) <= 0)
      return $this->setNoRender();
  }

}
