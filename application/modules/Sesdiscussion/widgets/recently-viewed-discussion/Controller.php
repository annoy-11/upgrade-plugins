<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Widget_RecentlyViewedDiscussionController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    $this->view->discussions = Engine_Api::_()->getDbtable('recentlyviewitems', 'sesdiscussion')->getitem(array('limit' => $allParams['limit'], 'criteria' => $allParams['criteria']));

    if (count($this->view->discussions) == 0)
      return $this->setNoRender();
  }
}