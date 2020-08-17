<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Widget_ProfileViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams = $allParams = $this->_getAllParams();

    // Don't render this if not authorized
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    if( !Engine_Api::_()->core()->hasSubject() ) {
      return $this->setNoRender();
    }
     $show_criterias = $allParams['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    // Get subject and check auth
    $this->view->note = $note = Engine_Api::_()->core()->getSubject();
//     if( !$note->authorization()->isAllowed($viewer, 'view') ) {
//       return $this->setNoRender();
//     }

    if (strpos($note->body, '<') === false) {
        $note->body = nl2br($note->body);
    }

    // Get tags
    $this->view->noteTags = $note->tags()->getTagMaps();

  }
}
