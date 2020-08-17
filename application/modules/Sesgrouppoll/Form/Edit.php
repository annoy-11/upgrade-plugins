<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgrouppoll
 * @package    Sesgrouppoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesgrouppoll_Form_Edit extends Sesgrouppoll_Form_Create
{
  public function init()
  {
    parent::init();

    $this->setTitle('Edit Poll ')->setDescription('Edit your poll');
    
    $this->submit->setLabel('Save');
  }
}