<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Widget_LikeButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
		if (empty($viewerId))
		return $this->setNoRender();
		if (!Engine_Api::_()->core()->hasSubject('seslisting'))
		return $this->setNoRender();
		$this->view->subject = $listingItem = Engine_Api::_()->core()->getSubject('seslisting');
		$this->view->listing_id = $listingItem->getIdentity();
		$this->view->is_like = Engine_Api::_()->getDbTable('likes', 'core')->isLike($listingItem, $viewer);
  }

}
