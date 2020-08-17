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

class Estore_Widget_StoreLikedController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject(''))
      $store = Engine_Api::_()->core()->getSubject();
    else
      return $this->setNoRender();
     $viewer = $this->view->viewer();
    $this->view->title = $this->_getParam('title');
    $table = Engine_Api::_()->getDbTable('likestores','estore');
    $selelct = $table->select()->where('store_id =?',$store->getIdentity());
    $this->view->result = $result = $table->fetchAll($selelct);
    if(!count($result))
    return $this->setNoRender();
  }

}
