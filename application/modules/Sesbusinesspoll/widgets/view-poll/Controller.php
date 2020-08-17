<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinesspoll_Widget_ViewPollController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
	$coreApi = Engine_Api::_()->core();
	if (!$coreApi->hasSubject('sesbusinesspoll_poll'))
      return $this->setNoRender();
	$this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
	$this->view->show_criteria = $show_criterias =  $this->_getParam('show_criteria', array('creation','favouriteButton','vote','likeButton','socialSharing','likecount','favouritecount','viewcount'));
	$this->view->socialshare_icon_limit = $show_criterias =  $this->_getParam('socialshare_icon_limit', 2);
    $this->view->sesbusinesspoll = $poll = Engine_Api::_()->core()->getSubject('sesbusinesspoll_poll');
    $this->view->owner = $owner = $poll->getOwner();
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->pollOptions = $poll->getOptions();
    $this->view->hasVoted = $poll->viewerVoted();
    $this->view->showPieChart = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.showpiechart', false);
    $this->view->canVote=$canvote = $poll->authorization()->isAllowed($viewer, 'vote');
    $this->view->canChangeVote = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesbusinesspoll.canchangevote', false);
    $this->view->canDelete = $canDelete = $poll->authorization()->isAllowed($viewer, 'delete');
    $this->view->canEdit = $poll->authorization()->isAllowed($viewer, 'edit');
    if( !$owner->isSelf($viewer) ) {
      $poll->view_count++;
      $poll->save();
    }
  }

}
