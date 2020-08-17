<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessoffer
 * @package    Sesbusinessoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessoffer_Widget_ProfileLabelController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('businessoffer'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('businessoffer'))
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('businessoffer');

    $this->view->option = $this->_getParam('option',array('hot', 'new','featured'));
  }
}
