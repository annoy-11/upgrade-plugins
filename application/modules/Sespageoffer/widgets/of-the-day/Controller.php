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
class Sespageoffer_Widget_OfTheDayController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = $this->_getAllParams();

    $show_criterias = @$params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->paginator = $item = Engine_Api::_()->getDbTable('pageoffers', 'sespageoffer')->getOfTheDayResults();
    if (count($item) == 0)
      return $this->setNoRender();
  }
}
