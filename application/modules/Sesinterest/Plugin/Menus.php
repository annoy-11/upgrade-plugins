<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesinterest
 * @package    Sesinterest
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2019-03-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesinterest_Plugin_Menus {

  public function interest() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    if (!$viewer->getIdentity())
      return false;

    return array(
        'label' => $view->translate('Choose Interests'),
        //'class' => 'smoothbox',
        'route' => 'default',
        'params' => array(
            'module' => 'sesinterest',
            'controller' => 'index',
            'action' => 'interests',
            'user_id' => $viewer->getIdentity(),
            //'format' => 'smoothbox',
        ),
    );
  }

//   public function gotoAvatars() {
//
//     $viewer = Engine_Api::_()->user()->getViewer();
//     $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
//     if (!$viewer->getIdentity())
//       return false;
//
//     return array(
//         'label' => $view->translate('Choose Avatar'),
//         'route' => 'default',
//         'params' => array(
//             'module' => 'sesinterest',
//             'controller' => 'index',
//             'action' => 'avatars',
//             'user_id' => $viewer->getIdentity(),
//         ),
//     );
//   }
}
