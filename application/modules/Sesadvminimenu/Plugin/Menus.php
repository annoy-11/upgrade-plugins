<?php

class Sesadvminimenu_Plugin_Menus
{
  // sesadvminimenu_mini
  public function onMenuInitialize_SesadvminimenuMiniAdmin($row)
  {
    if( Engine_Api::_()->user()->getViewer()->isAllowed('admin') ) {
      return array(
        'label' => $row->label,
        'route' => 'admin_default',
        'class' => 'no-dloader',
      );
    }
    return false;
  }

  public function onMenuInitialize_SesadvminimenuMiniProfile($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() ) {
      $photo = '';
      if( Zend_Registry::isRegistered('Zend_View') ) {
        $view = Zend_Registry::get('Zend_View');
        $photo = $view->itemPhoto($viewer, 'thumb.icon');
      }
      return array(
        'label' => $photo . '<span>'. $row->label . '</span>',
        'uri' => $viewer->getHref(),
      );
    }

    return false;
  }

  public function onMenuInitialize_SesadvminimenuMiniSettings($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() ) {
      return array(
        'label' => $row->label,
        'route' => 'user_extended',
        'params' => array(
          'controller' => 'settings',
          'action' => 'general',
        )
      );
    }

    return false;
  }

  public function onMenuInitialize_SesadvminimenuMiniAuth($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( $viewer->getIdentity() ) {
      return array(
        'label' => 'Sign Out',
        'route' => 'user_logout',
        'class' => 'no-dloader',
      );
    } else {
      return array(
        'class' => 'user_auth_link',
        'label' => 'Sign In',
        'route' => 'user_login',
        'params' => array(
          // Nasty hack
          'return_url' => '64-' . base64_encode($_SERVER['REQUEST_URI']),
        ),
      );
    }
  }

  public function onMenuInitialize_SesadvminimenuMiniSignup($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return array(
        'label' => 'Sign Up',
        'route' => 'user_signup',
        'class' => 'user_signup_link',
      );
    }

    return false;
  }
  

  public function onMenuInitialize_SesadvminimenuMiniMessages($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() )
    {
      return false;
    }

    // Get permission setting
    $permission = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'messages', 'create');
    if( Authorization_Api_Core::LEVEL_DISALLOW === $permission )
    {
      return false;
    }

    $message_count = Engine_Api::_()->messages()->getUnreadMessageCount($viewer);
    $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl() . '/';

    return array(
      'label' => Zend_Registry::get('Zend_Translate')->_($row->label) . ( $message_count ? ' (' . $message_count .')' : '' ),
      'route' => 'messages_general',
      'params' => array(
        'action' => 'inbox'
      )
    );
  }
}
