<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventspeaker
 * @package    Seseventspeaker
 * @copyright  Copyright 2018-2017 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditEventSpeaker.php 2017-03-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seseventspeaker_Form_EditEventSpeaker extends Seseventspeaker_Form_AddEventSpeaker {

  public function init() {

    $type = Zend_Controller_Front::getInstance()->getRequest()->getParam('type');
    parent::init();
    $this->setTitle('Edit Speaker')
            ->setDescription('Below, you can edit this speaker.')
            ->setMethod('POST');
  }

}