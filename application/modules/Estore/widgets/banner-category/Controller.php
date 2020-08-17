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
class Estore_Widget_BannerCategoryController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->params = $params = Engine_Api::_()->estore()->getWidgetParams($this->view->identity);
    $value = array();
    $value['order'] = $params['order'];
    $value['info'] = $params['info'];

      $this->view->paginator =$paginator=  Engine_Api::_()->getDbTable('stores', 'estore')
              ->getStoreSelect(array_merge($value, array('search' => 1, 'fetchAll' => true, 'limit' => 3)));

  }

}
