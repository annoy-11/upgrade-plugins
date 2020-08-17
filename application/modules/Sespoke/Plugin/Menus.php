<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Menus.php 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
class Sespoke_Plugin_Menus {

  public function sespokeGutterCreate($row) {

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    $subject = Engine_Api::_()->core()->getSubject();
    $subject_id = $subject->getIdentity();

    $subjectTitle = $subject->getTitle();
    $manageaction_id = $row->params['manageaction_id'];
    $manageActions = Engine_Api::_()->getItem('sespoke_manageaction', $manageaction_id);

    $name = $manageActions->name;
    $icon = Engine_Api::_()->storage()->get($manageActions->icon, '')->getPhotoUrl();
    $action = $manageActions->action;

    if ($action == 'gift')
      $label = "Send " . ucfirst($name);
    else
      $label = ucfirst($name) . ' ' . ucfirst($subjectTitle);

    if ($manageActions->member_levels)
      $member_levels = json_decode($manageActions->member_levels);

    if ($subject_id != $viewer_id && $manageActions->enabled && in_array($viewer->level_id, $member_levels) && $manageActions->enabled_gutter) {

      return array(
          'label' => $label,
          'route' => "default",
          "module" => "sespoke",
          'icon' => $icon,
          "controller" => "index",
          'action' => 'poke',
          'class' => "smoothbox",
          'params' => array(
              'id' => $subject_id,
              'manageaction_id' => $manageaction_id,
          ),
      );
    }
    return false;
  }

}
