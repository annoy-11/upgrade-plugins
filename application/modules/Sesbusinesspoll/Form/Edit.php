<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinesspoll
 * @package    Sesbusinesspoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-10-29 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinesspoll_Form_Edit extends Sesbusinesspoll_Form_Create{
  public function init(){
    parent::init();
    $this->setTitle('Edit Poll ')->setDescription('Edit your poll');
    $this->submit->setLabel('Save');
  }
}
