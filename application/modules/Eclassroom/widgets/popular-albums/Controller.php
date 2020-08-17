<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Eclassroom
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: Controller.php 2019-08-28 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */

class Eclassroom_Widget_PopularAlbumsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams  = $allParams = $this->_getAllParams();
    $value['order'] = $allParams['info'];
    $value['limit_data'] = $allParams['limit_data'];
    $value['widget'] = 1;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'eclassroom')->getAlbumSelect($value);
		$this->view->viewer  = Engine_Api::_()->user()->getViewer();
    if (count($paginator) <= 0)
      return $this->setNoRender();
	}
}
