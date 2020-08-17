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
class Sesbusiness_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);
    $value = array();
    $value['order'] = $params['order'];
    $value['info'] = $params['info'];
    $this->view->paginator = array();
    if ($params['show_popular_businesses']) {
      $this->view->paginator = Engine_Api::_()->getDbTable('businesses', 'sesbusiness')
              ->getBusinessSelect(array_merge($value, array('search' => 1, 'fetchAll' => true, 'limit' => 3)));
    }
  }

}
