<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinviter
 * @package    Sesinviter
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Affiliates.php  2019-01-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesinviter_Model_DbTable_Affiliates extends Core_Model_Item_DbTable_Abstract {

    public function getUserExist() {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();
        $select = $this->select()
                ->from($this->info('name'), array('*'))
                ->where('user_id =?', $viewerId);
        return $this->fetchRow($select);
    }
}
