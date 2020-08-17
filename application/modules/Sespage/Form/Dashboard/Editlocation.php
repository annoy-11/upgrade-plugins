<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editlocation.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Form_Dashboard_Editlocation extends Sespage_Form_Dashboard_Addlocation {
  public function init() {
    parent::init();
    $this->setDescription('');
    $this->removeElement('cancel');
	$this->setTitle('Edit Location');
  }
}
