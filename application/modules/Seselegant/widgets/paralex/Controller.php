<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Seselegant_Widget_ParalexController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', 250);
    $this->view->paralextitle = $this->_getParam('paralextitle', '<h2 style="font-size: 30px; font-weight: bold; margin-bottom: 20px; text-transform: uppercase;">CREATE AN AMAZING SOCIAL NETWORK</h2><p style="padding: 0 100px; font-size: 17px; margin-bottom: 20px;">SocialEngine is the best way to create your own social website or online community. No coding or design skills needed. Launch in minutes.</p><p style="text-align: center; padding-top: 20px;"><a style="color: #ffffff; padding: 13px 25px; margin: 0px 5px; text-decoration: none; font-weight: bold; border: 2px solid #ffffff;" href="login">LOGIN</a><a style="color: #ffffff; padding: 13px 25px; margin: 0px 5px; text-decoration: none; font-weight: bold; border: 2px solid #ffffff;" href="signup">JOIN NOW</a></p>');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->bannerimage = $bannerimage = $this->_getParam('bannerimage', 0);
  }

}
