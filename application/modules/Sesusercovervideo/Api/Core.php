<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesusercovervideo
 * @package    Sesusercovervideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2016-01-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesusercovervideo_Api_Core extends Core_Api_Abstract {
	
	function getModuleRecordsOfUser($item,$user_id) {
	
		$rName = Engine_Api::_()->getItemTable($item);
		
		if( !in_array('owner_id', $rName->info('cols')) )
			$field = 'user_id';
		else
			$field = 'owner_id';

    $rating_sum = $rName->select()
            ->from($rName->info('name'), new Zend_Db_Expr('COUNT(*)'))
            ->where($field.' = ?', $user_id)
            ->group($field)
            ->query()
            ->fetchColumn();
    if (!$rating_sum)
      return 0;
    return $rating_sum;
	}
	
  public function getUserVideo() {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbTable('videos', 'sesusercovervideo');
    $select = $table->select()
                  ->from($table->info('name'))
                  ->where('user_id =?',$viewer->getIdentity())
                  ->order('video_id DESC');
    return Zend_Paginator::factory($select);
	}
}