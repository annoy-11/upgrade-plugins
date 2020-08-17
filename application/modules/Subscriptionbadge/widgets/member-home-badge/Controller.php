<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Subscriptionbadge
 * @package    Subscriptionbadge
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Subscriptionbadge_Widget_MemberHomeBadgeController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    // Don't render this if not authorized
    $subject = Engine_Api::_()->user()->getViewer();

    $level_id = $subject->level_id;

    $this->view->level = $level = Engine_Api::_()->getItem('authorization_level', $level_id);
    if(in_array($level->type, array('public', 'moderator', 'admin'))) {
        return $this->setNoRender();
    }
    $this->view->showbadge = $this->_getParam('showbadge', 1);
    $this->view->showlevel = $this->_getParam('showlevel', 1);
    $this->view->badge_photo = $badge_photo = Engine_Api::_()->authorization()->getPermission($subject,'subsctionbadge', 'userbadge');


    $this->view->showupgrade = Engine_Api::_()->authorization()->getPermission($subject,'subsctionbadge', 'showupgrade');


    // Get packages
    $packagesTable = Engine_Api::_()->getDbtable('packages', 'payment');
    $this->view->packages = $packages = $packagesTable->fetchAll(array('enabled = ?' => 1, 'after_signup = ?' => 1));

    // Get current subscription and package
    $subscriptionsTable = Engine_Api::_()->getDbtable('subscriptions', 'payment');
    $this->view->currentSubscription = $currentSubscription = $subscriptionsTable->fetchRow(array(
      'user_id = ?' => $subject->getIdentity(),
      'active = ?' => true,
    ));


    // Get current package
    if( $currentSubscription ) {
      $this->view->currentPackage = $currentPackage = $packagesTable->fetchRow(array(
        'package_id = ?' => $currentSubscription->package_id,
      ));

    }
  }
}
