<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Eblog_Widget_ClaimRequestsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $viewer = Engine_Api::_()->user()->getViewer();
    if(!$viewer->getIdentity())
    return $this->setNoRender();

		$page = isset($_POST['page']) ? $_POST['page'] : 1;
		$paginator = Engine_Api::_()->getDbtable('claims', 'eblog')->getblogclaimsPaginator();
		$this->view->paginator = $paginator;
		// Set item count per page and current page number
		$paginator->setItemCountPerPage(10);
		$paginator->setCurrentPageNumber($page);
  }

}
