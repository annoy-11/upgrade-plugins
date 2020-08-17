<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagereview
 * @package    Sespagereview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagereview_Widget_BreadcrumbReviewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('pagereview'))
      return $this->setNoRender();
    $this->view->review = $review = $coreApi->getSubject();
    $this->view->content_item = Engine_Api::_()->getItem('sespage_page', $review->page_id);
    
  }

}
