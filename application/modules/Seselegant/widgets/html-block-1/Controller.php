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

class Seselegant_Widget_HtmlBlock1Controller extends Engine_Content_Widget_Abstract {

  public function indexAction() {
  
    $this->view->height = $this->_getParam('content_height', 0);
    $this->view->width = $this->_getParam('content_width', 0);
    $content = '<div class="elegant_home_content_block sesbasic_bxs"><div class="elegant_home_content_block_inner"><div class="elegant_home_content_block_top"><h3 class="elegant_home_content_block_title">Share Photos, Videos and Music on your Community!</h3><p class="elegant_home_content_block_des">Videos are more engaging as compared to the static content on your website. Photos are capture your memory. Music Songs are refresh your mind.</p></div><div class="elegant_home_content_features"><div class="elegant_home_content_feature_box"><img src="./application/modules/Seselegant/externals/images/box-img1.png" alt=""> <span class="elegant_home_content_feature_head">Share Your Photos</span><p class="elegant_home_content_feature_des">Share your photos with your friends &amp; family and Upload pictures.</p><a class="elegant_home_content_feature_more" href="albums">Explore</a></div><div class="elegant_home_content_feature_box"><img src="./application/modules/Seselegant/externals/images/box-img2.png" alt=""> <span class="elegant_home_content_feature_head">Watch Videos</span><p class="elegant_home_content_feature_des">Simply register for an account and watch ultimate videos.</p> <a class="elegant_home_content_feature_more" href="videos">Explore</a></div><div class="elegant_home_content_feature_box"><img src="./application/modules/Seselegant/externals/images/box-img3.png" alt=""> <span class="elegant_home_content_feature_head">Play Music</span><p class="elegant_home_content_feature_des">Play music from your favorites artists and share and connect to songs.</p><a class="elegant_home_content_feature_more" href="music/album/home">Explore</a></div> </div></div></div>';

    $this->view->content = Engine_Api::_()->getApi('settings', 'core')->getSetting('seselegant.block.1', $content);
  }

}