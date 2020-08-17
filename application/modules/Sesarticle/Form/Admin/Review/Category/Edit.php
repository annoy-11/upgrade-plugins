<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesarticle_Form_Admin_Review_Category_Edit extends Sesarticle_Form_Admin_Review_Category_Add {

  public function init() {
    parent::init();
    $this->submit->setLabel('Save Changes');
  }

}
