<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesproduct_Widget_LabelsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    // Get subject and check auth
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

    if(empty($subject->featured) && empty($subject->sponsored) && empty($subject->verified))
      return $this->setNoRender();
  }
}
