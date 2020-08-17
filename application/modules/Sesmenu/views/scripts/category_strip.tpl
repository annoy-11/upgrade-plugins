<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: category_strip.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<ul>
<?php $categories  = $apiTable->getCategories($menuItem->module); ?>
<?php if(!$categories):?>
	<li>Sorry No Any Subcategry of Selected Menu</li>
<?php else: ?>
	<?php $counter=0; ?>
	<?php foreach($categories as $category): ?>
		<?php if($counter == $menuItem->categories_count) {
		 break;
		}
		?>
		<li class="sesmenu_submenu_item sesmenu_category_name">
		  <a href="<?php echo $category->getHref(); ?>">
			 <?php echo $category->getTitle(); ?>
		  </a>
		</li>
	<?php $counter++; ?>
	<?php endforeach; ?>
<?php endif;?>
</ul>
