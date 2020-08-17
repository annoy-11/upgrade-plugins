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
class Sesbusiness_Widget_CategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sesbusiness()->getWidgetParams($this->view->identity);

    if (!empty($_GET['category_id']))
      $this->view->category_id = $_GET['category_id'];
    else
      $this->view->category_id = 0;

    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategory(array('column_name' => '*', 'limit' => $params['count_category']));
    if (count($this->view->categories) <= 0)
      return $this->setNoRender();
  }

}
