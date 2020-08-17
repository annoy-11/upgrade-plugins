<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design10.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $menu_name = array('creation_date'=>'Recent','like_count'=>'Most liked','comment_count'=>'Most commented','view_count'=>'Most viewed','favourite_count'=>'Most Favourite','week'=>'This week','month'=>'This Month');?>
<li class="sesmenu_submenu_item sesmenu_category_menu_item">
  <div class="sesmenu_tabs sesbasic_filter_tabs sesbasic_clearfix"> 
    <ul class="sesbasic_clearfix">
        <?php foreach(json_decode($menuItem->enabled_tab) as $tab_name) : ?>
                <li  data-tab ="<?php echo $tab_name; ?>"  data-limit="<?php echo $menuItem->content_count; ?>"        
                data-modulename="<?php echo $menuItem->module; ?>" data-menu="<?php echo $menuItem->id; ?>" onmouseover="selectedTabData(this)">
                <a href="javascript:void(0);"><?php echo $menu_name[$tab_name]; ?></a>
                </li>
        <?php endforeach;?>
    </ul>
  </div>
  <div class="sesbasic_tabs_content sesbasic_clearfix">
     <div class="sesmenu_tabs_content">
        <?php foreach(json_decode($menuItem->enabled_tab) as $tab_name) : ?>
            <ul class="sesmenu_tabs_content_inner" id="<?php echo $tab_name."-".$menuItem->module; ?>-content-data">
            </ul>
        <?php endforeach;?>
     </div>
  </div>	
  <?php if($menuItem->show_count) { ?>
    <div class="sesmenu_categories_strip">
            <?php include APPLICATION_PATH .  '/application/modules/Sesmenu/views/scripts/category_strip.tpl'; ?>
    </div>
  <?php } ?>
</li>

