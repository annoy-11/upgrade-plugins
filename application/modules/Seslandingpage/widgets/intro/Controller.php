<?php



/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslandingpage
 * @package    Seslandingpage
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */



class Seslandingpage_Widget_IntroController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
	  $this->getElement()->removeDecorator('Title');
    $this->view->title = $this->_getParam('heading', '');
    $this->view->description = $this->_getParam('description', null);
    $this->view->buttontitle = $this->_getParam('buttontitle', 'Explore');
    $this->view->buttonurl = $this->_getParam('buttonurl', '');
    $this->view->backgroundimage = $this->_getParam('backgroundimage', 'application/modules/Seslandingpage/externals/images/lp-intro-img.jpg');
    $this->view->featureblock_id = $this->_getParam('featureblock_id', null);
		$this->view->design_id = $this->_getParam('design_id', 1);
    $this->view->featureblock = Engine_Api::_()->getItem('seslandingpage_featureblock', $this->view->featureblock_id);
	}
}
