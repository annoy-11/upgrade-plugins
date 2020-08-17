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
 

class Sespage_Widget_RecentlyViewedItemController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);
    $type = $params['criteria'];
    if (($type == 'by_me' || $type == 'by_myfriend') && $this->view->viewer()->getIdentity() == 0)
      return $this->setNoRender();

    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value = array();
    $value['criteria'] = $type;
    $value['limit'] = $params['limit_data'];
    $value['type'] = 'sespage_page';
    $this->view->pages = $paginator = Engine_Api::_()->getDbTable('recentlyviewitems', 'sespage')->getitem($value);
    $this->view->getitem = true;
    if (count($paginator) == 0)
      return $this->setNoRender();
  }

}
