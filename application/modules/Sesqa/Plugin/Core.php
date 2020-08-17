<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Plugin_Core
{
  public function onStatistics($event)
  {
    /*$table  = Engine_Api::_()->getDbTable('photos', 'sesalbum');
    $select = new Zend_Db_Select($table->getAdapter());
    $select->from($table->info('name'), 'COUNT(photo_id) AS count');
		$select->where('album_id !=?','0');
    $event->addResponse($select->query()->fetchColumn(), 'photo');*/
  }
	public function onRenderLayoutMobileDefault($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutMobileDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefaultSimple($event) {
    return $this->onRenderLayoutDefault($event,'simple');
  }
	public function onRenderLayoutDefault($event,$mode=null){
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$viewer = Engine_Api::_()->user()->getViewer();		
		$request = Zend_Controller_Front::getInstance()->getRequest();
		$moduleName = $request->getModuleName();
		$actionName = $request->getActionName();
		$controllerName = $request->getControllerName();
		
		
			$headScript = new Zend_View_Helper_HeadScript();
			$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
								 .'application/modules/Sesqa/externals/scripts/core.js');

	}
   public function onUserDeleteBefore($event)
  {
    $payload = $event->getPayload();
    if ($payload instanceof User_Model_User) {
      $user_id = $payload->getIdentity();
    }
  }
  public function onUserDeleteAfter($event)
  {
    /*$payload = $event->getPayload();
    $user_id = $payload['identity'];
    $table   = Engine_Api::_()->getDbTable('albums', 'sesalbum');
    $select = $table->select()->where('owner_id = ?', $user_id);
    $select = $select->where('owner_type = ?', 'user');
    $rows = $table->fetchAll($select);
    foreach ($rows as $row)
    {
      $row->delete();
    }
    $table   = Engine_Api::_()->getDbTable('photos', 'sesalbum');
    $select = $table->select()->where('owner_id = ?', $user_id);
    $select = $select->where('owner_type = ?', 'user');
    $rows = $table->fetchAll($select);
    foreach ($rows as $row)
    {
      $row->delete();
    }*/
  }
}
