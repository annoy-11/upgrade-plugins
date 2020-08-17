<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgrouppoll_Widget_ListPopularPollsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
		
    // Should we consider views or comments popular?

    $params = $this->_getAllParams();
//    echo '<pre>';print_r($params);die;
    $popularType = $this->_getParam('popular_type', 'vote');
    if( !in_array($popularType, array('comment', 'view', 'vote')) ) {
      $popularType = 'vote';
    }
    $populartype = $params['popular_type']?$params['popular_type']:'most_favourite';
    switch ($populartype) {
      case 'recentlycreated':
        $type = 'Recently Created';
        break;
      case 'mostviewed':
        $type = 'Most Viewed';
        break;
      case 'mostliked':
        $type = 'Most Liked';
        break;
      case 'mostfavourite':
        $type = 'Most Favourites';
        break;
      case 'mostcommented':
        $type = 'Most Commented';
        break;
      case 'mostvoted':
        $type = 'Most Voted';
        break;
    }
    $this->view->popularType = $type;
    $this->view->title_truncation = $params['title_truncation']?$params['title_truncation']:20;
    $this->view->height = 85;
    $this->view->width = 190;
    
    $this->view->show_criteria = $params['show_criteria']?$params['show_criteria']:$this->_getParam('show_criteria',array('like','in', 'comment','by','favourite','title', 'favouriteButton', 'likeButton', 'socialSharing', 'view'));
    $values = array('browse' => true);
    $values['order'] = $params['popular_type'];
    $paginator = Engine_Api::_()->getDbTable('polls', 'sesgrouppoll')->getPollsPaginator($values);
    $this->view->paginator = $paginator;

    $paginator->setItemCountPerPage($params['limit_data']?$params['limit_data']:$this->_getParam('limit',3));
    $paginator->setCurrentPageNumber($this->_getParam('limit',1));
    // Hide if nothing to show
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }
  }
}