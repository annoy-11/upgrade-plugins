<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: save-recipe-admin.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php foreach($this->paginator as $recipeAdmin):?>
	<div class="admin_manage" id="admin_manage_<?php echo $recipeAdmin->role_id;?>">
		<?php $user = Engine_Api::_()->getItem('user', $recipeAdmin->user_id);?>
		<?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.icon', $user->getTitle())) ?>
		<?php echo $this->htmlLink($user->getHref(), $user->getTitle()) ?>
		<?php if($recipeAdmin->user_id != $this->owner_id):?>
			<a class="remove_recipe" href="javascript:void(0);" onclick="removeUser('<?php echo $recipeAdmin->recipe_id;?>','<?php echo $recipeAdmin->role_id;?>');"><i class="fa fa-close"></i></a>
		<?php endif;?>
		<br />
	</div>
<?php endforeach;?>