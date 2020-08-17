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

class Sesqa_Widget_HomeCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $widgetParams = $this->_getAllParams();
    $this->view->widgetParams = $widgetParams;
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'sesqa')->getCategory(array('limit' => $widgetParams['limit_data'], 'criteria' => $widgetParams['criteria']));
    if(count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
  }
}