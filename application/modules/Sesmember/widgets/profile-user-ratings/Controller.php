<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Widget_ProfileUserRatingsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('user'))
      return $this->setNoRender();

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    if ($viewer->getIdentity() == 0)
      return $this->setNoRender();
    $sesmember_profilemembers = Zend_Registry::isRegistered('sesmember_profilemembers') ? Zend_Registry::get('sesmember_profilemembers') : null;
    if (empty($sesmember_profilemembers))
      return $this->setNoRender();
    $this->view->ratingStats = Engine_Api::_()->getDbtable('reviews', 'sesmember')->getUserRatingStats(array('user_id' => $subject->getIdentity()));
    $count = count($this->view->ratingStats->toArray());
    if (!$count)
      return $this->setNoRender();
  }

}
