<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Widget_LikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
		if (empty($viewerId))
		return $this->setNoRender();
		if (!Engine_Api::_()->core()->hasSubject('sesjob_job'))
		return $this->setNoRender();
		$this->view->subject = $jobItem = Engine_Api::_()->core()->getSubject('sesjob_job');
		$this->view->job_id = $jobItem->getIdentity();
		$this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($jobItem, $viewer);
  }

}
