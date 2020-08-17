<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Edocument
 * @package    Edocument
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Edocument_Widget_DocumentCategoryIconsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '200');
    $this->view->width = $this->_getParam('width', '200');
    $this->view->alignContent = $this->_getParam('alignContent', 'center');
    $this->view->titleC = $this->_getParam('titleC','What are you in the mood for?');

    $params['criteria'] = $this->_getParam('criteria', '');

    $show_criterias = $this->_getParam('show_criteria', array('title', 'countDocuments', 'icon'));

    if (in_array('countDocuments', $show_criterias) || $params['criteria'] == 'most_document')
      $params['countDocuments'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;

    $params['limit'] = $this->_getParam('limit_data',10);

    $this->view->paginator = Engine_Api::_()->getDbTable('categories', 'edocument')->getCategory($params);

    if (count($this->view->paginator) == 0)
      return;
  }
}
