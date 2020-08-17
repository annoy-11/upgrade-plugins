<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessvideo_Widget_ShowSameTagsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('businessvideo')) {
      return $this->setNoRender();
    }

		if(Engine_Api::_()->core()->hasSubject('businessvideo'))
   	 $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('businessvideo');

    // Set default title
    if (!$this->getElement()->getTitle()) {
      $this->getElement()->setTitle('Similar '.ucwords(str_replace('sesbusinessvideo_','',$subject->getType())));
    }

    // Get tags for this video
    $itemTable = Engine_Api::_()->getItemTable($subject->getType());
    $tagMapsTable = Engine_Api::_()->getDbtable('tagMaps', 'core');
    $tagsTable = Engine_Api::_()->getDbtable('tags', 'core');

    // Get tags
    $tags = $tagMapsTable->select()
            ->from($tagMapsTable, 'tag_id')
            ->where('resource_type = ?', $subject->getType())
            ->where('resource_id = ?', $subject->getIdentity())
            ->query()
            ->fetchAll(Zend_Db::FETCH_COLUMN);

    // No tags
    if (empty($tags)) {
      return $this->setNoRender();
    }
		$value['limit'] = $this->_getParam('limit_data', 5);
    $tableName = $this->_getParam('tableName', 'video');
		$this->view->view_type = $this->_getParam('type','list');
		$this->view->viewTypeStyle = $this->_getParam('viewTypeStyle', 'mouseover');
		$this->view->viewTypeStyle = $viewTypeStyle = (isset($_POST['viewTypeStyle']) ? $_POST['viewTypeStyle'] : (isset($params['viewTypeStyle']) ? $params['viewTypeStyle'] : $this->_getParam('viewTypeStyle','fixed')));
    $this->view->{"height_".$this->view->view_type} = $this->_getParam('height', '60');
    $this->view->{"width_".$this->view->view_type} = $this->_getParam('width', '80');
    // Get likes
     $show_criterias = $this->_getParam('show_criteria', array('like', 'comment', 'rating', 'by', 'title', 'view','favourite','category','duration','watchLater'));
		if(is_array($show_criterias)){
			foreach($show_criterias as $show_criteria)
				$this->view->{$show_criteria . 'Active'} = $show_criteria;
		}
      $this->view->{"title_truncation_".$this->view->view_type} = $this->_getParam('title_truncation', '45');

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('videos', 'sesbusinessvideo')->getVideo(array('sameTagresource_id'=>$subject->getIdentity(),'sameTagTag_id'=>$tags,'sameTag'=>'sameTag'));

    // Get paginator
    $this->view->paginator = $paginator ;

    // Set item count per page and current page number
    $paginator->setItemCountPerPage($value['limit']);
    $paginator->setCurrentPageNumber(1);

    // Hide if nothing to show
    if ($paginator->getTotalItemCount() <= 0) {
      return $this->setNoRender();
    }
  }
}
