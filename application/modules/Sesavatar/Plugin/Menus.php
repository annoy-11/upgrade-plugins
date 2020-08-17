<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesavatar
 * @package    Sesavatar
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2018-09-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesavatar_Plugin_Menus {

  public function gotoAvatar() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => $view->translate('Choose Avatar'),
        //'class' => 'smoothbox',
        'route' => 'default',
        'params' => array(
            'module' => 'sesavatar',
            'controller' => 'index',
            'action' => 'avatars',
            'user_id' => $viewer->getIdentity(),
            //'format' => 'smoothbox',
        ),
    );
  }

  public function gotoAvatars() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => $view->translate('Choose Avatar'),
        'route' => 'default',
        'params' => array(
            'module' => 'sesavatar',
            'controller' => 'index',
            'action' => 'avatars',
            'user_id' => $viewer->getIdentity(),
        ),
    );
  }
}
