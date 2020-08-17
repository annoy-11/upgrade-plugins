<?php 

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespagebuilder_Widget_ProgressbarController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
    $this->view->progressbar_id = $progressbar_id = $this->_getParam('progressbar_id', 0);
    if (!($progressbar_id))
      return $this->setNoRender();
    $this->view->progressbar = $progressbar = Engine_Api::_()->getItem('sespagebuilder_progressbar', $progressbar_id);
    if (empty($progressbar))
      return $this->setNoRender();
    $this->view->progressbarcontent = $progressbarcontent = $progressbar->getContents();
    if (empty($progressbarcontent))
      return $this->setNoRender();
  }
}