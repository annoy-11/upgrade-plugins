<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_Widget_RecentlyViewedQuoteController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->allParams = $allParams = $this->_getAllParams();
    $this->view->quotes = Engine_Api::_()->getDbtable('recentlyviewitems', 'sesquote')->getitem(array('limit' => $allParams['limit'], 'criteria' => $allParams['criteria']));

    if (count($this->view->quotes) == 0)
      return $this->setNoRender();
  }
}