<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSlidephoto.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seselegant_Form_Admin_EditSlidephoto extends Seselegant_Form_Admin_Slidephoto {

  public function init() {

    parent::init();
    $this->setTitle('Edit Slide');
    $this->submit->setLabel('Save Changes');
  }

}