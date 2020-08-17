<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editlocation.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusiness_Form_Dashboard_Editlocation extends Sesbusiness_Form_Dashboard_Addlocation {
  public function init() {
    parent::init();
    $this->setDescription('');
    $this->removeElement('cancel');
	$this->setTitle('Edit Location');
  }
}
