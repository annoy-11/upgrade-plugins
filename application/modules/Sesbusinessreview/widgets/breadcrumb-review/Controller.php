<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessreview
 * @package    Sesbusinessreview
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessreview_Widget_BreadcrumbReviewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('businessreview'))
      return $this->setNoRender();
    $this->view->review = $review = $coreApi->getSubject();
    $this->view->content_item = Engine_Api::_()->getItem('businesses', $review->business_id);
    
  }

}
