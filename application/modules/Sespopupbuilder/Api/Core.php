<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespopupbuilder
 * @package    Sespopupbuilder
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespopupbuilder_Api_Core extends Core_Api_Abstract {
	public function networksJoinedMembers($networks) {
		$userNetworkTable = Engine_Api::_()->getDbtable('membership', 'network');
		$userNetworkTableName = $userNetworkTable->info('name');

		$selectN = $userNetworkTable->select()->where('resource_id IN (?)', $networks);
		$resultsN = $userNetworkTable->fetchAll($selectN);
		return $resultsN;
	}
	public function profileTypesMembers($viwerId) {

        $valuesTable = Engine_Api::_()->fields()->getTable('user', 'values');
        $valuesTableName = $valuesTable->info('name');
        $results = $valuesTable->select()
                                ->from($valuesTableName, 'value')
                                //->where($valuesTableName . '.value IN (?)', $profileTypes)
                                ->where($valuesTableName . '.field_id = ?', 1)
																->where($valuesTableName . '.item_id = ?', $viwerId)
																->query()
                        ->fetchColumn();
        return $results;
    }
}
