<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfunding_Widget_ProfileDescriptionController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->viewer_id = $viewer->getIdentity();

    $this->view->showcriteria = $this->_getParam('showcriteria', array('shourtdec','slide','description','otherinfo', 'share'));

    $id = Zend_Controller_Front::getInstance()->getRequest()->getParam('crowdfunding_id', null);

    $crowdfunding_id = Engine_Api::_()->getDbtable('crowdfundings', 'sescrowdfunding')->getCrowdfundingId($id);

    if(!Engine_Api::_()->core()->hasSubject())
      $sescrowdfunding = Engine_Api::_()->getItem('crowdfunding', $crowdfunding_id);
    else
      $sescrowdfunding = Engine_Api::_()->core()->getSubject();

    //Prepare data
    $this->view->crowdfunding = $sescrowdfunding;
  }

}
