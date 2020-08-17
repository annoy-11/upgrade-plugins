<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Estore
 * @package    Estore
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Estore_Form_Edit extends Estore_Form_Create {
  public function init() {
    parent::init();
    $this->setDescription('Edit your store below, then click "Save Changes" to publish the store.');
    $this->removeElement('cancel');
	$this->setTitle('Edit Store');
  }
}
