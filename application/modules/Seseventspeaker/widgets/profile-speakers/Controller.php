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

class Seseventspeaker_Widget_ProfileSpeakersController extends Engine_Content_Widget_Abstract {

  protected $_childCount;

  public function indexAction() {

    if (isset($_POST['params']))
      $params = json_decode($_POST['params'],true);
		
		$subject = Engine_Api::_()->core()->getSubject();
		$event_id = $subject->getIdentity();
		
    $values = array();
    $viewer = Engine_Api::_()->user()->getViewer();
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->view->viewer_id = $viewer->getIdentity();
    $this->view->viewmore = $this->_getParam('viewmore', 0);
    $this->view->paginationType = $paginationType = $this->_getParam('paginationType', 1);

    $this->view->width = $width = isset($params['width']) ? $params['width'] : $this->_getParam('width', 200);

    $this->view->height = $height = isset($params['height']) ? $params['height'] : $this->_getParam('height', 200);

    $this->view->information = $information = isset($params['information']) ? $params['information'] : $this->_getParam('information', array('featured', 'sponsored', 'displayname', 'email', 'phone', 'location', 'website', 'facebook', 'linkdin', 'twitter', 'googleplus'));
    $itemCount = isset($params['itemCount']) ? $params['itemCount'] : $this->_getParam('itemCount', 10);

    $this->view->all_params = $values = array('paginationType' => $paginationType, 'width' => $width, 'height' => $height, 'information' => $information, 'itemCount' => $itemCount, 'event_id' => $event_id);

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');
      
    $values['event_id'] = $event_id;
    $values['widgetName'] = 'profileEvents';

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('eventspeakers', 'seseventspeaker')->getSpeakersPaginator($values);
    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();

    // Add count to title if configured
    if ($this->_getParam('titleCount', false) && $paginator->getTotalItemCount() > 0) {
      $this->_childCount = $paginator->getTotalItemCount();
    }
  }

  public function getChildCount() {
    return $this->_childCount;
  }

}
