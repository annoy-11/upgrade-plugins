<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Popupedit.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Popup_Popupedit extends Sespagebuilder_Form_Admin_Popup_Popupcreate {

  public function init() {
    parent::init();
    $this->save->setLabel('Save Changes');
  }

}