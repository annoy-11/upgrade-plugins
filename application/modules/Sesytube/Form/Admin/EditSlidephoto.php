<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSlidephoto.php  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesytube_Form_Admin_EditSlidephoto extends Sesytube_Form_Admin_Slidephoto {

  public function init() {

    parent::init();
    $this->setTitle('Edit Slide');
    $this->submit->setLabel('Save Changes');
  }

}
