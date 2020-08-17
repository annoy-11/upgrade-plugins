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
 
class Sesgroup_Widget_GroupLabelsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('sesgroup_group')) {
      return $this->setNoRender();
    }
    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('sesgroup_group');
 
    if (!$subject->hot && !$subject->sponsored && !$subject->featured && !$subject->verified) {
      return $this->setNoRender();
    }
    $this->view->option = $this->_getParam('option', array('hot', 'verified', 'sponsored', 'featured'));
  }

}
