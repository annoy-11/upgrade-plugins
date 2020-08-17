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

class Eblog_Widget_CategoryBrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
      
    $this->view->categories = $categories = Engine_Api::_()->getDbTable('categories', 'eblog')->getCategoriesAssoc(array('limit' => $this->_getParam('categoryShow', 10)));

    if(count($categories) == 0)
      return $this->setNoRender();
  }
}
