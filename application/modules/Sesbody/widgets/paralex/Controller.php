<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbody
 * @package    Sesbody
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2019-02-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */


class Sesbody_Widget_ParalexController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->height = $this->_getParam('height', 250);
    $this->view->paralextitle = $this->_getParam('paralextitle', '<h2 style="font-size: 35px; font-weight: normal; margin-bottom: 20px; text-transform: uppercase;">HELP US MAKE VIDEO BETTER</h2>
                <p style="padding: 0 100px; font-size: 17px; margin-bottom: 20px;">You can help us make Videos even better by uploading your own content. Simply register for an account, select which content you want to contribute and then use our handy upload tool to add them to our library.</p>
                <ul>
                  <li style="display: inline-block; width: 30%;">
                    <h3 style="font-size:50px;font-weight:normal;border-width:0;">11000+</h3>
                    <span style="font-size:17px;">HAPPY CLIENTS</span>
                    <p style="font-size: 15px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                  </li>
                  <li style="display: inline-block; width: 30%;">
                    <h3 style="font-size:50px;font-weight:normal;border-width:0;">11000+</h3>
                    <span style="font-size:17px;">HAPPY CLIENTS</span>
                    <p style="font-size: 15px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                  </li>
                  <li style="display: inline-block; width: 30%;">
                    <h3 style="font-size:50px;font-weight:normal;border-width:0;">11000+</h3>
                    <span style="font-size:17px;">HAPPY CLIENTS</span>
                    <p style="font-size: 15px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore.</p>
                  </li>
                </ul>');
    $sesbody_widget = Zend_Registry::isRegistered('sesbody_widget') ? Zend_Registry::get('sesbody_widget') : null;
    if(empty($sesbody_widget))
      return $this->setNoRender();
    $this->view->storage = Engine_Api::_()->storage();
    $this->view->bannerimage = $bannerimage = $this->_getParam('bannerimage', 0);
  }

}
