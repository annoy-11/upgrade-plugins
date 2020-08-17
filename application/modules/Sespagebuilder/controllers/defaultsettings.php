<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$db = Zend_Db_Table_Abstract::getDefaultAdapter();

$column_exist = $db->query("SHOW COLUMNS FROM engine4_sespagebuilder_pagebuilders LIKE 'search'")->fetch();
if (empty($column_exist)) {
  $db->query("ALTER TABLE `engine4_sespagebuilder_pagebuilders` ADD `search` TINYINT NOT NULL DEFAULT '1' AFTER `status`");
}