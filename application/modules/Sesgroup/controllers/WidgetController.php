<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: WidgetController.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_WidgetController extends Core_Controller_Action_Standard {

  public function requestSesgroupAction() {
    $this->view->notification = $notification = $this->_getParam('notification');
  }

}
