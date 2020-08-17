<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmemveroth
 * @package    Sesmemveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Verifications.php  2018-03-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmemveroth_Model_DbTable_Verifications extends Engine_Db_Table {

  protected $_rowClass = 'Sesmemveroth_Model_Verification';
  protected $_name = 'sesmemveroth_verifications';

  public function isVerify($params = array()) {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    return $this->select()->from($this->info('name'), 'verification_id')
                    ->where('resource_id = ?', $params['resource_id'])
                    ->where('poster_id = ?', $viewer_id)
                    ->query()
                    ->fetchColumn();
  }

  public function getAllUserVerificationRequests($resource_id = null, $params = null) {

    $select = $this->select()->order('verification_id DESC');
    if($resource_id) {
      $select = $select->where('admin_approved =?', 1)->where('resource_id = ?', $resource_id);
    }

    if($params == 'verifiers') {
      $select = $select->group('poster_id');
    }
    return $select->query()->fetchAll();
  }
}
