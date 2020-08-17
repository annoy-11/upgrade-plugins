<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: WatchlaterController.php 2015-10-11 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingvideo_WatchlaterController extends Core_Controller_Action_Standard {

  public function addAction() {
    $crowdfundingvideo_id = $this->_getParam('id', false);
    $error = true;
    $status = false;
    if ($crowdfundingvideo_id) {
      $params['crowdfundingvideo_id'] = $crowdfundingvideo_id;
      $insertVideo = Engine_Api::_()->sescrowdfundingvideo()->deleteWatchlaterVideo($params);
      echo json_encode($insertVideo);
      die;
    }
    echo json_encode(array('status' => $status, 'error' => $error));
    die;
  }

}
