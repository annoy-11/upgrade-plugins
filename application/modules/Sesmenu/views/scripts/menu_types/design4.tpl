<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: design4.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $menu_name = array('creation_date'=>'Recent','like_count'=>'Most liked','comment_count'=>'Most commented','view_count'=>'Most viewed','favourite_count'=>'Most Favourite','week'=>'This week','month'=>'This Month','rating'=>'This Rated'); ?>
<?php $tab_icon = array('creation_date'=>'fa fa-calendar-o','like_count'=>'fa fa-thumbs-up','comment_count'=>'fa fa-comments-o','view_count'=>'fa fa-eye','favourite_count'=>'fa fa-heart','week'=>'fa fa-calendar-o','month'=>'fa fa-calendar-o','rating'=>'This Rated');?>
<?php foreach(json_decode($menuItem->enabled_tab) as $tab_name) : ?>
	<li class="sesmenu_submenu_item sesmenu_category_menu_item">
	  <a href="javascript:;" class="sesmenu_hover_cnt" onmouseover="tabdata(this)"  data-tab ="<?php echo $tab_name; ?>" data-limit="<?php echo $menuItem->content_count; ?>" data-module="<?php echo $menuItem->module ?>" data-menu="<?php echo $menuItem->id ?>">
        <?php if($menuItem->show_icon) { ?>
            <i class="<?php echo $tab_icon[$tab_name]; ?>"></i>
         <?php } ?>
        <?php echo $menu_name[$tab_name]; ?>
	  </a>
	  <ul id="<?php echo $tab_name."-".$menuItem->module; ?>-content">
	  </ul>
	</li>
<?php endforeach;?>

