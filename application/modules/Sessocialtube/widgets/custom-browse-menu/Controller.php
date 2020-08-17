<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sessocialtube_Widget_CustomBrowseMenuController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $headerFixed = Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_header_fixed_layout');
    if($headerFixed == 2)
      return $this->setNoRender();
  
  
  }

}