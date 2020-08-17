<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: deisgn17.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $categories  = $apiTable->getCategories($menuItem->module); ?>
<?php if(!$categories):?>
	<li class="no_content">
        <div class="sesbasic_tip">
            <img src="<?php echo $apiTable->contentNoFoundImg($menuItem) ; ?>">
        <?php if(!empty($menuItem->emptyfeild_txt)){ ?> 
            <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($menuItem) ; ?></span>
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
                <?php //Subcategory Work 
                if($moduleData['subCat']=='yes'){
                        $subcategory = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubcategory(array('column_name' => "*", 'category_id' => $category->category_id)); 
                }
                ?>
            <?php if(count($subcategory)>0) { ?>
                <span><i class="fa fa-angle-right"></i></span>
            <?php } ?>
        </a>
        <?php if(count($subcategory)) { ?>
        <?php $subCategorycount =0 ;?>
            <ul class="sesmenu_level_2 sesbasic_bg">
                <?php foreach ($subcategory as $sub_category): ?>
                <?php if($this->menuItem->show_cat == $subCategorycount) { ?>
                <?php break; } ?>
                <li>
                    <a href="<?php echo $sub_category->getHref(); ?>">
                        <?php if($menuItem->show_icon) { ?>
                            <?php if($moduleData['company']=='SES'):?>
                                <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($sub_category->cat_icon, '');
                                if($file)
                                $icon = $file->map(); ?>
                                <i class="sesbasic_text_light"><img src="<?php echo ($sub_category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
                            <?php else : ?>
                            <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/category-icon.pngg"></i>
                            <?php endif; ?>
                        <?php } ?>
                        <?php echo $sub_category->category_name; ?>
                        <?php //SubSubcategory Work
                            $subsubcategory = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubsubcategory(array('column_name' => "*", 'category_id' => $sub_category->category_id));  
                        ?>
                        <?php if(count($subsubcategory)>0) { ?>
                            <span><i class="fa fa-angle-right"></i></span>
                        <?php } ?>
                    </a>	
                </li>
                <?php $subCategorycount++; endforeach; ?>
            </ul>
        <?php } ?>
    </li>
	<?php $counter++; ?>
	<?php endforeach; ?>
<?php endif;?>
