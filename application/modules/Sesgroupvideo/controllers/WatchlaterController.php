<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupvideo
 * @package    Sesgroupvideo
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: WatchlaterController.php  2018-10-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesgroupvideo_WatchlaterController extends Core_Controller_Action_Standard {

  public function addAction() {
    $video_id = $this->_getParam('id', false);
    $error = true;
    $status = false;
    if ($video_id) {
      $params['video_id'] = $video_id;
      $insertVideo = Engine_Api::_()->sesgroupvideo()->deleteWatchlaterVideo($params);
      echo json_encode($insertVideo);
      die;
    }
    echo json_encode(array('status' => $status, 'error' => $error));
    die;
  }

}
