<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Faqs.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_Model_DbTable_Faqs extends Engine_Db_Table {

  protected $_rowClass = "Sesfaq_Model_Faq";
  
  public function countFaqs($params = array()) {
  
    $select = $this->select()->from($this->info('name'), array('*'))->where($this->info('name') . ".status = ?",1);
    if(isset($params['category_id'])) {
      $select->where('category_id =?', $params['category_id']);
    }
    if(isset($params['subcat_id'])) {
      $select->where('subcat_id =?', $params['subcat_id']);
    }
		if(isset($params['fetchAll'])){
			return  $this->fetchAll($select);
		}
    return Zend_Paginator::factory($select);
  }
  
  public function getFaqPaginator($params = array()) {
    return Zend_Paginator::factory($this->getFaqSelect($params));
  }
  
  public function getCategoryFaqSelect($params = array()) {

    $faqTableName = $this->info('name');

    $select = $this->select()
                ->from($faqTableName)
                ->where("status = ?",1)
                ->where('search =?', 1);
    if($params['onlyFaq'] == '1') {
      $select->where("category_id  = ?", $params['category_id'])
            ->where("subcat_id  = ?",0)
            ->where("subsubcat_id  = ?",0);
    } else if($params['onlyFaq'] == 2) { 
      $select->where("category_id  = ?", $params['category_id'])
            ->where("subcat_id  = ?", $params['subcat_id'])
            ->where("subsubcat_id  = ?",0);
    } else if($params['onlyFaq'] == 3) { 
      $select->where("category_id  = ?", $params['category_id'])
            ->where("subcat_id  = ?", $params['subcat_id'])
            ->where("subsubcat_id  = ?", $params['subsubcat_id']);
    }

    return $this->fetchAll($select);
  }
  
  public function getFaqSelect($params = array()) {
 
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();
	$currentTime = date('Y-m-d H:i:s');
 
    $faqTableName = $this->info('name');

    $categoriesTable = Engine_Api::_()->getDbtable('categories', 'sesfaq');
    $categoriesTableName = $categoriesTable->info('name');
    
    $select = $this->select()
            ->from($faqTableName)
            ->setIntegrityCheck(false)
            ->where("$faqTableName.status = ?",1)
            ->where($faqTableName . '.search =?', 1);
    
    if($viewer_id) {
      $level_id = $viewer->level_id;
      $select->where($faqTableName . '.memberlevels LIKE "%:\"'.$level_id.'\";%"');
    } else {
      $level_id = 5;
      $select->where($faqTableName . '.memberlevels LIKE "%:\"'.$level_id.'\";%"');
    }

    if (isset($params['title']) && $params['title']) {
      $search_text = $params['title'];
      $select->where($faqTableName.".description LIKE '%$search_text%' or ".$faqTableName.".title LIKE '%$search_text%'");
    }
    
    if( !empty($params['tag']) ) {
      $tmName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
      $select->setIntegrityCheck(false)->joinLeft($tmName, "$tmName.resource_id = $faqTableName.faq_id")
            ->where($tmName.'.resource_type = ?', 'sesfaq_faq')
            ->where($tmName.'.tag_id = ?', $params['tag']);
    }
    
    if(isset($params['faq_id']) && !empty($params['faq_id'])) {
      $select->where("$faqTableName.faq_id  <> ?",$params['faq_id']);
    }
    
    if(isset($params['category_id']) && !empty($params['category_id'])) {
      $select->where("$faqTableName.category_id  = ?",$params['category_id']);
    }
    if(isset($params['subcat_id']) && !empty($params['subcat_id'])) {
      $select->where("$faqTableName.subcat_id  = ?",$params['subcat_id']);
    }
    if(isset($params['subsubcat_id']) && !empty($params['subsubcat_id'])) {
      $select->where("$faqTableName.subsubcat_id  = ?",$params['subsubcat_id']);
    }
    if (isset($params['limit'])) {
      $select->limit($params['limit']);
    }
    
    if (isset($params['order']) && !empty($params['order'])) {
      if ($params['order'] == 'featured')
        $select->where('featured = ?', '1');
      elseif ($params['order'] == 'sponsored')
        $select->where('sponsored = ?', '1');
    }
		if(isset($params['order']) && $params['order'] != ''){/* For Ultimate Menu Plugin */
			if ($params['order'] == 'week') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 week"));
				$select->where("DATE(".$faqTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			elseif ($params['order'] == 'month') {
				$endTime = date('Y-m-d H:i:s', strtotime("-1 month"));
				$select->where("DATE(".$faqTableName.".creation_date) between ('$endTime') and ('$currentTime')");
			}
			else{
				$select->order($faqTableName.'.'.$params['order'].' DESC');
			}
		}  
		else {
			$select->order('order ASC');
		}

    if (isset($params['fetchAll'])) {
      return $this->fetchAll($select);
    } else {
      return $select;
    }
  }
}