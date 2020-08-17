<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design12.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
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
        <?php if($menuItem->show_icon) { ?>
            <?php if($moduleData['company']=='SES'):?>
                <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->cat_icon, '');
                if($file)
                $icon = $file->map(); ?>
                <i class="sesbasic_text_light"><img src="<?php echo ($category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
            <?php else : ?>
                <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/category-icon.png"></i>
            <?php endif;?>
        <?php } ?>
            <?php echo $category->getTitle();?>	
        </a>
        <ul>
            <?php //Subcategory Work
            if($moduleData['subCat']=='yes'){
                $subcategory = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubcategory(array('column_name' => "*", 'category_id' => $category->category_id)); 
                }
            ?>
            <?php $submenucounter = 0; foreach ($subcategory as $sub_category): ?>
                <?php if($menuItem->show_cat == $submenucounter || count($subcategory)) { ?>
                <?php break; } ?>
                    <li><a href="<?php echo $sub_category->getHref(); ?>">
                    <?php if($menuItem->show_icon) { ?>
                        <?php if($moduleData['company']=='SES'):?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($sub_category->cat_icon, '');
                            if($file)
                            $icon = $file->map(); ?>
                            <i class="sesbasic_text_light"><img src="<?php echo ($sub_category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
                        <?php else : ?>
                            <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/category-icon.png"></i>
                        <?php endif; ?>
                    <?php } ?>
                    <?php echo $sub_category->category_name; ?>
                    </a></li>
            <?php $submenucounter++; endforeach; ?>		
        </ul>
    </li>
	<?php $counter++; ?>
	<?php endforeach; ?>
<?php endif;?>

