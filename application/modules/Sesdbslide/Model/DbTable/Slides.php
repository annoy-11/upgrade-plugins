<?php
/**
 * SocialEngineSolutions
 *
 * @category Application_Sesdbslide
 * @package Sesdbslide
 * @copyright Copyright 2018-2019 SocialEngineSolutions
 * @license http://www.socialenginesolutions.com/license/
 * @version $Id: slides.php 2018-07-05 00:00:00 SocialEngineSolutions $
 * @author SocialEngineSolutions
 */
class Sesdbslide_Model_DbTable_slides extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Sesdbslide_Model_Slide";

    public function getSlides($id, $show_type = '', $status = false, $params = array()) {
        
      
        $viewer = Engine_Api::_()->user()->getViewer();
        $tableName = $this->info('name');
        $select = $this->select()
                ->where('gallery_id =?', $id['gallery_id']);
        
        if (empty($show_type))
            $select->where('status =?', 1);
        $select->from($tableName);
        if (isset($id['order']) && $id['order'] == 'random') {
            $select->order('RAND()');
        } else
            $select->order('order ASC');
        
        if(isset($id['limit']) && $id['limit'] != 0)
            $select->limit($id['limit']);
        
        
         if (empty($show_type)){
            if ($status)
                $select = $select->where('status = 1');
            if($viewer->getIdentity() && $viewer->level_id)
                $select = $select->where("FIND_IN_SET($viewer->level_id, `member_level_view_privacy`) OR member_level_view_privacy is null or member_level_view_privacy = ''");
            else
                $select = $select->where("member_level_view_privacy IS NULL || member_level_view_privacy = ''");
            if($viewer->getIdentity()){
                $networkTableName = 'engine4_network_membership';
                $select->setIntegrityCheck(false)
                        ->joinLeft($networkTableName,' (FIND_IN_SET('.$networkTableName.'.resource_id,'.$tableName.'.network_view_privacy)) AND '.$networkTableName.'.user_id = '.$viewer->getIdentity().' AND  active = 1 AND resource_approved = 1 AND user_approved = 1',array('resource_id'));
                $select->group($this->info('name').'.slide_id');
                $select->where('CASE WHEN network_view_privacy IS NOT NULL AND network_view_privacy != "" && resource_id IS NOT NULL THEN true WHEN network_view_privacy IS NOT NULL AND network_view_privacy != "" && resource_id IS NULL THEN false ELSE true END ');
            }else{
                $select = $select->where("network_view_privacy IS NULL || network_view_privacy = ''");
            }
         }
         
        return $this->fetchAll($select);
    }

    public function getDbslidePaginator($params = '',$showtpe = '') {


        $paginator = Zend_Paginator::factory($this->getSlides($params,$showtpe));

        return $paginator;
    }

}
