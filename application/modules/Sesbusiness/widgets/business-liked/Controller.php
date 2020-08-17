<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Widget_BusinessLikedController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject(''))
      $business = Engine_Api::_()->core()->getSubject();
    else
      return $this->setNoRender();
     $viewer = $this->view->viewer();
    $this->view->title = $this->_getParam('title');
    $table = Engine_Api::_()->getDbTable('likebusinesses','sesbusiness');
    $selelct = $table->select()->where('business_id =?',$business->getIdentity());
    $this->view->result = $result = $table->fetchAll($selelct);
    if(!count($result))
    return $this->setNoRender();
  }

}
