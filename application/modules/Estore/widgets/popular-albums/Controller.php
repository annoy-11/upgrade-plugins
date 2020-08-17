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

class Estore_Widget_PopularAlbumsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->allParams  = $allParams = $this->_getAllParams();
    $value['order'] = $allParams['info'];
    $value['limit_data'] = $allParams['limit_data'];
    $value['widget'] = 1;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('albums', 'estore')->getAlbumSelect($value);
		$this->view->viewer  = Engine_Api::_()->user()->getViewer();
    if (count($paginator) <= 0)
      return $this->setNoRender();
	}
}
