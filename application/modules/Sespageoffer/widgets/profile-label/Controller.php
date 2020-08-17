<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageoffer
 * @package    Sespageoffer
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespageoffer_Widget_ProfileLabelController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('pageoffer'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('pageoffer'))
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('pageoffer');

    $this->view->option = $this->_getParam('option',array('hot', 'new','featured'));
  }
}
