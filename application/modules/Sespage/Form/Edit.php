<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sespage_Form_Edit extends Sespage_Form_Create {
  public function init() {
    parent::init();
    $this->setDescription('Edit your page below, then click "Save Changes" to publish the page.');
    $this->removeElement('cancel');
	$this->setTitle('Edit Page');
  }
}
