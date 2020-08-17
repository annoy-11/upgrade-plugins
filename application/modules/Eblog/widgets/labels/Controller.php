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

class Eblog_Widget_LabelsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    if(!Engine_Api::_()->core()->hasSubject('eblog_blog'))
      return $this->setNoRender();
      
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();
    if(empty($subject->featured) && empty($subject->sponsored) && empty($subject->verified))
      return $this->setNoRender();
  }
}
