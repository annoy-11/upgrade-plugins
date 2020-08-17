<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesevent
 * @package    Sesevent
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesdocument_Widget_EventCoverController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$params = $request->getParams();
		$this->view->actionA = $params['action'];
    // Don't render this if not authorized
    $viewer = Engine_Api::_()->user()->getViewer();
    if (!Engine_Api::_()->core()->hasSubject('sesdocument')) {
      return $this->setNoRender();
    }
		$this->view->show_criterias = $this->_getParam('showCriterias',array('mainPhoto','title','createdby','createdon'));
		$this->view->show_calander = $this->_getParam('showCalander',array('google','yahoo','msn','outlook','ical'));
		$this->view->tab = $this->_getParam('optionInsideOutside',1);
		$this->view->height = $this->_getParam('height','500');
		$this->view->fullwidth = $this->_getParam('fullwidth','1');
		if($this->view->fullwidth){
			$this->view->padding = $this->_getParam('padding','');
		}else
			$this->view->padding = '';
    // Get subject and check auth
    

    $this->view->socialshare_enable_plusicon = $this->_getParam('socialshare_enable_plusicon', 1);
    $this->view->socialshare_icon_limit = $this->_getParam('socialshare_icon_limit', 2);
    
		$this->view->photo = $this->_getParam('photo','mPhoto');
    $subject = $this->view->subject = Engine_Api::_()->core()->getSubject('sesdocument');
		$this->view->can_edit = $editOverview = $subject->authorization()->isAllowed($viewer, 'edit');		
	
	
		$currentTime = time();
		
  }
}