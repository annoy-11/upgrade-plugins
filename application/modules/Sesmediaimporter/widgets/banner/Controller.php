<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmediaimporter
 * @package    Sesmediaimporter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php 2017-06-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesmediaimporter_Widget_BannerController extends Engine_Content_Widget_Abstract {
  public function indexAction() {
      $this->view->bgcolor = $this->_getParam('background_color','1BC1D6');
      $this->view->title_text = $this->_getParam('title_text','Add and Import Photos');
      $this->view->description_text = $this->_getParam('description_text','Import, Add and Upload photos Instantly from Facebook, Instagram, Flickr, Google, 500px and Zip Folder on any device and use them on our Site and Apps.');
      $this->view->ios_url = $this->_getParam('ios_url',0);
      $this->view->android_url = $this->_getParam('android_url',0);
			$this->view->full_width = $this->_getParam('full_width','1');
  }
}
