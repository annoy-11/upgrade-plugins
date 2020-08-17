<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design1.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $categories  =$apiTable->getCategories($menuItem->module); ?>
<?php if(!count($categories)):?>
<li class="no_content">
    <div class="sesbasic_tip">
        <img src="<?php echo $apiTable->contentNoFoundImg($menuItem) ; ?>">
        <span class="sesbasic_text_light"><?php echo $apiTable->contentNoFoundtxt($menuItem) ; ?></span>
    </div>
</li>
<?php else: ?>
    <?php $counter=0; foreach($categories as $category): ?>
        <?php if($counter == $menuItem->categories_count) {
                break ;
            }
        ?>
        <li class="sesmenu_submenu_item sesmenu_category_menu_item">
            <a href="<?php echo $category->getHref(); ?>">
            <?php if($moduleData['company']=='SES'):?>
                <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->thumbnail, '');
                    if($file)
                    $thumbnail = $file->map(); ?>
                    <div class="cat_img" style="background-image:url('<?php echo ($category->thumbnail != 0 ? $thumbnail : 'application/modules/Sesmenu/externals/images/default-category-thumb.png');?>');">
                <?php $category->thumbnail=0; $thumbnail=0; ?>
            <?php else : ?>
                <div class="cat_img" style="background-image:url('application/modules/Sesmenu/externals/images/default-category-thumb.png');"> 
            <?php endif;?>
            <div class="cat_img_overlay">
            <?php if(isset($category['category_name'])) { ?>
                <span class="cat_name">
                    <?php echo $category['category_name'];?>
                </span>
            <?php } else if(isset($category['title'])) { ?>
                <span class="cat_name">
                    <?php echo $category['title'];?>
                </span>
            <?php } ?>
                </span>
                <span class="cat_count">
                    <?php if($menuItem->show_count):?>
                        <?php $result = $apiTable->getContentCount($menuItem->module,$category['category_id']); ?> 
                        <?php echo $this->translate(array('%s '.$moduleData['content_title'], '%s '.$moduleData['content_title'].'s', $result), $this->locale()->toNumber($result)) ?>
                    <?php endif;?>
                </span>
            </div>
            </div>
            </a>
        </li>
    <?php $counter++; endforeach; ?>
<?php endif;?>
