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
class Sesshortcut_Widget_ShortcutButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    if (empty($this->view->viewer_id))
      return $this->setNoRender();

    $moduleName = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
    $moduleEnabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled($moduleName);
    if (empty($moduleEnabled) || empty($moduleName))
      return $this->setNoRender();
    
    if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesshortcut.enableshortcut', 1))
	    return $this->setNoRender();
      
    $this->view->item = $item = Engine_Api::_()->core()->getSubject(); 
    $this->view->type = $item->getType();
    $this->view->id = $item->getIdentity();

    $this->view->isShortcut = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->isShortcut(array('resource_type' => $this->view->type, 'resource_id' => $this->view->id));

    $select = Engine_Api::_()->getDbTable('shortcuts', 'sesshortcut')->getShortcutSelect($item);
    $results = $select->query()->fetchAll();
    $this->view->saveCount = count($results);
  }

}