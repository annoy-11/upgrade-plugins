<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Widget_photoViewPageController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

		if(isset($_POST['params'])){
			$params = json_decode($_POST['params'],true);
		}

		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;

		if(Engine_Api::_()->core()->hasSubject('estore_photo') && !$is_ajax)
      $photo = Engine_Api::_()->core()->getSubject('estore_photo');
		else if(isset($_POST['photo_id'])) {
      $photo = Engine_Api::_()->getItem('estore_photo',$_POST['photo_id']);
      Engine_Api::_()->core()->setSubject($photo);
      $photo = Engine_Api::_()->core()->getSubject();
		} else
      return $this->setNoRender();

		$this->view->store =	$store = Engine_Api::_()->getItem('stores', $photo->store_id);
		$this->view->maxHeight = isset($_POST['maxHeight']) ? $_POST['maxHeight'] : $this->_getParam('maxHeight',900);

		$this->view->criteria = $this->_getParam('criteria','1');
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		$this->view->photo = $photo ;
		$this->view->album = $album = $photo->getAlbum();
	  if($viewer->getIdentity() > 0) {

      $editStoreRolePermission = Engine_Api::_()->estore()->getStoreRolePermission($store->getIdentity(),'allow_plugin_content','edit');

      $deleteStoreRolePermission = Engine_Api::_()->estore()->getStoreRolePermission($store->getIdentity(),'allow_plugin_content','delete');

      $this->view->canEdit = $canEdit = $editStoreRolePermission ? $editStoreRolePermission : $store->authorization()->isAllowed($viewer, 'edit');
      $this->view->canComment = $canComment = $store->authorization()->isAllowed($viewer, 'comment');
      $this->view->canDelete = $canDelete = $deleteStoreRolePermission ? $deleteStoreRolePermission : $store->authorization()->isAllowed($viewer, 'delete');
      $this->view->canTag = $canTag = $store->authorization()->isAllowed($viewer, 'tag');
      $this->view->canCommentMemberLevelPermission = Engine_Api::_()->authorization()->getPermission($viewer, 'stores', 'comment');
		}

    $this->view->nextPhoto = $photo->getNextPhoto();
    $this->view->previousPhoto = $photo->getPreviousPhoto();
		$this->view->photo_id = $photo->photo_id;

    // Get tags
    $tags = array();
    foreach ($photo->tags()->getTagMaps() as $tagmap) {
      $tags[] = array_merge($tagmap->toArray(), array(
        'id' => $tagmap->getIdentity(),
        'text' => $tagmap->getTitle(),
        'href' => $tagmap->getHref(),
        'guid' => $tagmap->tag_type . '_' . $tagmap->tag_id
      ));
    }

    $this->view->tags = $tags;
		if($is_ajax) {
			$this->getElement()->removeDecorator('Container');
		} else {
			$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
			if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0){
				$this->view->doctype('XHTML1_RDFA');
				$this->view->docActive = true;
			}
		}
	}
}
