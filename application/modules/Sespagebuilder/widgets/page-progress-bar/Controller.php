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
class Sespagebuilder_Widget_PageProgressBarController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->progressbar = $this->_getParam('progressbar', 'minimal');
    $this->view->color = $this->_getParam('bg_progressbar_color', 'fbff00');
    $checkProgressbar = Engine_Api::_()->getApi('settings', 'core')->getSetting('show.progressbar', '1');
    if (empty($checkProgressbar))
      return $this->setNoRender();
  }

}
