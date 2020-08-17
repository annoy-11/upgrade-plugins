<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Publish.php  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Plugin_Task_Publish extends Core_Plugin_Task_Abstract {
  public function execute() {
    Engine_Api::_()->sesjob()->checkJobStatus();
  }
}
