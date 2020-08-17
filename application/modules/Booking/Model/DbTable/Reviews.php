<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Booking
 * @package    Booking
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Reviews.php  2019-03-19 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Booking_Model_DbTable_Reviews extends Engine_Db_Table {
    protected $_rowClass = "Booking_Model_Review";
    
    function getReviews($param = array()) {
        $select = $this->select();
        $select->where('service_id = ?',$param['service_id']);
        $select->order('review_id DESC');
    	return $this->fetchAll($select);
    }
    
    function isReviewAvailable($param = array()) {
        $select = $this->select();
            $select->from($this->info('name'), array('review_id'))
                ->where('user_id = ?',$param['user_id'])
                ->where('service_id =?',$param['service_id']);
        return ($this->fetchRow($select)) ? true : false ;
    }
}
