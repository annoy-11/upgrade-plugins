<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Listevents.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_Model_DbTable_Listdocuments extends Engine_Db_Table {

  protected $_name = 'sesdocument_listdocuments';
  protected $_rowClass = 'Sesdocument_Model_Listdocument';

  public function getListDocuments($params = array()) {
    return $this->select()
                    ->from($this->info('name'), $params['column_name'])
                    ->where('file_id = ?', $params['file_id'])
                    ->query()
                    ->fetchAll();
  }

  public function listDocumentsCount($params = array()) {

    $row = $this->select()
            ->from($this->info('name'))
            ->where('list_id = ?', $params['list_id'])
            ->query()
            ->fetchAll();
    $total = count($row);
    return $total;
  }

  public function checkDocumentsAlready($params = array()) {

    return $this->select()
                    ->from($this->info('name'), $params['column_name'])
                    ->where('list_id = ?', $params['list_id'])
                    //->where('file_id = ?', $params['file_id'])
                    ->where('listdocument_id = ?', $params['listdocument_id'])
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }

}
