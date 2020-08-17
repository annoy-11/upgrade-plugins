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
 
class Sesgroup_Widget_GroupViewController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewerId = $viewer->getIdentity();
    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('group_id', null);
    $group_id = Engine_Api::_()->getDbTable('groups', 'sesgroup')->getGroupId($id);
    if (!Engine_Api::_()->core()->hasSubject())
      $this->view->group = $group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    else
      $this->view->group = $group = Engine_Api::_()->core()->getSubject();

    $sesprofilelock_enable_module = (array) Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprofilelock.enable.modules');
    if (Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesprofilelock')) && in_array('sesgroup', $sesprofilelock_enable_module) && $viewerId != $group->owner_id) {
      $cookieData = '';
      if ($group->enable_lock && !in_array($group->group_id, explode(',', $cookieData))) {
        $this->view->locked = true;
      } else {
        $this->view->locked = false;
      }
      $this->view->password = $group->group_password;
    } else
      $this->view->password = true;


    $this->view->params = $params = Engine_Api::_()->sesgroup()->getWidgetParams($this->view->identity);
    $show_criterias = $params['show_criteria'];
    foreach ($show_criterias as $show_criteria)
      $this->view->{$show_criteria . 'Active'} = $show_criteria;

    // Get category
    if (!empty($group->category_id))
      $this->view->category = Engine_Api::_()->getDbTable('categories', 'sesgroup')->find($group->category_id)->current();
    $this->view->groupTags = $group->tags()->getTagMaps();
    $this->view->canComment = $group->authorization()->isAllowed($viewer, 'comment');
  }

}
