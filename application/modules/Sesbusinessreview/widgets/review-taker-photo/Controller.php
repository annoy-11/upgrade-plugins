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

class Sesbusinessreview_Widget_ReviewTakerPhotoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->title = $this->_getParam('showTitle', 1);
    if (!Engine_Api::_()->core()->hasSubject('businessreview'))
      return $this->setNoRender();
    $this->view->item = $business  = Engine_Api::_()->getItem('businesses', Engine_Api::_()->core()->getSubject('businessreview')->business_id);
    if (!$business) 
      return $this->setNoRender();
  }

}
