<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_BusinessStatusController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject('businesses'))
      return $this->setNoRender();
    $this->view->subject = Engine_Api::_()->core()->getSubject('businesses');
  }

}
