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

class Eblog_Widget_tagBlogsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->tagCloudData = Engine_Api::_()->eblog()->tagCloudItemCore('fetchAll');
    if( count($this->view->tagCloudData) <= 0 )
      return $this->setNoRender();
  }
}
