<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagevideo
 * @package    Sespagevideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagevideo_Widget_videoLabelController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('pagevideo'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('pagevideo'))
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('pagevideo');

    $this->view->option = $this->_getParam('option',array('hot','verified','sponsored','featured'));
  }
}
