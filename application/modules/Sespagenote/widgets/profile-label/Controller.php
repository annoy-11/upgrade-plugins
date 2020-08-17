<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagenote
 * @package    Sespagenote
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-03-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagenote_Widget_ProfileLabelController extends Engine_Content_Widget_Abstract
{
  public function indexAction() {

    if (!Engine_Api::_()->core()->hasSubject('pagenote'))
        return $this->setNoRender();

    if(Engine_Api::_()->core()->hasSubject('pagenote'))
        $this->view->subject = $subject = Engine_Api::_()->core()->getSubject('pagenote');

    $this->view->option = $this->_getParam('option',array('sponsored','featured'));
  }
}
