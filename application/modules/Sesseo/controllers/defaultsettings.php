<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesseo
 * @package    Sesseo
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php  2019-03-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
$select = Engine_Api::_()->getDbtable('pages', 'core')->select()->where('custom =?', 0)->where('page_id NOT IN (?)', array('1', '2'));
$results = $select->query()->fetchAll();
foreach($results as $result) {
  $db->query('INSERT IGNORE INTO `engine4_sesseo_managemetatags` (`page_id`, `meta_title`, `meta_description`, `file_id`, `enabled`) VALUES ("'.$result["page_id"].'", "'.htmlentities($result["title"]).'", "'.htmlentities($result["description"]).'", 0, 1);');
}
