<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seseventspeaker_Widget_BrowseSpeakersController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    if (isset($_POST['params']))
      $params = json_decode($_POST['params'],true);

    $values = array();
    
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $this->view->viewmore = $this->_getParam('viewmore', 0);
    $this->view->paginationType = $values['paginationType'] = $this->_getParam('paginationType', 1);

    $this->view->width = $values['width'] = isset($params['width']) ? $params['width'] : $this->_getParam('width', 200);
    $this->view->title_truncation_grid = 45;
    $this->view->height = $values['height'] = isset($params['height']) ? $params['height'] : $this->_getParam('height', 200);
    
    $show_criterias = $values['information'] = isset($params['information']) ? $params['information'] : $this->_getParam('information', array('featured', 'sponsored', 'displayname', 'email', 'phone', 'location', 'website', 'facebook', 'linkdin', 'twitter', 'googleplus'));
    if($show_criterias) {
	    foreach ($show_criterias as $show_criteria)
	      $this->view->{$show_criteria . 'Active'} = $show_criteria;
    }
    
    $values['itemCount'] = $itemCount = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('itemCount', 10);
    
    $values['popularity'] = isset($_GET['popularity']) ? $_GET['popularity'] : (isset($params['popularity']) ? $params['popularity'] : '');
    
    $values['title'] = isset($_GET['title_name']) ? $_GET['title_name'] : (isset($params['title_name']) ? $params['title_name'] : '');
    
    $values['alphabet'] = isset($_GET['alphabet']) ? $_GET['alphabet'] : (isset($params['alphabet']) ? $params['alphabet'] : '');

    $this->view->all_params = $values;

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');
    
    $values['widgteName'] = 'Browse Speakers';

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('eventspeakers', 'seseventspeaker')->getSpeakersPaginator($values);
    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }

}
