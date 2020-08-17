<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Seswishe_Form_Edit extends Seswishe_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit wishe Entry')
      //->setAttrib('class', 'seswishe_create_form')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your wishe.');
    $this->submit->setLabel('Save Changes');
  }
}