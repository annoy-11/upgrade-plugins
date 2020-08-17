<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesqa
 * @package    Sesqa
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesqa_Widget_BannerSearchController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->widgetParams = $widgetParams = $this->_getAllParams();
    $this->view->locationEnable = $this->_getParam('locationEnable','0');
    $criteria = $this->_getParam('qacriteria','creation_date');
    $limit = $this->_getParam('limit',5);
    if($limit > 0) {
        $this->view->questions = Engine_Api::_()->getDbTable('questions', 'sesqa')->getQuestions(array('limit' => $limit, 'popularCol' => $criteria, 'fetchAll' => 1, 'locationEnable' => $this->_getParam('locationEnable', '0')));
    }
  }
}
