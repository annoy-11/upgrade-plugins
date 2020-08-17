<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Emailtemplates
 * @package    Emailtemplates
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Emailtemplates_Api_Core extends Core_Api_Abstract
{
  public function networksJoinedMembers($networks) {
        $userNetworkTable = Engine_Api::_()->getDbtable('membership', 'network');
        $userNetworkTableName = $userNetworkTable->info('name');

        $selectN = $userNetworkTable->select()->where('resource_id IN (?)', $networks);
        $resultsN = $userNetworkTable->fetchAll($selectN);
        return $resultsN;
    }

  	public function profileTypesMembers($profileTypes) {

        $valuesTable = Engine_Api::_()->fields()->getTable('user', 'values');
        $valuesTableName = $valuesTable->info('name');
        $select = $valuesTable->select()
                                ->from($valuesTableName)
                                ->where($valuesTableName . '.value IN (?)', $profileTypes)
                                ->where($valuesTableName . '.field_id = ?', 1);
        $results = $valuesTable->fetchAll($select);
        return $results;
    }

  	public function todayBirthdayMembers() {

        $userTable = Engine_Api::_()->getDbTable('users', 'user');
        $userTableName = $userTable->info('name');
        $metaTableName = 'engine4_user_fields_meta';
        $valueTableName = 'engine4_user_fields_values';
        $select = $userTable->select()
                ->setIntegrityCheck(false)
                ->from($userTableName, array('email', 'user_id'))
                ->join($valueTableName, $valueTableName . '.item_id = ' . $userTableName . '.user_id', null)
                ->join($metaTableName, $metaTableName . '.field_id = ' . $valueTableName . '.field_id', array())
                ->where($metaTableName . '.type = ?', 'birthdate')
                ->where("DATE_FORMAT(" . $valueTableName . " .value, '%m-%d') = ?", date('m-d'));
        $results = $userTable->fetchAll($select);
        return $results;
    }


}
