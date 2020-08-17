<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seslisting_Widget_photoViewPageController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
		if(isset($_POST['params'])){
			$params = json_decode($_POST['params'],true);
		}
		$this->view->is_ajax = $is_ajax = isset($_POST['is_ajax']) ? true : false;
		if(Engine_Api::_()->core()->hasSubject('seslisting_photo') && !$is_ajax)
	 	 $photo = Engine_Api::_()->core()->getSubject('seslisting_photo');
		else if(isset($_POST['photo_id'])){
		 $photo = Engine_Api::_()->getItem('seslisting_photo',$_POST['photo_id']);
		 Engine_Api::_()->core()->setSubject($photo);
		 $photo = Engine_Api::_()->core()->getSubject();
		}else
			 return $this->setNoRender();

		$this->view->listing =	$listing = Engine_Api::_()->getItem('seslisting', $photo->listing_id);
		$this->view->maxHeight = isset($_POST['maxHeight']) ? $_POST['maxHeight'] : $this->_getParam('maxHeight',900);

		$this->view->criteria = $this->_getParam('criteria','1');
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		$this->view->photo = $photo ;
		$this->view->album = $album = $photo->getAlbum();
	  if($viewer->getIdentity()>0){
			$this->view->canEdit = $canEdit = $listing->authorization()->isAllowed($viewer, 'edit');
			$this->view->canComment = $canComment = $listing->authorization()->isAllowed($viewer, 'comment');
			$this->view->canDelete = $canDelete = $listing->authorization()->isAllowed($viewer, 'delete');
			$this->view->canTag = $canTag = $listing->authorization()->isAllowed($viewer, 'tag');
			$this->view->canCommentMemberLevelPermission = Engine_Api::_()->authorization()->getPermission($viewer, 'seslisting', 'comment');
		}
// 		$sesevent_eventalbumphotos = Zend_Registry::isRegistered('sesevent_eventalbumphotos') ? Zend_Registry::get('sesevent_eventalbumphotos') : null;
// 		if(empty($sesevent_eventalbumphotos)) {
// 			return $this->setNoRender();
// 		}
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
		if($is_ajax){
			$this->getElement()->removeDecorator('Container');
		}else{
			$getmodule = Engine_Api::_()->getDbTable('modules', 'core')->getModule('core');
			if (!empty($getmodule->version) && version_compare($getmodule->version, '4.8.8') >= 0){
				$this->view->doctype('XHTML1_RDFA');
				$this->view->docActive = true;
			}
		}

	}
}
