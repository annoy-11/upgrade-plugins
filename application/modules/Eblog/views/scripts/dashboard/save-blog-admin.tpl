<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Eblog
 * @package    Eblog
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: save-blog-admin.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->paginator as $blogAdmin):?>
	<div class="admin_manage" id="admin_manage_<?php echo $blogAdmin->role_id;?>">
		<?php $user = Engine_Api::_()->getItem('user', $blogAdmin->user_id);?>
		<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
		<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
		<?php if($blogAdmin->user_id != $this->owner_id):?>
			<a class="remove_blog" href="javascript:void(0);" onclick="removeUser('<?php echo $blogAdmin->blog_id;?>','<?php echo $blogAdmin->role_id;?>');"><i class="fa fa-close"></i></a>
		<?php endif;?>
		<br />
	</div>
<?php endforeach;?>