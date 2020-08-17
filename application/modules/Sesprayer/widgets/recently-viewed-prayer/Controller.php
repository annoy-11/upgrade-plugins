<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Widget_RecentlyViewedPrayerController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    $this->view->prayers = Engine_Api::_()->getDbtable('recentlyviewitems', 'sesprayer')->getitem(array('limit' => $allParams['limit'], 'criteria' => $allParams['criteria']));

    if (count($this->view->prayers) == 0)
      return $this->setNoRender();
  }
}