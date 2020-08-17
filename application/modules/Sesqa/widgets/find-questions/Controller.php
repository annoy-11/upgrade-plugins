<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_FindQuestionsController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->params = $params = Engine_Api::_()->sesqa()->getWidgetParams($this->view->identity);
    $show_criterias = $params['enableTabs'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    $this->view->categories = Engine_Api::_()->getDbtable('categories', 'sesqa')->getCategory(array('column_name' => '*', 'profile_type' => true));
  }

}
