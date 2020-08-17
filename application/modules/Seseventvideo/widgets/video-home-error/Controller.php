<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventvideo
 * @package    Seseventvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventvideo_Widget_VideoHomeErrorController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->paginator = Engine_Api::_()->getDbTable('videos', 'seseventvideo')->countVideos(array());
    if (count($this->view->paginator) > 0)
      return $this->setNoRender();
  }

}
