<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Poke.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespoke_Model_Poke extends Core_Model_Item_Abstract {

  protected $_searchTriggers = false;

  public function getRichContent($view = false, $params = array()) {
  
    $poke = '';
    if (!$view) {
      $view = Zend_Registry::get('Zend_View');
			$view->poke = $this;
      $poke = $view->render('application/modules/Sespoke/views/scripts/_feedPoke.tpl');
    }
    return $poke;
  }
}