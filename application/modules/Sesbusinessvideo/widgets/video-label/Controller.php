<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusinessvideo
 * @package    Sesbusinessvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesbusinessvideo_Widget_videoLabelController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('businessvideo'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('businessvideo'))
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('businessvideo');

    $this->view->option = $this->_getParam('option',array('hot','verified','sponsored','featured'));
  }
}
