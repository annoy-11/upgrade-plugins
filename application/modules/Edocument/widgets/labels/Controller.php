<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_LabelsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->subject = $subject = Engine_Api::_()->core()->getSubject();

    if(empty($subject->featured) && empty($subject->sponsored) && empty($subject->verified))
      return $this->setNoRender();
  }
}
