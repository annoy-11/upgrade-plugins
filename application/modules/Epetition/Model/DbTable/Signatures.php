<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Signatures.php 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Epetition_Model_DbTable_Signatures extends Engine_Db_Table
{

  //protected $_rowClass = 'Epetition_Model_Signature';
  protected $_name = 'epetition_signatures';

  /**
   * Signature All User
   */
  public function signAllUser($eptition_id)
  {
    $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
    $data = $table->select()->from($table->info('name'), 'owner_id')
      ->where('epetition_id =?', $eptition_id)
      ->query()
      ->fetchAll();
    return $data;
  }
  /**
   * Signature Selected
   */
  public function getEpetitionSignatureSelect($params = array())
  {
    $table = Engine_Api::_()->getDbTable('signatures', 'epetition');
    $petitionSignatureTableName = $table->info('name');
    $select = $table->select()->from($petitionSignatureTableName);

    $currentTime = date('Y-m-d H:i:s');
    if (isset($params['view'])) {
      if ($params['view'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['view'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      }
    }


    //Full Text
    if (isset($params['order']) && !empty($params['order'])) {
//      if ($params['order'] == 'featured')
//      { $select->where('featured = ?', '1'); }
//      elseif ($params['order'] == 'verified')
//      { $select->where('verified = ?', '1'); }
      if ($params['order'] == 'week') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      } elseif ($params['order'] == 'month') {
        $endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
        $select->where("DATE(creation_date) between ('$endTime') and ('$currentTime')");
      }
    }
    if (isset($params['epetition_id']) && !empty($params['epetition_id'])) {
      $select->where($petitionSignatureTableName . '.epetition_id =?', $params['epetition_id']);
    }


    if (isset($params['limit']) && !empty($params['limit'])) {
      $select->limit($params['limit']);
    }
    if (!empty($params['limit_data'])) {
      $select->limit($params['limit_data']);
      $select->order($petitionSignatureTableName . '.creation_date DESC');
    }

    if (isset($params['paginator'])) {
      //return $table->fetchAll($select);
      return Zend_Paginator::factory($table->fetchAll($select));
    }

    if (isset($params['fetchAll'])) {
      return $table->fetchAll($select);
    } else {
      return $select;
    }

  }

  /**
   * Signature detail
   */
  public function isSignature($params = array())
  {
    $viewerId = Engine_Api::_()->user()->getViewer()->getIdentity();
    $select = $this->select()
      ->from($this->info('name'), 'signature_id')
      ->where('epetition_id = ?', $params['epetition_id'])
      ->where('owner_id = ?', $viewerId);
    return $select = $select->query()->fetchColumn();
  }

  public function getRating($resource_id)
  {
    $rating_sum = $this->select()
      ->from($this->info('name'), new Zend_Db_Expr('SUM(rating)'))
      ->group('epetition_id')
      ->where('epetition_id = ?', $resource_id)
      ->query()
      ->fetchColumn(0);
    $total = $this->ratingCount($resource_id);
    if ($total)
      $rating = $rating_sum / $total;
    else
      $rating = 0;
    return $rating;
  }

  // rating functions

  public function ratingCount($resource_id = NULL)
  {
    $rName = $this->info('name');
    return $this->select()
      ->from($rName, new Zend_Db_Expr('COUNT(signature_id) as total_rating'))
      ->where($rName . '.epetition_id = ?', $resource_id)
      ->limit(1)->query()->fetchColumn();
  }

  public function getSumRating($resource_id)
  {
    $rName = $this->info('name');
    $rating_sum = $this->select()
      ->from($rName, new Zend_Db_Expr('SUM(rating)'))
      ->where('epetition_id = ?', $resource_id)
      ->group('epetition_id')
      ->query()
      ->fetchColumn();
    return $rating_sum;
  }

  /**
   * Signature Count
   */
  public function getSignatureCount($resource_id)
  {
    return $this->select()
      ->from($this->info('name'), 'signature_id')
      ->where('epetition_id = ?', $resource_id)
      ->query()
      ->fetchAll(Zend_Db::FETCH_COLUMN);
  }

  /**
   * Signature Count according Petition id
   */
  public function getUserSignatureCount($params = array())
  {
    $select = $this->select()
      ->where('epetition_id = ?', $params['epetition_id']);
    if ($params['rating']) {
      $select = $select->where('rating =?', $params['rating']);
    }
    return $this->fetchAll($select);
  }

  // Signature for pagenation

  public function getSignaturesPaginator($params = array())
  {
    $paginator = Zend_Paginator::factory($this->getSignatureSelect($params));
    if (!empty($params['page'])) {
      $paginator->setCurrentPageNumber($params['page']);
    }
    if (!empty($params['limit'])) {
      $paginator->setItemCountPerPage($params['limit']);
    }

    if (empty($params['limit'])) {
      $paginator->setItemCountPerPage(10);
    }

    return $paginator;
  }

  /**
   * Signature filter
   */
  public function getSignatureSelect($params = array())
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
    // $rName = $table->info('name');
    //  //$tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
    // // $tmName = $tmTable->info('name');
    $select = $table->select();
    if (isset($params['owner_id']) && !empty($params['owner_id'])) {
      $select = $select->where('owner_id =?', $params['owner_id']);
    }
    if (isset($params['epetition_id']) && !empty($params['epetition_id'])) {
      $select = $select->where('epetition_id =?', $params['epetition_id']);
    }
    if (isset($params['name']) && !empty($params['name'])) {
      $select = $select->where('first_name =?', $params['name']);
    }
    if (isset($params['user_type']) && $params['user_type'] == 1) {
      $select = $select->where('owner_id >?', 0);
    }
    if (isset($params['user_type']) && $params['user_type'] == 0) {
      $select = $select->where('owner_id =?', null);
    }
    if (isset($params['from_date']) && !empty($params['from_date'])) {
      $select = $select->where('creation_date >=?', $params['from_date']);
    }
    if (isset($params['to_date']) && !empty($params['to_date'])) {
      $select = $select->where('creation_date <=?', $params['to_date']);
    }
    $select = $select->order(!empty($params['orderby']) ? $params['orderby'] . ' DESC' : $rName . '.creation_date DESC');

    return $select;
  }

  /**
   * Signature Owner Details
   */
  public function getOwnerdetail($epetition_id, $viewer_id)
  {
    $table = Engine_Api::_()->getDbtable('signatures', 'epetition');
    $data = $table->select()
      ->where('epetition_id =?', $epetition_id)
      ->where('owner_id =?', $viewer_id)
      ->query()
      ->fetchAll();
    return $data;
  }
}
