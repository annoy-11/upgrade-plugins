<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvsitenotification
 * @package    Sesadvsitenotification
 * @copyright  Copyright 2016-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: defaultsettings.php 2017-01-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$db = Zend_Db_Table_Abstract::getDefaultAdapter();
$parent_content_id = $db->select()
        ->from('engine4_core_content', 'content_id')
        ->where('type = ?', 'container')
        ->where('page_id = ?', '1')
        ->where('name = ?', 'main')
        ->limit(1)
        ->query()
        ->fetchColumn();
$db->insert('engine4_core_content', array(
    'type' => 'widget',
    'name' => 'sesadvsitenotification.notification',
    'page_id' => 1,
    'parent_content_id' => $parent_content_id,
    'order' => 20,
));