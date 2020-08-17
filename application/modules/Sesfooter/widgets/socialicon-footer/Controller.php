<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sesfooter_Widget_SocialiconFooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
		$this->view->title = $this->_getParam('title', "Follow us on");
		$this->view->background_color = $this->_getParam('background_color', '#FFAB40');
		$this->view->text_color = $this->_getParam('text_color', '#ffffff');
    $this->view->paginator = Engine_Api::_()->getDbTable('socialicons', 'sesfooter')->getSocialInfo(array('enabled' => 1));
  }

}