<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesdiscussion_Form_Edit extends Sesdiscussion_Form_Create
{
  public function init()
  {
    parent::init();
    $this->setTitle('Edit discussion Entry')
      // ->setAttrib('class', 'sesdiscussion_create_form')
      ->setDescription('Edit your entry below, then click "Post Entry" to publish the entry on your discussion.');
    $this->submit->setLabel('Save Changes');
  }
}