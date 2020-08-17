<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seserror
 * @package    Seserror
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-05-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seserror_Widget_AuthBgImageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->authpagebgimage = Engine_Api::_()->getApi('settings', 'core')->getSetting('seserror.authpagebgimage', '');
  }

}
