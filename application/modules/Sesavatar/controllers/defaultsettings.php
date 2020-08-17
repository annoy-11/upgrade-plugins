<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$db->query('UPDATE `engine4_user_signup` SET `enable` = "0" WHERE `engine4_user_signup`.`class` = "User_Plugin_Signup_Photo";');
$this->uploadBackgrounds();

