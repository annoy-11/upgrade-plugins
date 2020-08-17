<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
class Sesgroup_Form_Edit extends Sesgroup_Form_Create {
  public function init() {
    parent::init();
    $this->setDescription('Edit your group below, then click "Save Changes" to publish the group.');
    $this->removeElement('cancel');
	$this->setTitle('Edit Group');
  }
}
