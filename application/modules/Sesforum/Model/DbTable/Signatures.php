<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesforum
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Signatures.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesforum_Model_DbTable_Signatures extends Engine_Db_Table
{
  protected $_rowClass = 'Sesforum_Model_Signature';
  public function getSignature()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $select = $this->select()
      ->where("user_id = ?", $viewer->getIdentity())
      ->limit(1);
    return $this->fetchRow($select);
  }
}
