<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesbody_Widget_ScrollBottomTopController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $sesbody_widget = Zend_Registry::isRegistered('sesbody_widget') ? Zend_Registry::get('sesbody_widget') : null;
    if(empty($sesbody_widget))
      return $this->setNoRender();
  }

}
