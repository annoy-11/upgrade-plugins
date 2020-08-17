<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Eblog_Widget_FavouriteButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
		if (empty($this->view->viewer_id))
      return $this->setNoRender();
      
		if (!Engine_Api::_()->core()->hasSubject('eblog_blog') || !Engine_Api::_()->getApi('settings', 'core')->getSetting('eblog.enable.favourite', 1))
      return $this->setNoRender();
      
		$subject = Engine_Api::_()->core()->getSubject('eblog_blog');
		
		$this->view->subject_id = $subject->getIdentity();
		
		$this->view->favStatus = Engine_Api::_()->getDbtable('favourites', 'eblog')->isFavourite(array('resource_type' => $subject->getType(),'resource_id' => $this->view->subject_id));
  }
}
