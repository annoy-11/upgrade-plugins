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

class Estore_Widget_tagStoresController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->tagCloudData  = Engine_Api::_()->estore()->tagCloudItemCore('fetchAll');
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
