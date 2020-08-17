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

class Edocument_Widget_DocumentCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', '150px');
    $this->view->width = $this->_getParam('width', '292px');

    $params['criteria'] = $this->_getParam('criteria', '');
    $params['limit'] = $this->_getParam('limit', 0);
    $params['document_required'] = $this->_getParam('document_required',0);

    $this->view->show_criterias = $show_criterias = $this->_getParam('show_criteria', array('title', 'countDocuments', 'icon'));
    if (in_array('countDocuments', $show_criterias))
      $params['countDocuments'] = true;

    if($params['document_required'])
        $params['documentRequired'] = true;

    foreach ($show_criterias as $show_criteria)
      $this->view->$show_criteria = $show_criteria;

    $this->view->paginator = Engine_Api::_()->getDbTable('categories', 'edocument')->getCategory($params);
    if (count($this->view->paginator) == 0)
      return;
  }
}
