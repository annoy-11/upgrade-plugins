<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Follower.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdiscussion_Model_Follower extends Core_Model_Item_Abstract {

    protected $_searchTriggers = false;
    public function getTable() {
        if (is_null($this->_table)) {
            $this->_table = Engine_Api::_()->getDbTable('followers', 'sesdiscussion');
        }
        return $this->_table;
    }
}
