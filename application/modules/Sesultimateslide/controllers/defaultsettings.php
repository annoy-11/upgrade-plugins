<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesultimateslide
 * @package    Sesultimateslide
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2018-07-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$db->query('ALTER TABLE `engine4_sesultimateslide_slides` ADD `cta1_button_icon` varchar(50) DEFAULT NULL;');
$db->query('ALTER TABLE `engine4_sesultimateslide_slides` ADD `cta2_button_icon` varchar(50) DEFAULT NULL;');
