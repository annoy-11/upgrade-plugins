<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seslandingpage_Widget_Design1Widget5Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->resourcetype = $resourcetype = $this->_getParam('resourcetype', '');
    if(!$resourcetype)
      return $this->setNoRender();
      
    $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
    $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('title', "Popular Posts - Heads up bloggers!");
    $this->view->description = $this->_getParam('description', "Resse alias in rerum minima quod quos accusantium officiis pariatur. Rerum quisquam blanditiis,");
    $this->view->showstats = $this->_getParam('showstats', '');
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    $seslandingpage_widget = Zend_Registry::isRegistered('seslandingpage_widget') ? Zend_Registry::get('seslandingpage_widget') : null;
    if(empty($seslandingpage_widget))
      return $this->setNoRender();
    $limit = $this->_getParam('limit', 3);
    $this->view->results = $result = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $popularitycriteria, 'resourcetype' => $resourcetype));
    if(count($result) == 0)
      return $this->setNoRender();
	}
}
