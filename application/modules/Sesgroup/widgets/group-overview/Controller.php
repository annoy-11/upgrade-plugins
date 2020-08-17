<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 

class Sesgroup_Widget_GroupOverviewController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject()) {
      return $this->setNoRender();
    }
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject();
    $this->view->editOverview = $editOverview = $subject->authorization()->isAllowed($viewer, 'edit');
    if (!$editOverview && (!$subject->overview || is_null($subject->overview))) {
      return $this->setNoRender();
    }
  }
}