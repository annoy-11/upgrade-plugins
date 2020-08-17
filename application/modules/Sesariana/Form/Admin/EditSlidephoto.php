<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSlidephoto.php 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesariana_Form_Admin_EditSlidephoto extends Sesariana_Form_Admin_Slidephoto {

  public function init() {

    parent::init();
    $this->setTitle('Edit Slide');
    $this->submit->setLabel('Save Changes');
  }

}