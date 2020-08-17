<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Newsletteremails.php  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessportz_Model_DbTable_Newsletteremails extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Sessportz_Model_Newsletteremail";

    public function isExist($email) {

        return $this->select()
                        ->from($this->info('name'), array('newsletteremail_id'))
                        ->where('email =?', $email)
                        ->query()
                        ->fetchColumn();
    }
}
