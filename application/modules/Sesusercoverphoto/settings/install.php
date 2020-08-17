<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercoverphoto
 * @package    Sesusercoverphoto
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: install.php 2016-05-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesusercoverphoto_Installer extends Engine_Package_Installer_Module {

  public function onInstall() {

    $db = $this->getDb();

    //Upgrade Work
    $select = new Zend_Db_Select($db);
    $select
            ->from('engine4_core_modules')
            ->where('name = ?', 'sesusercoverphoto')
            ->where('version < ?', '4.10.3p4');
    $is_enabled = $select->query()->fetchObject();
    if (!empty($is_enabled)) {
        $select = new Zend_Db_Select($db);
        $select->from('engine4_users', array('cover','cover_position', 'user_id', 'coverphoto', 'coverphotoparams'));
        $users = $select->query()->fetchAll();
        foreach($users as $user) {
            $db->query('UPDATE `engine4_users` SET `coverphoto` = "'.$user['cover'].'" WHERE `engine4_users`.`user_id` = "'.$user['user_id'].'";');
            if($user['cover_position']) {
                $coverphotoparams = json_encode(array('top' => str_replace('px', '',$user['cover_position']), 'left' => 0));
                $db->query("UPDATE `engine4_users` SET `coverphotoparams` = '".$coverphotoparams."' WHERE `engine4_users`.`user_id` = '".$user['user_id']."';");
            } else {
                $coverphotoparams = json_encode(array('top' => 0, 'left' => 0));
                $db->query("UPDATE `engine4_users` SET `coverphotoparams` = '".$coverphotoparams."' WHERE `engine4_users`.`user_id` = '".$user['user_id']."';");
            }
        }
    }

    parent::onInstall();
  }
}
