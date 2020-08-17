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
class Sesgroup_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->params = $params = Engine_Api::_()->sesgroup()->getWidgetParams($this->view->identity);
    $value = array();
    $value['order'] = $params['order'];
    $value['info'] = $params['info'];
    $this->view->paginator = array();
    if ($params['show_popular_groups']) {
      $this->view->paginator = Engine_Api::_()->getDbTable('groups', 'sesgroup')
              ->getGroupSelect(array_merge($value, array('search' => 1, 'fetchAll' => true, 'limit' => 3)));
    }
  }

}
