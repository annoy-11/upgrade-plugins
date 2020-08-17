<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Seswishe_Form_Admin_Category_Edit extends Seswishe_Form_Admin_Category_Add {

  public function init() {
    parent::init();
    $this->submit->setLabel('Save Changes');
  }
}