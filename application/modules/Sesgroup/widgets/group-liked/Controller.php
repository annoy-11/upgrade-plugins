<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Widget_GroupLikedController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    if (!Engine_Api::_()->core()->hasSubject(''))
      $group = Engine_Api::_()->core()->getSubject();  
    else
      return $this->setNoRender();
     $viewer = $this->view->viewer();
    $this->view->title = $this->_getParam('title');
    $table = Engine_Api::_()->getDbTable('likegroups','sesgroup');
    $selelct = $table->select()->where('group_id =?',$group->getIdentity());
    $this->view->result = $result = $table->fetchAll($selelct);
    if(!count($result))
    return $this->setNoRender();
  }

}
