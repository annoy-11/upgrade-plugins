<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: Core.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesdbslide_Api_Core extends Core_Api_Abstract {
	public function getContantValueXML($key) {
		$filePath = APPLICATION_PATH . "/application/settings/constants.xml";
		$results = simplexml_load_file($filePath);
		$xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
		$nodeName = @$xmlNodes[0];
		$value = @$nodeName->value;
		return $value;
  }
}