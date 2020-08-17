<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageoffer_Widget_CarouselController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $this->view->allparams = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $value['limit'] = $params['limit_data'];
    $value['order'] = $params['info'];
    $value['fetchAll'] = true;

    $this->view->paginator = Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer')->getOffersSelect($value);
    if (count($this->view->paginator) <= 0)
      return $this->setNoRender();
  }

}
