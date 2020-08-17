<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editannouncement.php  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroup_Form_Dashboard_Editannouncement extends Sesgroup_Form_Dashboard_Postannouncement {

  public function init() {
    parent::init();
    $this->setDescription('');
    $this->removeElement('cancel');
    $this->setTitle('Edit Announcement');
  }

}
