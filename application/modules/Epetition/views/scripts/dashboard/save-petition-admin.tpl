<?php

 /**
 * socialnetworking.solutions
 *
 * @category   Application_Modules
 * @package    Epetition
 * @copyright  Copyright 2014-2019 Ahead WebSoft Technologies Pvt. Ltd.
 * @license    https://socialnetworking.solutions/license/
 * @version    $Id: save-petition-admin.tpl 2019-11-07 00:00:00 socialnetworking.solutions $
 * @author     socialnetworking.solutions
 */
 
?>
<?php foreach($this->paginator as $petitionAdmin):?>
	<div class="admin_manage" id="admin_manage_<?php echo $petitionAdmin->role_id;?>">
		<?php $user = Engine_Api::_()->getItem('user', $petitionAdmin->user_id);?>
		<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
		<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
		<?php if($petitionAdmin->user_id != $this->owner_id):?>
			<a class="remove_petition" href="javascript:void(0);" onclick="removeUser('<?php echo $petitionAdmin->epetition_id;?>','<?php echo $petitionAdmin->role_id;?>');"><i class="fa fa-close"></i></a>
		<?php endif;?>
		<br />
	</div>
<?php endforeach;?>