<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfunding_Widget_ProfileLikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();

		if (empty($viewerId))
      return $this->setNoRender();

		if (!Engine_Api::_()->core()->hasSubject('crowdfunding'))
      return $this->setNoRender();

		$this->view->subject = $crowdfundingItem = Engine_Api::_()->core()->getSubject('crowdfunding');
		$this->view->crowdfunding_id = $crowdfundingItem->getIdentity();
		$this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($crowdfundingItem, $viewer);
  }
}
