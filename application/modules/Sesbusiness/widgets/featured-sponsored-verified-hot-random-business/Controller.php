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


class Sesbusiness_Widget_FeaturedSponsoredVerifiedHotRandomBusinessController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['criteria'] = $params['criteria'];
    $value['info'] = 'random';
    $value['order_content'] = $params['order_content'];
    $value['fetchAll'] = true;
    $value['limit'] = 3;
    $value['category_id'] = $params['category_id'];
    $this->view->businesses = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')->getBusinessSelect($value);
    if (count($this->view->businesses) < 1)
      $this->setNoRender();
  }

}
