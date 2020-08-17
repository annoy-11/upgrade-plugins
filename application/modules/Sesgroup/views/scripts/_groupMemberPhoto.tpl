<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroup
 * @package    Sesgroup
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _groupMemberPhoto.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php if(isset($this->memberPhotoActive)):?>
	<?php $members = Engine_Api::_()->getDbTable('membership','sesgroup')->groupMembers($group->group_id);?>
	<div class="sesgroup_members_img">
	  <?php $countMember = 1;?>
	  <?php foreach($members as $member):?>
      <?php if($member) { ?>
      <?php if($countMember > $limitMember):?>
        <?php break;?>
      <?php endif;?>
      <a href="<?php echo $member->getHref();?>"><span><?php echo $this->itemPhoto($member, 'thumb.icon', $member->getTitle());?></span></a>
      <?php $countMember++;?>
    <?php } ?>
	  <?php endforeach;?>
	  <?php if(count($members) > $limitMember):?>
		<?php $tab_id = Engine_Api::_()->sesgroup()->getWidgetTabId(array('name' => 'sesgroup.profile-members','pageDesign' => $group->groupstyle));?>
		<a href="<?php echo $group->getHref().'/tab/'.$tab_id;?>"><span><p>+<?php echo count($members) - $limitMember;?></p></span></a>
	  <?php endif;?>
	  
	</div>
<?php endif;?>
