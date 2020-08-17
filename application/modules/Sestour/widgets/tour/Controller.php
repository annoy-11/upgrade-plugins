<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestour
 * @package    Sestour
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestour_Widget_TourController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $widgetId = $this->view->identity;
    
    $contentsTable = Engine_Api::_()->getDbtable('content', 'core');
    $this->view->page_id = $page_id = $contentsTable->select()->from($contentsTable->info('name'), 'page_id')->where('content_id =?', $widgetId)->query()->fetchColumn();
    if(empty($page_id))
      return $this->setNoRender();
      
    $toursTable = Engine_Api::_()->getDbtable('tours', 'sestour');
    $tour_id = $toursTable->select()->from($toursTable->info('name'), 'tour_id')->where('page_id =?', $page_id)->query()->fetchColumn();
    if(empty($tour_id))
      return $this->setNoRender();

    $tours = Engine_Api::_()->getItem('sestour_tour', $tour_id);
    if(empty($tours->enabled))
      return $this->setNoRender();
    $this->view->tour = $tours;
    
    $contents = Engine_Api::_()->getDbTable('contents', 'sestour')->getContents($tours->tour_id);
    if(count($contents) == 0)
      return $this->setNoRender();
    $this->view->contents = $contents;
    
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    
    if($viewer_id) {
    
      $userviewsTable = Engine_Api::_()->getDbtable('userviews', 'sestour');
      $this->view->userview_id = $userview_id = $userviewsTable->select()->from($userviewsTable->info('name'), 'userview_id')->where('page_id =?', $page_id)->where('user_id =?', $viewer_id)->query()->fetchColumn();

      if(empty($userview_id) && $tours->automaticopen == 'true') {
        $dbObject = Engine_Db_Table::getDefaultAdapter();
        $dbObject->query('INSERT IGNORE INTO engine4_sestour_userviews (page_id ,user_id) VALUES ("' . $page_id . '", "' . $viewer_id . '");');
      }
    } 
//     else {
//     $dbObject = Engine_Db_Table::getDefaultAdapter();
//     $ipObj = new Engine_IP();
//     $ipExpr = new Zend_Db_Expr($dbObject->quoteInto('UNHEX(?)', bin2hex($ipObj->toBinary())));
//     $ipObjs = new Engine_IP($ipExpr);
//     print_r($ipExpr);die;
//               echo $ipObj->toString(); die;
//       $ip_address = $_SERVER['SERVER_ADDR'];
//       echo $ip_address;die;
//     }
  }
}