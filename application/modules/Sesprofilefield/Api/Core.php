<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Api_Core extends Core_Api_Abstract {

  public function getProfileTypeId($params = array()) {
    $valuesTable = Engine_Api::_()->fields()->getTable('user', 'values');
    $valuesTableName = $valuesTable->info('name');
    return $valuesTable->select()
                    ->from($valuesTableName, array('value'))
                    ->where($valuesTableName . '.item_id = ?', $params['user_id'])
                    ->where($valuesTableName . '.field_id = ?', $params['field_id'])->query()
                    ->fetchColumn();
  }
  
  public function hasEndorsment( $resource_type , $resource_id ) {

    $viewer = Engine_Api::_()->user()->getViewer() ;
    $endorsementsTable = Engine_Api::_()->getItemTable( 'sesprofilefield_endorsements' ) ;
    $endorsementsTableName = $endorsementsTable->info( 'name' ) ;
    $sub_status_select = $endorsementsTable->select()
            ->from( $endorsementsTableName , array ( 'endorsement_id' ) )
            ->where( 'resource_type = ?' , $resource_type )
            ->where( 'resource_id = ?' , $resource_id )
            ->where( 'poster_type =?' , $viewer->getType() )
            ->where( 'poster_id =?' , $viewer->getIdentity() )
            ->limit( 1 ) ;
    return $sub_status_select->query()->fetchAll() ;
  }
}