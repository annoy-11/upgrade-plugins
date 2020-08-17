<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesserverwp
 * @package    Sesserverwp
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php  2019-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesserverwp_Installer extends Engine_Package_Installer_Module{
	public function onPreinstall()
	{
		$db = $this->getDb();
		parent::onPreinstall();
	}
	public function onInstall()
	{
		$db = $this->getDb();
		parent::onInstall();
	}
}
?>