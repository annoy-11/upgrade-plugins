<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: save-product-admin.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php foreach($this->paginator as $productAdmin):?>
	<div class="admin_manage" id="admin_manage_<?php echo $productAdmin->role_id;?>">
		<?php $user = Engine_Api::_()->getItem('user', $productAdmin->user_id);?>
		<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
		<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
		<?php if($productAdmin->user_id != $this->owner_id):?>
			<a class="remove_product" href="javascript:void(0);" onclick="removeUser('<?php echo $productAdmin->product_id;?>','<?php echo $productAdmin->role_id;?>');"><i class="fa fa-times"></i></a>
		<?php endif;?>
		<br />
	</div>
<?php endforeach;?>
