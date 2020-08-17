<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesforum_Widget_TagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $tags_count = $this->_getParam('tags_count',5);
     $this->view->tagCloudData  = Engine_Api::_()->sesforum()->tagCloudItemCore('fetchAll',$tags_count,null);
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
