<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_Widget_QuickImportController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
      $menu = new Sesmediaimporter_Plugin_Menus();
      $canView = $menu::canView();
      if(!$canView){
          return $this->setNoRender();
      }
  }
}
