<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfundingvideo
 * @package    Sescrowdfundingvideo
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Composer.php 2018-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sescrowdfundingvideo_Plugin_Composer extends Core_Plugin_Abstract {

  public function onAttachSescrowdfundingvideo($data) {
    if (!is_array($data) || empty($data['crowdfundingvideo_id'])) {
      return;
    }

    $video = Engine_Api::_()->getItem('crowdfundingvideo', $data['crowdfundingvideo_id']);
    // update $video with new title and description
    $video->title = $data['title'];
    $video->description = $data['description'];

    // Set parents of the video
    if (Engine_Api::_()->core()->hasSubject()) {
      $subject = Engine_Api::_()->core()->getSubject();
      $subject_type = $subject->getType();
      $subject_id = $subject->getIdentity();

      $video->parent_type = $subject_type;
      $video->parent_id = $subject_id;
    }
    $video->search = 1;
    $video->save();

    if (!($video instanceof Core_Model_Item_Abstract) || !$video->getIdentity()) {
      return;
    }

    return $video;
  }

}
