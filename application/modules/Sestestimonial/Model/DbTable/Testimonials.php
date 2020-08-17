<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Testimonials.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sestestimonial_Model_DbTable_Testimonials extends Engine_Db_Table {

  protected $_rowClass = "Sestestimonial_Model_Testimonial";

  public function getTestimonials($params = array()) {

    $rName = $this->info('name');
    $select = $this->select()->from($this->info('name'));
    if(empty($params['admin'])) {
        $select->where('approve =?', 1);
    }
    if( !empty($params['description']) ) {
        $select->where($rName.".description LIKE ? OR ".$rName.".body LIKE ?", '%'.$params['description'].'%');
    }

    if( !empty($params['designation']) ) {
        $select->where('designation = ?', $params['designation']);
    }

    if (!empty($params['rating']) && isset($params['rating']))
        $select = $select->where('rating = ?', $params['rating']);

    if (isset($params['user_id']))
        $select = $select->where('user_id =?', $params['user_id']);

    if(!empty($params['limit']))
        $select->limit($params['limit']);

    if(!empty($params['popularitycreteria'])) {
        switch ($params['popularitycreteria']) {
            case 'creation_date':
                $select->order($rName . '.creation_date DESC');
                break;
            case 'modified_date':
                $select->order($rName . '.modified_date DESC');
                break;
            case 'view_count':
                $select->order($rName . '.view_count DESC');
                break;
            case 'like_count':
                $select->order($rName . '.like_count DESC');
                break;
            case 'comment_count':
                $select->order($rName . '.comment_count DESC');
                break;
            case 'helpful_count':
                $select->order($rName . '.helpful_count DESC');
                break;
            case 'ratinghightolow':
                $select->order($rName . '.rating DESC');
                break;
            case 'ratinglowtohigh':
                $select->order($rName . '.rating ASC');
                break;
            case 'random':
                $select->order('Rand()');
                break;
        }
    } else {
        $select->order("testimonial_id DESC");
    }

    if (isset($params['widgettype']) && $params['widgettype'] == 'widget')
      return $this->fetchAll($select);
    else
      return $paginator = Zend_Paginator::factory($select);
  }
}
