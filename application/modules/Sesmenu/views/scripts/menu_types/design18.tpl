<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design18.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($menuItem->module.'_main'); 
$menuSubArray = $subMenus->toArray();
?>
<?php if(!count($subMenus)):?>
	<li class="no_content">
        <div class="sesbasic_tip">
        <?php if(!empty($menuItem->emptyfeild_img)){ ?> 
            <img src="<?php echo $menuItem->emptyfeild_img ; ?>">
        <?php } ?>  
        <?php if(!empty($menuItem->emptyfeild_txt)){ ?> 
            <span class="sesbasic_text_light"><?php echo $menuItem->emptyfeild_txt; ?></span>
        <?php } ?>
        </div>
	</li>
<?php else: ?>
	<?php $counter=0; ?>
	<?php foreach($subMenus as $subMenu): ?>
		<?php if($counter == $menuItem->categories_count) {
		 break;
		}
		$active = isset($menuSubArray[$counter]['active']) ? $menuSubArray[$counter]['active'] : 0;
		?>
    <li class="sesmenu_submenu_item sesmenu_category_menu_item">
        <a href="<?php echo $subMenu->getHref(); ?>" class="<?php echo $subMenu->getClass(); ?>">
            <?php if($menuItem->show_icon) { ?>
                <i class="fa <?php echo $subMenu->icon ? $subMenu->icon : 'fa-star' ?>"></i>
            <?php } ?>
            <?php echo $this->translate($subMenu->getLabel()); ?>
        </a> 
    </li>
	<?php $counter++; ?>
	<?php endforeach; ?>

<?php endif;?>
