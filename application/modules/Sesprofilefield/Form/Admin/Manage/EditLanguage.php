<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditLanguage.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprofilefield_Form_Admin_Manage_EditLanguage extends Sesprofilefield_Form_Admin_Manage_AddLanguage {

  public function init() {
    parent::init();
    $this->submit->setLabel('Save Changes');
  }

}
