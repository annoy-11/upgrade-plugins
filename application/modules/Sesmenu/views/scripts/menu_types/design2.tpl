<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design2.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $categories  = $apiTable->getCategories($menuItem->module); ?>
<?php if(!count($categories)):?>
	<li class="no_content">
    <div class="sesbasic_tip">
        <img src="<?php echo $apiTable->contentNoFoundImg($menuItem) ; ?>">
        <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($menuItem) ; ?></span>
    </div>
	</li>
<?php else: ?>
	<?php $counter=0; ?>
	<?php foreach($categories as $category): ?>
		<?php if($counter == $menuItem->categories_count) {
		 break;
		}
		?>
		<li class="sesmenu_submenu_item sesmenu_category_menu_item">
		  <a href="<?php echo $category->getHref(); ?>">
        <div class="cat_box">
            <?php if($menuItem->show_icon) { ?>
                <?php if($moduleData['company']=='SES'):?>
                    <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->cat_icon, '');
                    if($file)
                    $icon = $file->map(); ?>
                    <span class="cat_icon" style="background-image:url('<?php echo ($category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>');"></span>
                    <?php $category->cat_icon=0; $icon=0; ?>
                <?php else : ?>
                        <span class="cat_icon" style="background-image:url('application/modules/Sesmenu/externals/images/category-icon.png');"></span>
                <?php endif;?>
            <?php } ?>
            <?php if(isset($category['category_name'])) { ?>
                <span class="cat_name">
                    <?php echo $category['category_name'];?>
                </span>
            <?php } else if(isset($category['title'])) { ?>
                    <span class="cat_name">
                    <?php echo $category['title'];?>
                </span>
            <?php } ?>
        </div>
		  </a>
		</li>
		<?php $counter++; ?>
	<?php endforeach; ?>
<?php endif;?>

