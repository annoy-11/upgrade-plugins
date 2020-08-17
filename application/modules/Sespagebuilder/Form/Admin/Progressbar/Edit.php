<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Form_Admin_Progressbar_Edit extends Sespagebuilder_Form_Admin_Progressbar_Add {

  public function init() {
    parent::init();
    $this->setTitle('Edit This Progress Bar Value');
    $this->setDescription('Below, edit this progress bar value content and other parameters.');
    $this->save->setLabel('Save Changes');
  }

}
