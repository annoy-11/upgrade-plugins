<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Favourites.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingvideo_Model_DbTable_Favourites extends Engine_Db_Table {

  protected $_rowClass = "Sescrowdfundingvideo_Model_Favourite";

  public function isFavourite($params = array()) {
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()
            ->where('resource_type = ?', $params['resource_type'])
            ->where('resource_id = ?', $params['resource_id'])
            ->where('user_id = ?', $viewer_id)
            ->query()
            ->fetchColumn();
    return $select;
  }

  public function getItemfav($resource_type, $itemId) {
    $tableFav = Engine_Api::_()->getDbtable('favourites', 'sescrowdfundingvideo');
    $tableMainFav = $tableFav->info('name');
    $select = $tableFav->select()->from($tableMainFav)->where('resource_type =?', $resource_type)->where('user_id =?', Engine_Api::_()->user()->getViewer()->getIdentity())->where('resource_id =?', $itemId);
    return $tableFav->fetchRow($select);
  }


}
