<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesteam
 * @package    Sesteam
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-02-20 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesteam_Widget_BrowseTeamController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    if(isset($_POST['params'])){
        $params = json_decode($_POST['params'],true);
    }
    if(isset($_POST['searchParams']) && $_POST['searchParams'])
        parse_str($_POST['searchParams'], $searchArray);
    $this->view->is_ajax = $params['is_ajax'] = isset($_POST['is_ajax']) ? true : false;

    $this->view->viewmore = $this->_getParam('viewmore', 0);

    if ($this->view->viewmore)
      $this->getElement()->removeDecorator('Container');

    $this->view->teampage_title = $this->_getParam('title', 'Meet Team');
    $this->view->teampage_description = $this->_getParam('sesteam_teampage_description', '');

    $this->view->height = $params['height'] = isset($params['height']) ? $params['height'] : $this->_getParam('height', '200');
    $this->view->width = $params['width'] = isset($params['width']) ? $params['width'] : $this->_getParam('width', '200');

    $this->view->center_block = $params['center_block'] = isset($params['center_block']) ? $params['center_block'] : $this->_getParam('center_block', '1');

    $this->view->center_heading = $params['center_heading'] = isset($params['center_heading']) ? $params['center_heading'] : $this->_getParam('center_heading', '1');

    $this->view->center_description = $params['center_description'] = isset($params['center_description']) ? $params['center_description'] : $this->_getParam('center_description', '1');

    $this->view->viewMoreText = $params['viewMoreText'] = isset($params['viewMoreText']) ? $params['viewMoreText'] : $this->_getParam('viewMoreText', 'more');


    $this->view->template_settings = $params['template_settings'] = isset($params['template_settings']) ? $params['template_settings'] : $this->_getParam('sesteam_template', '1');

    $this->view->sesteam_social_border = $params['sesteam_social_border'] = isset($params['sesteam_social_border']) ? $params['sesteam_social_border'] : $this->_getParam('sesteam_social_border', '1');

    $this->view->content_show = $params['content_show'] = isset($params['content_show']) ? $params['content_show'] : $this->_getParam('sesteam_contentshow', array('displayname', 'designation', 'description', 'email', 'phone', 'website', 'location', 'facebook', 'linkdin', 'twitter', 'googleplus'));

    $params['limit'] = $itemCount = $params['limit'] = isset($params['limit']) ? $params['limit'] : $this->_getParam('limit', '1');

    $this->view->paginationType = $params['paginationType'] = $itemCount = $params['paginationType'] = isset($params['paginationType']) ? $params['paginationType'] : $this->_getParam('paginationType', '1');

    $this->view->params = $params;

    if (!empty($_GET['sesteam_title']))
      $this->view->sesteam_title = $_GET['sesteam_title'];
    if (!empty($_GET['designation_id']))
      $this->view->designation_id = $_GET['designation_id'];

    $this->view->type = $params['type'] = isset($_GET['sesteam_type']) ? $_GET['sesteam_type'] : $this->_getParam('sesteam_type', 'teammember');

    $params['title'] = isset($searchArray['sesteam_title']) ? $searchArray['sesteam_title'] :  (isset($_GET['sesteam_title']) ? $_GET['sesteam_title'] : '') ;

    $params['designation_id'] = isset($searchArray['designation_id']) ? $searchArray['designation_id'] :  (isset($_GET['designation_id']) ? $_GET['designation_id'] : $this->_getParam('designation_id', 0)) ;

    $params['widgetname'] = 'browse';

    $this->view->paginator = $paginator = Engine_Api::_()->sesteam()->getTeamPaginator($params);
    $paginator->setItemCountPerPage($itemCount);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));
    $this->view->count = $paginator->getTotalItemCount();
  }

}
