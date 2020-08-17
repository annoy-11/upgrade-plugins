<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design15.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
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
  <?php $counter = 0; ?>
  <?php foreach($categories as $category) : ?>
    <?php if($counter == $menuItem->content_count) { ?>
      <?php break; } ?>
        <li class="sesmenu_submenu_item sesmenu_category_menu_item">
          <a href="<?php echo $category->getHref(); ?>" class=".sesmenu_hover_cnt" onmouseover="categoriesData(this)" data-catid="<?php echo $category->category_id; ?>" data-catlimit="<?php echo $menuItem->content_count; ?>" data-modulename="<?php echo $menuItem->module; ?>" data-menuid="<?php echo $menuItem->id;?>">
           
              <?php if($menuItem->show_icon) { ?>
                  <?php if($moduleData['company']=='SES'):?>
                  <?php $file = Engine_Api::_()->getItemTable('storage_file')->getFile($category->cat_icon, '');
                  if($file)
                  $icon = $file->map(); ?>
                  <i class="sesbasic_text_light"><img src="<?php echo ($category->cat_icon != 0 ? $icon : './application/modules/Sesmenu/externals/images/category-icon.png');?>"></i>
              <?php else : ?>
                  <i class="sesbasic_text_light"><img src="application/modules/Sesmenu/externals/images/category-icon.png"></i>
              <?php endif;?>
              <?php } ?>
            
            <?php echo $category->getTitle(); ?>
          </a>
          <ul id="<?php echo $menuItem->module; ?>_<?php echo $category->category_id; ?>_content_tab_data">
          </ul>
        </li>
  	<?php $counter++; ?>
  <?php endforeach;?>
<?php endif; ?>
