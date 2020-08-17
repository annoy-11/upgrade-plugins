<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design3.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
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
    <?php $counter=0; foreach($categories as $category):?>
        <?php if($counter == $menuItem->categories_count) {
            break ;
            }
        ?>
        <li class="sesmenu_submenu_item sesmenu_category_menu_item">
            <a href="<?php echo $category->getHref(); ?>">
                <?php if($menuItem->show_icon) { ?>
                    <?php if($moduleData['company']=='SES'):?>
                        <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->cat_icon, '');
                        if($file)
                        $icon = $file->map(); ?>
                        <span class="cat_img" style="background-image:url('<?php echo ($category->cat_icon != 0 ? $icon : 'application/modules/Sesmenu/externals/images/category-icon.png');?>');"></span>
                    <?php else : ?>
                        <span class="cat_img" style="background-image:url('application/modules/Sesmenu/externals/images/category-icon.png');"></span>
                    <?php endif; ?>
                <?php } ?>
                    <span class="cat_name">
                        <?php if(isset($category['category_name'])) { ?>
                            <?php echo $category['category_name'];?>
                        <?php } else if(isset($category['title'])) { ?>
                            <?php echo $category['title'];?>
                        <?php } ?>
                    </span>
                    <span class="cat_count sesbasic_text_light">
                        <?php if($menuItem->show_count):?>
                            <?php $result = $apiTable->getContentCount($menuItem->module,$category['category_id']); ?>
                            <?php echo $this->translate(array('%s '.$moduleData['content_title'], '%s '.$moduleData['content_title'].'s', $result), $this->locale()->toNumber($result)) ?>
                        <?php endif;?>
                    </span>
            </a>
        </li>
    <?php $counter++; endforeach; ?>
<?php endif; ?>
