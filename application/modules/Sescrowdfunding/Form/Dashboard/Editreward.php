<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Editreward.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Form_Dashboard_Editreward extends Sescrowdfunding_Form_Dashboard_Postreward {

  public function init() {
    parent::init();
    $this->setDescription('');
    $this->removeElement('cancel');
    $this->setTitle('Edit Reward');
  }

}
