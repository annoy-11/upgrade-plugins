<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesadvancedbanner
 * @package Sesadvancedbanner
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: defaultsettings.php 2018-07-26 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$db->query('ALTER TABLE `engine4_sesadvancedbanner_slides` ADD `overlay_pettern` VARCHAR(50) DEFAULT NULL;');
$db->query('ALTER TABLE `engine4_sesadvancedbanner_slides` ADD `overlay_type` TINYINT(1) NOT NULL DEFAULT "1"  AFTER overlay_pettern;');
