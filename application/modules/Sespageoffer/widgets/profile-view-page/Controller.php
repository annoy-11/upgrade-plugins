<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Widget_ProfileViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams = $allParams = $this->_getAllParams();

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }
     $show_criterias = @$allParams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    // Get subject and check auth
    $this->view->offer = $offer = Engine_Api::_()->core()->getSubject();
//     if( !$offer->authorization()->isAllowed($viewer, 'view') ) {
//       return $this->setNoRender();
//     }

    if (strpos($offer->body, '<') === false) {
        $offer->body = nl2br($offer->body);
    }

    // Get tags
    $this->view->offerTags = $offer->tags()->getTagMaps();

  }
}
