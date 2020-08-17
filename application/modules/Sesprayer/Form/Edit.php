<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesprayer_Form_Edit extends Sesprayer_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit prayer Entry')
      //->setAttrib('class', 'sesprayer_create_form')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your prayer.');
    $this->submit->setLabel('Save Changes');
  }
}