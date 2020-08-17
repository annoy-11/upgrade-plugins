<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_photoViewBusinessController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

		if(isset($_POST['params'])){
			$params = json_decode($_POST['params'],true);
		}

		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;

		if(Engine_Api::_()->core()->hasSubject('sesbusiness_photo') && !$is_ajax)
      $photo = Engine_Api::_()->core()->getSubject('sesbusiness_photo');
		else if(isset($_POST['photo_id'])) {
      $photo = Engine_Api::_()->getItem('sesbusiness_photo',$_POST['photo_id']);
      Engine_Api::_()->core()->setSubject($photo);
      $photo = Engine_Api::_()->core()->getSubject();
		} else
      return $this->setNoRender();

		$this->view->business =	$business = Engine_Api::_()->getItem('businesses', $photo->business_id);
		$this->view->maxHeight = isset($_POST['maxHeight']) ? $_POST['maxHeight'] : $this->_getParam('maxHeight',900);

		$this->view->criteria = $this->_getParam('criteria','1');
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		$this->view->photo = $photo ;
		$this->view->album = $album = $photo->getAlbum();
	  if($viewer->getIdentity() > 0) {

      $editBusinessRolePermission = Engine_Api::_()->sesbusiness()->getBusinessRolePermission($business->getIdentity(),'allow_plugin_content','edit');

      $deleteBusinessRolePermission = Engine_Api::_()->sesbusiness()->getBusinessRolePermission($business->getIdentity(),'allow_plugin_content','delete');

      $this->view->canEdit = $canEdit = $editBusinessRolePermission ? $editBusinessRolePermission : $business->authorization()->isAllowed($viewer, 'edit');
      $this->view->canComment = $canComment = $business->authorization()->isAllowed($viewer, 'comment');
      $this->view->canDelete = $canDelete = $deleteBusinessRolePermission ? $deleteBusinessRolePermission : $business->authorization()->isAllowed($viewer, 'delete');
      $this->view->canTag = $canTag = $business->authorization()->isAllowed($viewer, 'tag');
      $this->view->canCommentMemberLevelPermission = Engine_Api::_()->authorization()->getPermission($viewer, 'businesses', 'comment');
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
