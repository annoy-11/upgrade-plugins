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

class Estore_Widget_CategoryCarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $value = array();
    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    $this->view->criteria = $value['criteria'] = $params['criteria'];
    if ($params['limit_data'])
      $value['limit'] = $params['limit_data'];
    $this->view->paginator = Engine_Api::_()->getDbTable('categories', 'estore')->getCategory($value);
    if (count($this->view->paginator) == 0)
      return $this->setNoRender();
  }

}
