<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: save-listing-admin.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php foreach($this->paginator as $listingAdmin):?>
	<div class="admin_manage" id="admin_manage_<?php echo $listingAdmin->role_id;?>">
		<?php $user = Engine_Api::_()->getItem('user', $listingAdmin->user_id);?>
		<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
		<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
		<?php if($listingAdmin->user_id != $this->owner_id):?>
			<a class="remove_listing" href="javascript:void(0);" onclick="removeUser('<?php echo $listingAdmin->listing_id;?>','<?php echo $listingAdmin->role_id;?>');"><i class="fa fa-close"></i></a>
		<?php endif;?>
		<br />
	</div>
<?php endforeach;?>
