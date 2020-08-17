<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Edit extends Sesbusiness_Form_Create {
  public function init() {
    parent::init();
    $this->setDescription('Edit your business below, then click "Save Changes" to publish the business.');
    $this->removeElement('cancel');
	$this->setTitle('Edit Business');
  }
}
