<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmember
 * @package    Sesmember
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editbrowsepage.php 2016-05-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesmember_Form_Admin_Manage_Editbrowsepage extends Sesmember_Form_Admin_Manage_Createbrowsepage {

  public function init() {
    parent::init();

    $this->setTitle('Edit This Page')->setDescription('Below, edit this Page\'s content and other parameters.');
    $this->submit->setLabel('Save Changes');
  }

}
