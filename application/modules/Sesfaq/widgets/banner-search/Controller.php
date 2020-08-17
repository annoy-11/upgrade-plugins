<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesfaq_Widget_BannerSearchController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->widgetParams = $widgetParams = $this->_getAllParams();
    if($widgetParams['limit'] > 0)
      $this->view->faqs = Engine_Api::_()->getDbTable('faqs', 'sesfaq')->getFaqSelect(array('limit' => $widgetParams['limit'], 'order' => $widgetParams['faqcriteria'], 'fetchAll' => 1));
  }
}