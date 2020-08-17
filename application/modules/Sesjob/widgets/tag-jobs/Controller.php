<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesjob_Widget_tagJobsController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->tagCloudData  = Engine_Api::_()->sesjob()->tagCloudItemCore('fetchAll');
    if( count($this->view->tagCloudData) <= 0 )
    return $this->setNoRender();
  }
}
