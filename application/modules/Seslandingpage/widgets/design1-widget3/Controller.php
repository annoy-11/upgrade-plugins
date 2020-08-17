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

class Seslandingpage_Widget_Design1Widget3Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->resourcetype = $resourcetype = $this->_getParam('resourcetype', '');
    if(!$resourcetype)
      return $this->setNoRender();
  
    $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('title', "Popular Posts - Heads up bloggers!");
    $this->view->description = $this->_getParam('description', "Resse alias in rerum minima quod quos accusantium officiis pariatur. Rerum quisquam blanditiis,");
    $this->view->showstats = $this->_getParam('showstats', '');
    $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');
    
    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 3);
    $this->view->descriptiontruncation = $this->_getParam('descriptiontruncation', 100);
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');
    
    //Block 1
    $this->view->block1title = $this->_getParam('block1title', '');
    $this->view->block1url = $this->_getParam('block1url', '');
    $this->view->block1bgimage = $this->_getParam('block1bgimage', '');
    
    //Block 2
    $this->view->block2title = $this->_getParam('block2title', '');
    $this->view->block2url = $this->_getParam('block2url', '');
    $this->view->block2bgimage = $this->_getParam('block2bgimage', '');

    //Block 3
    $this->view->block3title = $this->_getParam('block3title', '');
    $this->view->block3url = $this->_getParam('block3url', '');
    $this->view->block3bgimage = $this->_getParam('block3bgimage', '');

      
    $limit = $this->_getParam('limit', 4);
    $this->view->results = $result = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $popularitycriteria, 'resourcetype' => $resourcetype));
    if(count($result) == 0)
      return $this->setNoRender();	
	}
}