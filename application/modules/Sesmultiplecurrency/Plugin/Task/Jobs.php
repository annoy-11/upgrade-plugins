<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmultiplecurrency
 * @package    Sesmultiplecurrency
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Jobs.php  2018-09-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesmultiplecurrency_Plugin_Task_Jobs extends Core_Plugin_Task_Abstract {
  public function execute() {
		Engine_Api::_()->sesmultiplecurrency()->updateCurrencyValues();	
	}
}