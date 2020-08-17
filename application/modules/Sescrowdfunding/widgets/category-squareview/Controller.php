<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_CategorySquareviewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');
    
    $params['criteria'] = $this->_getParam('criteria', '');
		$params['limit'] = $this->_getParam('limit', 0);
		
		$params['crowdfunding_required'] = $this->_getParam('crowdfunding_required',0);
    $show_criterias = $this->_getParam('show_criteria', array('title', 'countCrowdfundings', 'icon'));
    
    if (in_array('countCrowdfundings', $show_criterias))
      $params['countCrowdfundings'] = true;
      
		if($params['crowdfunding_required'])
			$params['crowdfundingRequired'] = true;
			
		$this->view->show_criterias = $show_criterias;
    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;

    $this->view->paginator = $paginator = Engine_Api::_()->getDbTable('categories', 'sescrowdfunding')->getCategory($params);
    if (count($paginator) == 0)
      return $this->setNoRender();
  }
}