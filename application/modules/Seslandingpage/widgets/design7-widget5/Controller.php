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

class Seslandingpage_Widget_Design7Widget5Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    //First Block
    $firstblockresourcetype = $this->_getParam('firstblockresourcetype', '');
    if(!$firstblockresourcetype)
      return $this->setNoRender();
  
    //$this->getElement()->removeDecorator('Title');
    $this->view->backgroundimage = $this->_getParam('backgroundimage', '');

    $this->view->firstblockheading = $this->_getParam('firstblockheading', null);
    $firstblockpopularitycriteria = $this->_getParam('firstblockpopularitycriteria', 'creation_date');
    $this->view->descriptiontruncation = $this->_getParam('descriptiontruncation', 100);
    $this->view->firstblockshowstats = $this->_getParam('firstblockshowstats', array());
    $this->view->firstblockfonticon = $this->_getParam('firstblockfonticon', '');
    $firstblocklimit = $this->_getParam('firstblocklimit', 4);
    
    $this->view->firstblockresults = $firstblockresult = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $firstblocklimit, 'popularitycriteria' => $firstblockpopularitycriteria, 'resourcetype' => $firstblockresourcetype));
    if(count($firstblockresult) == 0)
      return $this->setNoRender();
      
      
    //Second Block
    $secondblockresourcetype = $this->_getParam('secondblockresourcetype', '');
    if(!$secondblockresourcetype)
      return $this->setNoRender();
    $this->view->secondblockheading = $this->_getParam('secondblockheading', null);
    $secondblockpopularitycriteria = $this->_getParam('secondblockpopularitycriteria', 'creation_date');
    $this->view->descriptiontruncation = $this->_getParam('descriptiontruncation', 100);
    $this->view->secondblockshowstats = $this->_getParam('secondblockshowstats', array());
    $this->view->secondblockfonticon = $this->_getParam('secondblockfonticon', '');
    $secondblocklimit = $this->_getParam('secondblocklimit', 4);
    
    $this->view->secondblockresults = $secondblockresult = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $secondblocklimit, 'popularitycriteria' => $secondblockpopularitycriteria, 'resourcetype' => $secondblockresourcetype));
    if(count($secondblockresult) == 0)
      return $this->setNoRender();
      
    //Third Block
    $thirdblockresourcetype = $this->_getParam('thirdblockresourcetype', '');
    if(!$thirdblockresourcetype)
      return $this->setNoRender();
    $this->view->thirdblockheading = $this->_getParam('thirdblockheading', null);
    $thirdblockpopularitycriteria = $this->_getParam('thirdblockpopularitycriteria', 'creation_date');
    $this->view->descriptiontruncation = $this->_getParam('descriptiontruncation', 100);
    $this->view->thirdblockshowstats = $this->_getParam('thirdblockshowstats', array());
    $this->view->thirdblockfonticon = $this->_getParam('thirdblockfonticon', '');
    $thirdblocklimit = $this->_getParam('thirdblocklimit', 4);
    $this->view->thirdblockresults = $thirdblockresult = Engine_Api::_()->seslandingpage()->getContents(array('limit' => $thirdblocklimit, 'popularitycriteria' => $thirdblockpopularitycriteria, 'resourcetype' => $thirdblockresourcetype));
    if(count($thirdblockresult) == 0)
      return $this->setNoRender();
	
	}
}