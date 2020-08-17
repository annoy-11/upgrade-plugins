<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesquote_Form_Edit extends Sesquote_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit quote Entry')
      //->setAttrib('class', 'sesquote_create_form')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your quote.');
    $this->submit->setLabel('Save Changes');
  }
}