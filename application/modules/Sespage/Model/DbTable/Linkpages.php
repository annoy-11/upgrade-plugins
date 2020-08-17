<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Linkpages.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespage_Model_DbTable_Linkpages extends Engine_Db_Table {

  protected $_rowClass = "Sespage_Model_Linkpage";

  public function getLinkPagesPaginator($params = array()) {
    return Zend_Paginator::factory($this->getLinkPageSelect($params));
  }

  public function getLinkPageSelect($params = array()) {
    $pageTable = Engine_Api::_()->getDbTable('pages', 'sespage');
    $pageTableName = $pageTable->info('name');
    $linkpageTableName = $this->info('name');
    $select = $pageTable->select()->setIntegrityCheck(false);
    $select->from($pageTableName);
    $select->join($linkpageTableName, "$linkpageTableName.link_page_id = $pageTableName.page_id", 'active')
            ->where($linkpageTableName . '.page_id = ?', $params['page_id']);
    return $select;
  }

}
