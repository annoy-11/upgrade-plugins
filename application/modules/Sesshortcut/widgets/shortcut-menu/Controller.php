<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2018-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesshortcut_Widget_ShortcutMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $this->view->title = $this->_getParam('title', "Shortcuts");
    
    $this->getElement()->removeDecorator('Title');
    
    $this->view->shortCount = $this->_getParam('limitdata', 2);
    
    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($this->view->viewer_id))
      return $this->setNoRender();
      
    $this->view->enablepintotop = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enablepintotop', 1);
      
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
	    return $this->setNoRender();

    $this->view->results = $results = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->getShortcuts($this->view->viewer_id);
    if(count($results) == 0) {
      return $this->setNoRender();
    }
  }
}