<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesrecipe_Form_Admin_Review_Category_Edit extends Sesrecipe_Form_Admin_Review_Category_Add {

  public function init() {
    parent::init();
    $this->submit->setLabel('Save Changes');
  }

}
