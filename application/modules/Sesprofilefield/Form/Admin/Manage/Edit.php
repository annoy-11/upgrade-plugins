<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprofilefield
 * @package    Sesprofilefield
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-02-06 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesprofilefield_Form_Admin_Manage_Edit extends Sesprofilefield_Form_Admin_Manage_Add {

  public function init() {
    parent::init();
    $this->submit->setLabel('Save Changes');
  }
}