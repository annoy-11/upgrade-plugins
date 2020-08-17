<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Contents.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_Model_DbTable_Contents extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Sesshoutbox_Model_Content";

    public function getShoutboxContents($params = array()) {

        $select = $this->select()->from($this->info('name'));

        if (!empty($params)) {

            if (isset($params['shoutbox_id']) && !empty($params['shoutbox_id']))
                $select->where('shoutbox_id = ?', $params['shoutbox_id']);

            if (isset($params['limit']))
                $select->limit($params['limit']);
        }

        $select->order("content_id DESC");

        return $this->fetchAll($select);
    }
}
