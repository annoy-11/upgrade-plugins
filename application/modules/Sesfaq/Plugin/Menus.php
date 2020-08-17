<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfaq
 * @package    Sesfaq
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php  2017-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesfaq_Plugin_Menus {

  public function askquestion() {
    $viewer = Engine_Api::_()->user()->getViewer();
    $authorizationApi = Engine_Api::_()->authorization();
    if (!$authorizationApi->isAllowed('sesfaq_faq', $viewer, 'view'))
      return false;
    if (!$authorizationApi->isAllowed('sesfaq_faq', $viewer, 'askquestion'))
      return false;
    return true;
  }
}