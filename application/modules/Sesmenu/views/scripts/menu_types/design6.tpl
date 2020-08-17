<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design6.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $categories  = $apiTable->getCategories($menuItem->module); ?>
<?php if(!count($categories)):?>
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
	<?php foreach($categories as $category): ?>
    <?php if($counter == $menuItem->categories_count) {
        break;
        }
    ?>
    <li class="sesmenu_submenu_item sesmenu_category_menu_item ">
    <a href="<?php echo $category->getHref(); ?>">
            <?php if($menuItem->show_icon) { ?>
                <?php if($moduleData['company']=='SES'): ?>
                    <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->cat_icon, '');
                    if($file)
                    $icon = $file->map(); ?>
                    <i class="sesbasic_text_light"><img src="<?php echo ($category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
                <?php else : ?>
                    <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/category-icon.png")"></i>
                <?php endif;?>
            <?php } ?>
            <?php echo $category->getTitle();?>	
            <?php //Subcategory Work
                if($moduleData['subCat']=='yes'){
                    $subcategory = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubcategory(array('column_name' => "*", 'category_id' => $category->category_id)); 
                }
            ?>
            <?php if(count($subcategory)>0) { ?>
                <span><i class="fa fa-angle-right"></i></span>
            <?php } ?>
        </a>
        <ul class="sesmenu_level_2 sesbasic_bg">
            <?php foreach ($subcategory as $sub_category): ?>
                <li>
                    <a href="<?php echo $sub_category->getHref(); ?>">
                        <?php if($moduleData['company']=='SES'):?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($sub_category->cat_icon, '');
                    if($file)
                    $icon = $file->map(); ?>
                    <i class="sesbasic_text_light"><img src="<?php echo ($sub_category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/icon.png');?>"></i>
                    <?php else : ?>
                    <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/icon.png"></i>
                        <?php endif; ?>
                        <?php echo $sub_category->category_name; ?>
                        <?php //SubSubcategory Work
                    
                                $subsubcategory = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $sub_category->category_id));  
                        ?>
                        <?php if(count($subsubcategory)>0) { ?>
                        <span><i class="fa fa-angle-right"></i></span>
                        <?php } ?>
                    </a>	
                    <ul class="sesmenu_level_3 sesbasic_bg">
                        <?php foreach ($subsubcategory as $subsub_category):  ?>
                            <li>
                                <a href="<?php echo $subsub_category->getHref(); ?>">				
                                <?php if($moduleData['company']=='SES'):?>
                            <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($subsub_category->cat_icon, '');
                            if($file)
                            $icon = $file->map(); ?>
                            <i class="sesbasic_text_light"><img src="<?php echo ($subsub_category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/icon.png');?>"></i>
                        <?php else : ?>
                            <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/icon.png"></i>
                            <?php endif; ?>
                                <?php echo $subsub_category->category_name; ?>
                            </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
	<?php $counter++; ?>
	<?php endforeach; ?>
<?php endif;?>
