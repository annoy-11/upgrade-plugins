<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Edocument_Widget_LikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    if (empty($this->view->viewer_id))
      return $this->setNoRender();

    if (!Engine_Api::_()->core()->hasSubject('edocument'))
      return $this->setNoRender();

    $this->view->subject = $documentItem = Engine_Api::_()->core()->getSubject('edocument');
    $this->view->subject_id = $documentItem->getIdentity();

    $likeUser = Engine_Api::_()->sesbasic()->getLikeStatus($this->view->subject_id, 'edocument');
    $this->view->likeClass = (!$likeUser) ? 'fa-thumbs-up' : 'fa-thumbs-down' ;
    $this->view->likeText = ($likeUser) ?  $this->view->translate('Unlike') : $this->view->translate('Like') ;
  }
}
