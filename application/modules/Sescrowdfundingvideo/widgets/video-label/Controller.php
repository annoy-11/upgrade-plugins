<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sescrowdfundingvideo_Widget_videoLabelController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('crowdfundingvideo'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('crowdfundingvideo'))
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('crowdfundingvideo');

    $this->view->option = $this->_getParam('option',array('hot','verified','sponsored','featured'));
  }
}
