<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seschristmas
 * @package    Seschristmas
 * @copyright  Copyright 2014-2015 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2014-11-15 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seschristmas_Plugin_Core extends Zend_Controller_Plugin_Abstract {

  public function onRenderLayoutDefault($event, $mode = null) {

    $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
    $core_setting = Engine_Api::_()->getApi('settings', 'core');    
    $welcome_page_show = $core_setting->getSetting('seschristmas.welcomepageshow', 0);
    $welcome_page = $core_setting->getSetting('seschristmas.welcome', 1);
    $show_template = $core_setting->getSetting('seschristmas.template', 1);
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    if (isset($_GET['christmas']) && $_GET['christmas'] == 1) {
      $welcomedsession = new Zend_Session_Namespace('seschristmaswelcome');
      $welcomedsession->seschristmaswelcome = 1;
      $redirector->gotoRoute(array('action' => 'home'), 'user_general', true);
    }

    if (!isset($_SESSION['seschristmaswelcome']) && $welcome_page) {
      if ($welcome_page_show == 0) {
        $redirector->gotoRoute(array('module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'index'), 'seschristmas_welcome', false);
      } elseif ($welcome_page_show == 1 && empty($viewer_id)) {
        $redirector->gotoRoute(array('module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'index'), 'seschristmas_welcome', false);
      } elseif ($welcome_page_show == 2 && !empty($viewer_id)) {
        $redirector->gotoRoute(array('module' => 'seschristmas', 'controller' => 'welcome', 'action' => 'index'), 'seschristmas_welcome', false);
      }
    }
    
    if ($show_template == 1) {
      $script = <<<EOF
  window.addEvent('domready', function() {
$(document.body).addClass('seschristmas_template1');
  });
EOF;
      $view->headScript()->appendScript($script);
    } else {
      $script = <<<EOF
  window.addEvent('domready', function() {
$(document.body).addClass('seschristmas_template2');
  });
EOF;
      $view->headScript()->appendScript($script);
    }

    if ($show_template != 2) {
      include_once APPLICATION_PATH . '/application/modules/Seschristmas/Api/christmastemplate.php';
    }
  }

}
