<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Plugin_Menus {

  public function canViewFixedpage($row) {

    if (isset($row->params['pagebuilder_id'])) {
      $fixedPageId = $row->params['pagebuilder_id'];
      $returnValue = Engine_Api::_()->sespagebuilder()->checkPrivacySetting($fixedPageId);
      if ($returnValue == false) {
        return false;
      }
    }
    if(!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sespagebuilder'))
    return false;
    else
    return true;
  }

}
