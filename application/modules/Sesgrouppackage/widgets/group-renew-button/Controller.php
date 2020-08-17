<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppackage
 * @package    Sesgrouppackage
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgrouppackage_Widget_GroupRenewButtonController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $group_id = $this->_getParam('group_id', false);
    if ((!Engine_Api::_()->core()->hasSubject() && !$group_id ) || !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesgrouppackage')) {
      return $this->setNoRender();
    }
    if ($group_id)
      $group = $this->view->group = Engine_Api::_()->getItem('sesgroup_group', $group_id);
    else
      $group = $this->view->group = Engine_Api::_()->core()->getSubject();

    $this->view->transaction = Engine_Api::_()->getDbTable('transactions', 'sesgrouppackage')->getItemTransaction(array('order_package_id' => $group->orderspackage_id, 'group' => $group));
    $this->view->package = Engine_Api::_()->getItem('sesgrouppackage_package', $group->package_id);
    if (!$this->view->package)
      return $this->setNoRender();
  }

}
