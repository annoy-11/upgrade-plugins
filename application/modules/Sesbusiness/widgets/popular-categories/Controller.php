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

class Sesbusiness_Widget_PopularCategoriesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $widgetParams = $this->_getAllParams();
    $this->view->widgetParams = $widgetParams;
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'sesbusiness')->getCategory(array('limit' => $widgetParams['limit_data'], 'criteria' => $widgetParams['criteria']));
    if (count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
  }

}
