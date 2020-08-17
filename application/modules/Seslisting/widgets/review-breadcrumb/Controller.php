<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslisting_Widget_ReviewBreadcrumbController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $coreApi = Engine_Api::_()->core();
    if (!$coreApi->hasSubject('seslistingreview'))
      return $this->setNoRender();

    $this->view->review = $review = $coreApi->getSubject('seslistingreview');
    $this->view->content_item = Engine_Api::_()->getItem('seslisting', $review->listing_id);
  }

}
