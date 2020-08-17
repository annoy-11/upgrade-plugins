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
class Sespage_Widget_CategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->sespage()->getWidgetParams($this->view->identity);

    if (!empty($_GET['category_id']))
      $this->view->category_id = $_GET['category_id'];
    else
      $this->view->category_id = 0;

    $this->view->categories = Engine_Api::_()->getDbTable('categories', 'sespage')->getCategory(array('column_name' => '*', 'limit' => $params['count_category']));
    if (count($this->view->categories) <= 0)
      return $this->setNoRender();
  }

}
