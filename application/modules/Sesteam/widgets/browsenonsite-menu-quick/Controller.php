<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesteam_Widget_BrowsenonsiteMenuQuickController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->sesteamType = $this->_getParam('sesteamType', 'nonmember');
    $this->view->linkText = $this->_getParam('linkText', 'Browse Non Site Team');
  }

}
