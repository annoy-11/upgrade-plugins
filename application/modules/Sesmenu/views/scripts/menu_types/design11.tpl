<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design11.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $apiTable = Engine_Api::_()->getApi('core', 'sesmenu');?>
<?php $categories  = $apiTable->getCategories($menuItem->module); ?>

<?php if(!count($categories)):?>
	<li class="no_content">
        <div class="sesbasic_tip">
            <img src="<?php echo $apiTable->contentNoFoundImg($menuItem) ; ?>">
            <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($menuItem) ; ?></span>
        </div>
	</li>
<?php else: ?>
<?php $company  = $apiTable->getModuleData($menuItem->module); ?>
	<?php $counter=0; ?>
	<?php foreach($categories as $category): ?>
		<?php if($counter == $menuItem->categories_count) {
			break;
		}
		?>
		<li class="sesmenu_submenu_item sesmenu_category_menu_item">
			<a href="<?php echo $category->getHref(); ?>">
        <?php if($menuItem->show_icon) { ?>
            <?php if($company['company']=='SES'):?>
                <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->cat_icon, '');
                if($file)
                $icon = $file->map(); ?>
                <i class="sesbasic_text_light"><img src="<?php echo ($category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
                <?php $category->cat_icon=0; $icon=0; ?>
            <?php else : ?>
                <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/category-icon.png"></i>
            <?php endif;?>
        <?php } ?>
				<?php echo $category->getTitle();?>	
			</a>
		</li>
	<?php $counter++; ?>
	<?php endforeach; ?>
<?php endif;?>
