<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesadvpoll
 * @package    Sesadvpoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-12-26 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesadvpoll_Form_Edit extends Sesadvpoll_Form_Create{
  public function init(){
    parent::init();
    $this->setTitle('Edit Poll ')->setDescription('Edit your poll');
    $this->submit->setLabel('Save');
  }
}
