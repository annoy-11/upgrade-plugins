<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design16.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $categories  = $apiTable->getCategories($menuItem->module); ?>
<li class="sesmenu_submenu_item sesmenu_category_menu_item">
  <div class="sesmenu_tabs sesbasic_filter_tabs sesbasic_clearfix"> 
    <ul class="sesbasic_clearfix">
		<?php $counter = 0; ?>
        <?php foreach($categories as $category) : ?>
            <?php if($counter == $menuItem->categories_count) { ?>
            <?php break; } ?>
            <li  data-tab ="<?php echo $category->category_id; ?>" data-design="<?php echo $menuItem->design; ?>"        
                data-modulename="<?php echo $menuItem->module; ?>" data-menu="<?php echo $menuItem->id; ?>" onmouseover="selectedCatData(this)">
                <a href="<?php echo $category->getHref(); ?>"><?php echo $category->getTitle(); ?></a>
            </li>
        <?php $counter++; ?>
        <?php endforeach;?>
     </ul>
  </div>
  <div class="sesbasic_tabs_content sesbasic_clearfix">
     <div class="sesmenu_tabs_content">
      <?php $counter = 0; ?>
        <?php foreach($categories as $category) : ?>
        <?php if($counter == $menuItem->categories_count) { ?>
        <?php break; } ?>
            <ul class="sesmenu_tabs_content_inner" id="catContainer-<?php echo $category->category_id; ?>-<?php echo $menuItem->module; ?>-data">

            </ul>
         <?php $counter++; ?>
    <?php endforeach;?>
     </div>
  </div>	
  <?php if($menuItem->show_count) { ?>
   <div class="sesmenu_categories_strip">
	  <?php include APPLICATION_PATH .  '/application/modules/Sesmenu/views/scripts/category_strip.tpl'; ?>
   </div>
  <?php } ?>
</li>

