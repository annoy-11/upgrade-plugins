<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespageoffer_Form_Edit extends Sespageoffer_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Offer Entry')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your page offer.');
    $this->submit->setLabel('Save Changes');
  }
}
