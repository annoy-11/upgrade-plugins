<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editlocation.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Dashboard_Editlocation extends Estore_Form_Dashboard_Addlocation {
  public function init() {
    parent::init();
    $this->setDescription('');
    $this->removeElement('cancel');
	$this->setTitle('Edit Location');
  }
}
