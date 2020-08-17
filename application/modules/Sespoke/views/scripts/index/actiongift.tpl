<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespoke
 * @package    Sespoke
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: actiongift.tpl 2015-07-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $results = Engine_Api::_()->getDbtable('manageactions', 'sespoke')->getResults(array('enabled' => 1)); ?>
<?php foreach($results as $result): 
$name = strtolower(str_replace(' ', '_', $result['name']));
$manageaction_id = strtolower($result['manageaction_id']);
$icon = $result['icon'];
?>
<?php $icon = Engine_Api::_()->storage()->get($icon, '')->getPhotoUrl(); ?>
<style>
  .notification_type_sespoke_<?php echo $name ?>,
  .activity_icon_sespoke_<?php echo $name ?>,
  .notification_type_sespoke_back_<?php echo $name ?> {
    background-image:url(<?php echo $icon ?>) !important;
  }

</style>
<?php endforeach; ?>