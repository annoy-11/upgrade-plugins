<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesbusinessoffer_Form_Edit extends Sesbusinessoffer_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Offer Entry')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your business offer.');
    $this->submit->setLabel('Save Changes');
  }
}
