<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Publish.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Plugin_Task_Publish extends Core_Plugin_Task_Abstract {
  public function execute() {
    Engine_Api::_()->seslisting()->checkListingStatus();
  }
}
