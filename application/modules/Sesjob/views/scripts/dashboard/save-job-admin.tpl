<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesjob
 * @package    Sesjob
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: save-job-admin.tpl  2019-03-27 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php foreach($this->paginator as $jobAdmin):?>
	<div class="admin_manage" id="admin_manage_<?php echo $jobAdmin->role_id;?>">
		<?php $user = Engine_Api::_()->getItem('user', $jobAdmin->user_id);?>
		<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
		<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
		<?php if($jobAdmin->user_id != $this->owner_id):?>
			<a class="remove_job" href="javascript:void(0);" onclick="removeUser('<?php echo $jobAdmin->job_id;?>','<?php echo $jobAdmin->role_id;?>');"><i class="fa fa-close"></i></a>
		<?php endif;?>
		<br />
	</div>
<?php endforeach;?>
