<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialshare
 * @package    Sessocialshare
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Linksaves.php 2017-07-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialshare_Model_DbTable_Linksaves extends Engine_Db_Table {

  protected $_rowClass = "Sessocialshare_Model_Linksave";

  public function isLinkExist($params = array()) {

    $name = $this->info('name');
    return $this->select()
                ->from($this->info('name'), array('linksave_id'))
                ->where('title =?', $params['title'])
                ->where('pageurl =?', $params['pageurl'])
                ->where('creation_date =?', $params['creation_date'])
                ->query()
                ->fetchColumn();

  }
  
  public function socialShareTotalCounter($params = array()) {

    $name = $this->info('name');
    $select = $this->select()
                ->from($this->info('name'), new Zend_Db_Expr('SUM(share_count)'))
                ->where('pageurl =?', $params['pageurl']);
    $select = $select->query()->fetchColumn();
    return $select;
  }
  
  public function socialShareCounter($params = array()) {

    $name = $this->info('name');
    $select = $this->select()
                ->from($this->info('name'), new Zend_Db_Expr('SUM(share_count)'))
                ->where('title =?', $params['title'])
                ->where('pageurl =?', $params['pageurl']);
    if(@$params['from_date'] && @$params['to_date']) {
      $select = $select->where("DATE(creation_date) between ('".$params['from_date']."') and ('".$params['to_date']."')");
    }
    $select = $select->query()->fetchColumn();
    return $select;
  }
}
