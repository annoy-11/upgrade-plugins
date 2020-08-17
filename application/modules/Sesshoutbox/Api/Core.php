<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshoutbox
 * @package    Sesshoutbox
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesshoutbox_Api_Core extends Core_Api_Abstract {

  public function smileyToEmoticons($string = null)
  {
    if (!in_array(
      'emoticons',
      Engine_Api::_()->getApi('settings', 'core')->getSetting('activity.composer.options')
    )) {
      return $string;
    }

    $emoticonsTag = Engine_Api::_()->activity()->getEmoticons(true);

    if (empty($emoticonsTag)) {
      return $string;
    }

    $string = str_replace("&lt;:o)", "<:o)", $string);
    $string = str_replace("(&amp;)", "(&)", $string);

    return strtr($string, $emoticonsTag);
  }

  public function checkPrivacySetting($shoutbox_id) {

    $shoutbox = Engine_Api::_()->getItem('sesshoutbox_shoutbox', $shoutbox_id);
    $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    if ($viewerId)
      $level_id = $viewer->level_id;
    else
      $level_id = 5;

    $levels = $shoutbox->member_level_view_privacy;
    $member_level = explode(",",$shoutbox->member_level_view_privacy); //json_decode($levels);


    if (!empty($member_level)  && !empty($shoutbox->member_level_view_privacy)) {
      if (!in_array($level_id, $member_level)) {
        $levelCheck = 'false';
      } else {
        $levelCheck = 'true';
      }
    } else {
      $levelCheck = 'true';
    }

    if ($viewerId) {
      $network_table = Engine_Api::_()->getDbtable('membership', 'network');
      $network_select = $network_table->select('resource_id')->where('user_id = ?', $viewerId);
      $network_id_query = $network_table->fetchAll($network_select);
      $network_id_query_count = count($network_id_query);
      $network_id_array = array();
      for ($i = 0; $i < $network_id_query_count; $i++) {
        $network_id_array[$i] = $network_id_query[$i]['resource_id'];
      }

      if (!empty($network_id_array)) {
        $networks = explode(",",$shoutbox->network_view_privacy); //json_decode($shoutbox->networks);

        if (!empty($networks) && !empty($shoutbox->network_view_privacy)) {
          if (!array_intersect($network_id_array, $networks)) {
            $networkCheck = 'false';
          } else {
            $networkCheck = 'true';
          }
        } else {
            $networkCheck = 'true';
        }
      } else {
        $networkCheck = 'true';
      }
    } else if($level_id == 5 && empty($viewerId) && $shoutbox->network_view_privacy == '') {
        $networkCheck = 'true';
    }

    if($networkCheck == 'true' && $levelCheck == 'true') {
        return true;
    } else {
        return false;
    }

  }
}
