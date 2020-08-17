<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslike
 * @package    Seslike
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Mylikesettings.php  2018-12-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslike_Model_DbTable_Mylikesettings extends Engine_Db_Table {

  protected $_rowClass = 'Seslike_Model_Mylikesetting';

  public function isUserSettingExist($user_id) {
        return $this->select()
                ->from($this->info('name'), array('mylikesetting'))
                ->where('user_id =?', $user_id)
                ->query()
                ->fetchColumn();

  }

  public function isUserExist($user_id) {
        return $this->select()
                ->from($this->info('name'), array('mylikesetting_id'))
                ->where('user_id =?', $user_id)
                ->query()
                ->fetchColumn();

  }
}
