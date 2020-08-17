<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Publish.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Plugin_Task_Publish extends Core_Plugin_Task_Abstract {
  public function execute() {
    Engine_Api::_()->sesrecipe()->checkRecipeStatus();
  }
}