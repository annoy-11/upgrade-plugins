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

class Sescrowdfunding_Widget_ParallaxBannerController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
        $this->view->banner = $banner = $this->_getParam('banner', 'application/modules/Sescrowdfunding/externals/images/bg_crowd.jpg');
    }
}
