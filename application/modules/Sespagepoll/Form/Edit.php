<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagepoll
 * @package    Sespagepoll
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Edit.php  2018-10-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagepoll_Form_Edit extends Sespagepoll_Form_Create{
  public function init(){
    parent::init();
    $this->setTitle('Edit Poll ')->setDescription('Edit your poll');
    $this->submit->setLabel('Save');
  }
}