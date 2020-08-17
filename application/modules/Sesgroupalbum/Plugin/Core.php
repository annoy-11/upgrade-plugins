<?php

class Sesgroupalbum_Plugin_Core {

	public function onRenderLayoutDefaultSimple($event) {
	return $this->onRenderLayoutDefault($event,'simple');
	}

	public function onRenderLayoutDefault($event,$mode=null){

		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

		if(empty($_SERVER['HTTP_REFERER'])){
			$_COOKIE['sesgroupalbum_lightbox_value']	= '';
		}

		$headScript = new Zend_View_Helper_HeadScript();
		
		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') .'application/modules/Sesgroupalbum/externals/scripts/core.js');

		$headScript->appendFile(Zend_Registry::get('StaticBaseUrl')
		. 'application/modules/Sesgroupalbum/externals/scripts/sesimagevieweradvance/photoswipe.min.js')
		->appendFile(Zend_Registry::get('StaticBaseUrl')
		. 'application/modules/Sesgroupalbum/externals/scripts/sesimagevieweradvance/photoswipe-ui-default.min.js')
		->appendFile(Zend_Registry::get('StaticBaseUrl')
		. 'application/modules/Sesgroupalbum/externals/scripts/sesgroupalbumimagevieweradvance.js');
		$view->headLink()->appendStylesheet($view->layout()->staticBaseUrl
		. 'application/modules/Sesbasic/externals/styles/photoswipe.css');

		$script = '';
		$script .=
		"var openPhotoInLightBoxSesgroupalbum = '1';
		var openGroupPhotoInLightBoxSesgroupalbum = '0';
		var openEventPhotoInLightBoxSesgroupalbum = '0';
		";
		$view->headScript()->appendScript($script);
	}
	
	//   public function onGroupCreateAfter($event)
	//   {
	//   	$payload = $event->getPayload();
	// 	  $group_id = $payload['group_id'];
	// 	  if($_FILES['photo']['name']) {
	// 		  $group_item = Engine_Api::_()->getItem('group', $group_id);
	// 		  print_r($group_item->toarray());die;
	// 		  //$db->update('engine4_group_albums', array('title' => $group_item->title, 'description' => $group_item->description, 'owner_id' => $group_item->user_id), array(" = ?" => $id));
	// 	  
	// 	  }
	//   }

	public function onUserDeleteAfter($event) {
	
		$payload = $event->getPayload();
		$user_id = $payload['identity'];
		$table   = Engine_Api::_()->getDbTable('albums', 'sesgroupalbum');
		$select = $table->select()->where('owner_id = ?', $user_id);
		$select = $select->where('owner_type = ?', 'user');
		$rows = $table->fetchAll($select);
		foreach ($rows as $row) {
			$row->delete();
		}
		
		$table   = Engine_Api::_()->getDbTable('photos', 'sesgroupalbum');
		$select = $table->select()->where('user_id = ?', $user_id);
		$select = $select->where('owner_type = ?', 'user');
		$rows = $table->fetchAll($select);
		foreach ($rows as $row) {
			$row->delete();
		}
	}
}
