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

class Seslandingpage_Widget_Design2Widget2Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $leftsideresourcetype = $this->_getParam('leftsideresourcetype', '');
    $leftsidepopularitycriteria = $this->_getParam('leftsidepopularitycriteria', 'creation_date');    
    if(!$leftsideresourcetype)
      return $this->setNoRender();
      
    //Left Side Block
    $this->getElement()->removeDecorator('Title');
    $this->view->leftsideheading = $this->_getParam('leftsideheading', "Popular Posts - Heads up bloggers!");
    $this->view->leftsidedescription = $this->_getParam('leftsidedescription', "Resse alias in rerum minima quod quos accusantium officiis pariatur. Rerum quisquam blanditiis,");
    
    $this->view->leftsidereadmoretext = $this->_getParam('leftsidereadmoretext', "View More");
    $this->view->leftsidereadmoreurl = $this->_getParam('leftsidereadmoreurl', null);
    $this->view->leftsidefonticon = $this->_getParam('leftsidefonticon', null);

    $limit = $this->_getParam('limit', 4);
    $this->view->leftsideresults = $leftsideresults = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $leftsidepopularitycriteria, 'resourcetype' => $leftsideresourcetype));
    if(count($leftsideresults) == 0)
      return $this->setNoRender();


    //Right Side Block
    $rightsideresourcetype = $this->_getParam('rightsideresourcetype', '');
    if(!$rightsideresourcetype)
      return $this->setNoRender();
      
    $this->view->rightsideheading = $this->_getParam('rightsideheading', "Popular Posts - Heads up bloggers!");
    $this->view->rightsidedescription = $this->_getParam('rightsidedescription', "Resse alias in rerum minima quod quos accusantium officiis pariatur. Rerum quisquam blanditiis,");
    $this->view->rightsidereadmoretext = $this->_getParam('rightsidereadmoretext', "View More");
    $this->view->rightsidereadmoreurl = $this->_getParam('rightsidereadmoreurl', null);
    $this->view->rightsidefonticon = $this->_getParam('rightsidefonticon', null);
    $rightsidepopularitycriteria = $this->_getParam('rightsidepopularitycriteria', 'creation_date');

    $limit = $this->_getParam('limit', 4);
    $this->view->rightsideresults = $rightsideresults = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $limit, 'popularitycriteria' => $rightsidepopularitycriteria, 'resourcetype' => $rightsideresourcetype));
    if(count($rightsideresults) == 0)
      return $this->setNoRender();
	}
}