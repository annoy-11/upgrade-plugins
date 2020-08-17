<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sestestimonial
 * @package    Sestestimonial
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-10-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sestestimonial_Form_Edit extends Sestestimonial_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Testimonial Entry')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your testimonial.');
    $this->submit->setLabel('Save Changes');
  }
}
