<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Playlistproducts.php  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesproduct_Model_DbTable_Playlistproducts extends Engine_Db_Table {

  protected $_name = 'sesproduct_playlistproducts';
  protected $_rowClass = 'Sesproduct_Model_Playlistproduct';

  public function getPlaylistProducts($params = array()) {
    return $this->select()
                    ->from($this->info('name'), $params['column_name'])
                    ->where('file_id = ?', $params['file_id'])
                    ->query()
                    ->fetchAll();
  }
  public function playlistProductsCount($params = array()) {
    $row = $this->select()
            ->from($this->info('name'))
            ->where('wishlist_id = ?', $params['wishlist_id'])
            ->query()
            ->fetchAll();
    $total = count($row);
    return $total;
  }

  public function checkProductsAlready($params = array()) {
    return $this->select()
                    ->from($this->info('name'), $params['column_name'])
                    ->where('wishlist_id = ?', $params['wishlist_id'])
                    ->where('file_id = ?', $params['file_id'])
                    //->where('playlistproduct_id = ?', $params['playlistproduct_id'])
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }
  public function getWishedProducts($params = array()) {
   $productTable = Engine_Api::_()->getDbtable('sesproducts', 'sesproduct');
    $productTableName =$productTable->info('name');
    $playlistTable = $this->info('name');
    $select =  $productTable->select()
                    ->setIntegrityCheck(false)
                    ->from($productTableName,'*')
                     ->where('wishlist_id = ?', $params['wishlist_id'])
                    ->joinLeft($playlistTable, $productTableName . '.product_id = ' . $playlistTable . '.file_id',null) ;
                    return $productTable->fetchAll($select);

  }

}
