<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sespagenote_Form_Edit extends Sespagenote_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Note Entry')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your page note.');
    $this->submit->setLabel('Save Changes');
  }
}
