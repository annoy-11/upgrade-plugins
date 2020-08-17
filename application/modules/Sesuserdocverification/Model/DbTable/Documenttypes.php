<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Modules
 * @package    Sesuserdocverification
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Documenttypes.php 2019-06-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesuserdocverification_Model_DbTable_Documenttypes extends Engine_Db_Table {

  protected $_rowClass = 'Sesuserdocverification_Model_Documenttype';

  public function getAllDocumentTypes() {

    $stmt = $this->select()
        ->from($this, array('documenttype_id', 'document_name'))
        ->order('document_name ASC')
        ->query();
    $data = array('0' => 'Choose Document Type');
    foreach( $stmt->fetchAll() as $category ) {
      $data[$category['documenttype_id']] = $category['document_name'];
    }
    return $data;
  }
}
