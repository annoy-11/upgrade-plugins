<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Publish.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Eblog_Plugin_Task_Publish extends Core_Plugin_Task_Abstract {
  public function execute() {
    Engine_Api::_()->eblog()->checkBlogStatus();
  }
}