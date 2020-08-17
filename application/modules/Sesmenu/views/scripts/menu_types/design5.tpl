<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design5.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $apiTable  = Engine_Api::_()->getApi('core', 'sesmenu');?>
<?php $categories = $apiTable->getCategories($menuItem->module); ?>
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
        <a href="<?php echo $category->getHref(); ?>" onmouseover="subMenus(this)" data-module ="<?php echo $menuItem->module; ?>" data-submenu="<?php echo $category->category_id;?>" data-menuid="<?php echo $menuItem->id;?>" >
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
            <?php echo $category->getTitle(); ?>
        </a>
        <ul id="container-<?php echo $category->category_id; ?>-<?php echo $menuItem->module;?>-data">
        </ul>
        <?php $counter++; ?>
        <?php endforeach; ?>
        <?php if(!empty($menuItem->first_photo) || !empty($menuItem->second_photo)){?>
            <div class="sesmenu_offer_banners">
                <?php if(!empty($menuItem->first_photo)){?>
                    <span class="_left"><a href="<?php echo $menuItem->photo1_link; ?>"><img src="<?php echo $menuItem->first_photo;?>" /></a></span>
                <?php } ?>
                <?php if(!empty($menuItem->second_photo)){?>
                    <span class="_right"><a href="<?php echo $menuItem->photo2_link; ?>"><img src="<?php echo $menuItem->second_photo;?>" /></a></span>
                <?php } ?>
            </div>
        <?php } ?>
    </li>
<?php endif;?>

