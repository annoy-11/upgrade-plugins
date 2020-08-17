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


class Sesqa_Widget_CategoriesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->widgetParams = $this->_getAllParams();
    $this->view->showinformation = $this->_getParam('showinformation', array('title'));
    $this->view->mainblockheight = $this->_getParam('mainblockheight', 200);
    $this->view->mainblockwidth = $this->_getParam('mainblockwidth', 250);
    $this->view->categoryiconheight = $this->_getParam('categoryiconheight', 75);
    $this->view->categoryiconwidth = $this->_getParam('categoryiconwidth', 75);
    $this->view->resultcategories = Engine_Api::_()->getDbTable('categories', 'sesqa')->getCategory();
    if(count($this->view->resultcategories) <= 0)
      return $this->setNoRender();
  }

}
