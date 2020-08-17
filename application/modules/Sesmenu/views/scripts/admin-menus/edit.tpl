<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: edit.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesmenu/views/scripts/dismiss_message.tpl';?>

<div class="sesbasic_search_result"><?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesmenu', 'controller' => 'menus', 'action' => 'index'), "Back to Manage Categories", array('class'=>'sesbasic_icon_back buttonlink')) ?></div>
<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>
window.addEvent('domready',function(){
	<?php if(empty($this->menuItem->design_cat)){ ?>
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
		$('show_icon-wrapper').style.display = 'none';
	<?php }else {?>
		designselector('<?php echo $this->menuItem->design_cat; ?>');
		designSettings('<?php echo $this->menuItem->design; ?>');
	<?php }?>
});
function designselector(value) {
	if(value == 0) {
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
	} else if(value == 1) {
		
		$('category_design-wrapper').style.display = 'block';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
	}else if(value == 2) {
		
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'block';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
	} 
	else if(value == 3) {
		
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'block';
		$('normal_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
	}
	else if(value == 4) {
		
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'block';
		$('submenu_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
	} 
	else if(value == 5) {
		
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'block';
    $('custom_design-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
    $('enabled_tab-wrapper').style.display = 'none';
	} 
	else if(value == 6) {
		
		$('category_design-wrapper').style.display = 'none';
		$('content_design-wrapper').style.display = 'none';
		$('module_design-wrapper').style.display = 'none';
		$('normal_design-wrapper').style.display = 'none';
		$('submenu_design-wrapper').style.display = 'none';
		$('custom_design-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
		$('show_icon-wrapper').style.display = 'none';
			$('enabled_tab-wrapper').style.display = 'none';
	} 
}

function designSettings(value) {
	if(value == 0) {
    $('show_cat-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
    $('show_cat-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'none';
	}else if(value == 1) {
		$('show_cat-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'block';
		$('emptyfeild-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'block';
			
	} else if(value == 2) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
		$('enabled_tab-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'block';
	} else if(value == 3) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'block';
	} else if(value == 4) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'block';
     $('show_icon-wrapper').style.display = 'block';
	}  else if(value == 5) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'block';
	} else if(value == 6) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('show_cat-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'block';
	}  else if(value == 7) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'block';
     $('show_icon-wrapper').style.display = 'block';
	} else if(value == 8) {
    $('show_cat-wrapper').style.display = 'block';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'block';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'none';
	} else if(value == 9) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'none';
	} else if(value == 10) {
    $('show_cat-wrapper').style.display = 'none';
    $('show_count-wrapper').style.display = 'block';
		$('show_count-label').innerHTML= '<label for="show_count" class="optional">Do you want to show Categories in footer </label>';
		$('enabled_tab-wrapper').style.display = 'block';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'block';
     $('show_icon-wrapper').style.display = 'none';
	} else if(value == 11) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'block';
	} else if(value == 12) {
    $('show_cat-wrapper').style.display = 'block';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'block';
	} else if(value == 13) {
    $('show_cat-wrapper').style.display = 'block';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'block';
	} else if(value == 14) {
    $('show_cat-wrapper').style.display = 'block';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'block';
	} else if(value == 15) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'block';
     $('show_icon-wrapper').style.display = 'block';
	} else if(value == 16) {
    $('show_cat-wrapper').style.display = 'block';
		$('show_count-wrapper').style.display = 'block';
		$('show_count-label').innerHTML= '<label for="show_count" class="optional">Do you want to show Categories in footer </label>';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'block';
     $('show_icon-wrapper').style.display = 'none';
	} else if(value == 17) {
    $('show_cat-wrapper').style.display = 'block';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'block';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
     $('show_icon-wrapper').style.display = 'block';
	} 
	else if(value == 18) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'block';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'block';
    $('show_icon-wrapper').style.display = 'block';
	} 
		else if(value == 50) {
    $('show_cat-wrapper').style.display = 'none';
		$('show_count-wrapper').style.display = 'none';
		$('enabled_tab-wrapper').style.display = 'none';
		$('emptyfeild-wrapper').style.display = 'none';
		$('design5settings-wrapper').style.display = 'none';
		$('design8settings-wrapper').style.display = 'none';
		$('categories_count-wrapper').style.display = 'none';
		$('design8advertice-wrapper').style.display = 'none';
    $('content_count-wrapper').style.display = 'none';
    $('show_icon-wrapper').style.display = 'none';
	} 
}


</script>
