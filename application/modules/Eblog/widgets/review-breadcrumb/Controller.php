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

class Eblog_Widget_ReviewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('eblog_review'))
      return $this->setNoRender();

    $this->view->review = $review = $coreApi->getSubject('eblog_review');
    $this->view->content_item = Engine_Api::_()->getItem('eblog_blog', $review->blog_id);
  }

}
