<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Plugin_Core {

  public function onRenderLayoutDefault($event, $mode = null) {
    if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sespoke.pluginactivated'))
      include APPLICATION_PATH . '/application/modules/Sespoke/views/scripts/index/actiongift.tpl';

    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		$script = '';
    if ($moduleName == 'sespoke') {
      $script .= "
        window.addEvent('domready', function() {
         $$('.sespoke_pokepage').getParent().addClass('active');
        });";
    }
    $view->headScript()->appendScript($script);
  }

}
