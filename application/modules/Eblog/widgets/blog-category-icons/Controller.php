<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_BlogCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();

    if (in_array('countBlogs', $allParams['show_criteria']) || $allParams['criteria'] == 'most_blog')
      $allParams['countBlogs'] = true;
    
    $allParams['column_name'] = array('category_name', 'cat_icon', 'thumbnail', 'color', 'slug');
    
    $this->view->paginator = Engine_Api::_()->getDbTable('categories', 'eblog')->getCategory($allParams);
    if (count($this->view->paginator) == 0)
      return;
  }
}
