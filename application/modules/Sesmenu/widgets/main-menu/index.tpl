<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmenu
 * @package    Sesmenu
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-01-25 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
 <?php $settings = Engine_Api::_()->getApi('settings', 'core');
 if($settings->getSetting('sesmenu.menu.color')){
 
  ?>

<style>
.sesmenu_menu_four > li.active_tab > a,.sesmenu_menu_four > li > a:hover,.sesmenu_menu_five > li.active_tab > a,.sesmenu_menu_five > li > a:hover{
	background-color:#<?php echo  $settings->getSetting('sesmenu.content.bgcolor'); ?>;
}
.sesmenu_menu_four > li > a {
	border-bottom:1p solid #<?php echo  $settings->getSetting('sesmenu.content.bgcolor'); ?>;
}
.sesmenu_main_menu,.sesmenu_sidenav{
	background:#<?php echo  $settings->getSetting('sesmenu.menu.bgcolor'); ?>
}
.sesmenu_main_menu_inner > ul > li > a,.sesmenu_mobile_menu ul li a,.sesmenu_sidenav .closebtn,.sesmenu_mobile_menu .change-icon{
	color:#<?php echo  $settings->getSetting('sesmenu.font.color'); ?>;
}
.sesmenu_main_menu_inner > ul > li:hover > a,
.sesmenu_main_menu_inner > ul > li.active > a{
	color:#<?php echo  $settings->getSetting('sesmenu.font.hover.color'); ?>;
	background:#<?php echo  $settings->getSetting('sesmenu.hover.color'); ?>;
}
.sesmenu_submenu{
	background-color:#<?php echo  $settings->getSetting('sesmenu.content.bgcolor'); ?>;
	border-bottom:4px solid #<?php echo  $settings->getSetting('sesmenu.menu.bgcolor'); ?>;
}
.sesmenu_submenu li a{
	color:#<?php echo  $settings->getSetting('sesmenu.content.ftcolor'); ?>;
}
.sesmenu_menu_four > li > a:hover,.sesmenu_menu_four > li.active_tab > a,.sesmenu_menu_six li a:hover,.sesmenu_menu_five > li > a:hover,.sesmenu_menu_five > li.active_tab > a,.sesmenu_menu_two > li > a:hover,.sesmenu_menu_six li a:hover, .sesmenu_menu_seventeen li a:hover{
	color:#<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?>;
	border-left:4px solid #<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?>;
}
.sesmenu_standard_menu_item ul li a:hover{
	border-left:4px solid #<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?>;
}
.sesmenu_menu_seven ._left ._img_overlay  ._cat,.sesmenu_menu_seven ._right ._img_overlay  ._cat,.sesmenu_otd_item .product_cont .rating,.sesmenu_standard_menu_item ul li a:hover,.sesmenu_tabs > ul > li > a:hover, .sesmenu_tabs > ul > li.active > a, .sesmenu_tabs > ul > li > a.active,.sesmenu_categories_strip > ul > li > a:hover,.sesmenu_tabs > ul > li.active_tab > a{
	background:#<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?>;
	color:#<?php echo  $settings->getSetting('sesmenu.content.highlight.ftcolor'); ?> !important;
}
.sesmenu_tabs > ul > li > a:hover:before,
.sesmenu_tabs > ul > li.active > a:before,
.sesmenu_tabs > ul > li > a.active:before,
.sesmenu_tabs > ul > li.active_tab > a:before{
	border-top:6px solid #<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?>;
}
.sesmenu_menu_seven ._right ._img_overlay ._title{
	color:#<?php echo  $settings->getSetting('sesmenu.content.ftcolor'); ?>;
}
.sesmenu_items_carousel_inner .owl-nav > div{
	background:#<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?>;
}
.sesmenu_items_carousel_inner .owl-nav > div i:before,.sesmenu_standard_menu_item ul li a:hover i{
	color:#<?php echo  $settings->getSetting('sesmenu.content.highlight.ftcolor'); ?>;
}
.sesmenu_three_items ._cont ._price,.sesmenu_otd_item .product_cont ._price,.sesmenu_submenu li a:hover{
	color:#<?php echo  $settings->getSetting('sesmenu.content.highlight.color'); ?> !important;
}
.sesmenu_mobile_menu .mobile_second_level li:before,.sesmenu_mobile_menu .mobile_third_level li:before{
	border-left: 1px dashed #<?php echo  $settings->getSetting('sesmenu.font.color'); ?>;
}
.sesmenu_mobile_menu .mobile_second_level li:before,.sesmenu_mobile_menu .mobile_third_level li:before {
	border-right: 1px dashed #<?php echo  $settings->getSetting('sesmenu.font.color'); ?>;
}
.sesmenu_mobile_menu .mobile_second_level li:after,.sesmenu_mobile_menu .mobile_third_level li:after{
	border-bottom: 1px dashed #<?php echo  $settings->getSetting('sesmenu.font.color'); ?>;
}
.sesmenu_mobile_menu .mobile_second_level li a:before,.sesmenu_mobile_menu .mobile_third_level li a:before,.sesmenu_sidenav > ul > li > a:before,.sesmenu_panel_top_section_options ul li a:before{
	background-color: #<?php echo  $settings->getSetting('sesmenu.font.color'); ?>;
}
.sesmenu_menu_six .sesmenu_level_2, .sesmenu_menu_six .sesmenu_level_3, .sesmenu_menu_seventeen .sesmenu_level_2,.sesmenu_menu_four > li > ul{
	background:#<?php echo  $settings->getSetting('sesmenu.content.bgcolor'); ?>;
}
</style>
<?php } ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmenu/externals/styles/styles.css'); ?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesmenu/externals/scripts/owl.carousel.js'); ?>
<?php $designIdName=array('','one','two','three','four','five','six','seven','eight','nine','ten','eleven','twelve','twelve','six','four','ten','seventeen','six');?>
<?php $coreApiTable =  Engine_Api::_()->getApi("settings","core");?>
<?php $isShowMenu =  $coreApiTable->getSetting('sesmenu.plugin.enable',1);?>
<?php $moreTabcContent =  $coreApiTable->getSetting('sesmenu.plugin.more.content',7); ?>
<?php $viewer = Engine_Api::_()->user()->getViewer();
?>
<?php $countMenu = 0;?>
<div class="sesmenu_main_menu sesbasic_bxs sesbasic_clearfix">
  <div class="sesmenu_main_menu_inner">
    <ul class="sesmenu_main_menu_items">
      <?php foreach($this->navigation as $navigationMenu): ?>
        <?php $explodedString = explode(' ', $navigationMenu->class); ?>
        <?php if( $countMenu < $moreTabcContent ): ?>
          <?php $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $navigationMenu->menu_id);?>
            <li data-id="<?php echo $navigationMenu->menu_id; ?>" data-design="<?php echo $menuItem->design; ?>" class="sesmenu_main_menu_<?php echo $designIdName[$menuItem->design];?> <?php echo $navigationMenu->get('active') ? 'active' : '' ?>">
                <?php if(end($explodedString)== 'core_main_invite'):?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
                <?php elseif(end($explodedString)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
                    <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
                <?php else:?>
                    <a href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>' class="<?php echo $navigationMenu->getClass() ? ' ' . $navigationMenu->getClass() : ''?>  selected_tab" <?php if( $navigationMenu->get('target') ): ?> target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?> id="menuId_<?php echo $navigationMenu->menu_id; ?>" data-design ="<?php echo $menuItem->design; ?>" <?php if($menuItem->design):?> onclick ="designChanger('<?php echo $navigationMenu->menu_id; ?>')" <?php endif; ?> >
                <?php endif;?>
                <?php if($settings->getSetting('sesmenu.menu.style') == 0) { ?>
                    <i class="fa <?php //echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
                    <?php echo $this->translate($navigationMenu->getlabel()) ?>
                    <?php }else if ($settings->getSetting('sesmenu.menu.style') == 1) { ?>
                        <i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
                    <?php }else if ($settings->getSetting('sesmenu.menu.style') == 2) { ?>
                        <i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
                        <?php echo $this->translate($navigationMenu->getlabel()) ?>
                    <?php } ?>
                </a>
                <?php if($isShowMenu) { ?>
                    <?php if($menuItem->design && in_array($menuItem->design, array('4', '10')) && !empty($menuItem->enabled_tab)):?>
                    <ul class="sesmenu_submenu sesmenu_menu_<?php echo $designIdName[$menuItem->design];?>" id="designerContainer_<?php echo $navigationMenu->menu_id; ?>"></ul>
                    <?php elseif($menuItem->design && !in_array($menuItem->design, array('4', '10'))): ?>
                        <ul class="sesmenu_submenu sesmenu_menu_<?php echo $designIdName[$menuItem->design];?>" id="designerContainer_<?php echo $navigationMenu->menu_id; ?>"></ul>
                    <?php endif; ?>
                <?php } ?> 
            </li>
        <?php else:?>
            <?php break;?>
        <?php endif;?>
        <?php $countMenu++;?>
      <?php endforeach; ?>
      <?php if(count($this->navigation) > ($moreTabcContent)) : ?>
        <?php $countMenu = 0; ?>
        <li class="more_tab">
          <a class="menu_core_main core_menu_more" href="javascript:void(0);">
            <span><?php echo $this->translate($this->moretext);?> + </span>
          </a>
          <ul class="sesmenu_submenu">
            <?php foreach($this->navigation as $navigationMenu): ?>
              <?php $explodedString = explode(' ', $navigationMenu->class); ?>
              <?php if ($countMenu >= $moreTabcContent): ?>
                <?php $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $navigationMenu->menu_id); ?>
                <li class="sesmenu_main_menu_item <?php echo $navigationMenu->get('active') ? 'active' : '' ?>">
                  <a href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>' class="<?php echo $navigationMenu->getClass() ? ' ' . $navigationMenu->getClass() : ''?>"
                    <?php if( $navigationMenu->get('target') ): ?> target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?>><i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i>
                    <?php echo $this->translate($navigationMenu->getlabel()) ?>
                  </a>
                </li>
              <?php endif;?>
              <?php $countMenu++;?>
            <?php endforeach; ?>
          </ul>
        </li>
      <?php endif;?>
    </ul>
  </div>
  
  <div class="sesmenu_mobile_menu">
    <div class="sesmenu_mobile_toggle">
        <a class="sesmenu_toggle_btn" onclick="showMenu();"><i class="fa fa-bars"></i></a>
    </div>
    <div class="sesmenu_mobile_overlay">
        <a class="sesmenu_toggle_btn" onclick="hideSidePanel();"></a>
    </div>
     <div class="sesmenu_sidenav" id="show_mob_menu">
      <?php if($this->viewer()->getIdentity() != 0){ ?>
      <div class="sesmenu_panel_top_section clearfix" style="background-image:url(<?php echo $this->menuinformationimg; ?>);">
        <div class="sesmenu_panel_top_section_img">
        	<?php echo $this->htmlLink($this->viewer()->getHref(), $this->itemPhoto($this->viewer(), 'thumb.icon')) ?>
        </div>
        <div class="sesmenu_panel_top_section_name">
        	<span><?php echo $this->viewer()->getTitle(); ?></span>
          <a href="javascript:void(0);" class="sesmenu_panel_top_section_btn" onclick="showHideInformation('sesmenu_information');"><i class="fa fa-angle-down" id="down_arrow"></i><i id="uparrow" class="fa fa-angle-up" style="display:none;"></i></a>
        </div>
        <div class="sesmenu_panel_top_section_options clearfix" style="display:none;" id="sesmenu_information">
       		  <?php // This is rendered by application/modules/core/views/scripts/_navIcons.tpl
              echo $this->navigation()->menu()->setContainer($this->homelinksnavigation)->setPartial(array('_navIcons.tpl', 'core'))->render();
            ?>
        </div>   
    	</div>
    <?php } ?>
     <a class="closebtn" onclick="hideSidePanel();">&times;</a>
     <?php $menucounter = 0; ?>
       <?php foreach($this->navigation as $navigationMenu) { ?>
     <ul class="mobile_first_level">
            <?php if($menucounter == $moreTabcContent) { ?>
            <?php break; } ?>
        <?php $explodedString = explode(' ', $navigationMenu->class); ?>
       <?php $menuItem = Engine_Api::_()->getItem('sesmenu_menuitem', $navigationMenu->menu_id); ?>
        <li class="open-second-level">
             <?php $apiTable = Engine_Api::_()->getApi('core', 'sesmenu');?>
            <?php if($menuItem->design_cat == 1) {  ?>
                <?php  $secondLevelData = $apiTable->getCategories($menuItem->module); ?>
                <?php if(count($secondLevelData) > 0) { ?>
                    <i class="fa fa-angle-right change-icon"></i>
                <?php } ?>
            <?php } ?>
             <?php if($menuItem->design_cat == 5) {  ?>
                <?php $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($menuItem->module.'_main'); 
                ?>
                <?php if(count($subMenus)) { ?>
                    <i class="fa fa-angle-right change-icon"></i>
                <?php } ?>
            <?php } ?>
            <?php if(end($explodedString)== 'core_main_invite'):?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
            <?php elseif(end($explodedString)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
            <?php else:?>
                <a href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>' class="<?php echo $navigationMenu->getClass() ? ' ' . $navigationMenu->getClass() : ''?>  selected_tab" <?php if( $navigationMenu->get('target') ): ?> target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?>  >
            <?php endif;?>
            <span><i class="fa <?php echo $navigationMenu->get('icon') ? $navigationMenu->get('icon') : 'fa-star' ?>"></i></span>
              <span><?php echo $this->translate($navigationMenu->getlabel()) ?></span>
            </a>
            
            <ul class="mobile_second_level">
                <?php if($menuItem->design_cat == 1) {  ?>
                    <?php  ?>
                    <?php if(count($secondLevelData) > 0) {  ?>
                    <?php $counter = 0; ?>
                    <?php foreach($secondLevelData as $menuData) { ?>
                        <?php if($menuItem->categories_count == $counter) { ?>
                        <?php break; } ?>
                        <li class="open-third-level">
                            <a href="<?php echo $menuData->getHref(); ?>">
                                <?php echo $menuData->getTitle(); ?>
                            </a>
                            <?php   if($moduleData['subCat']=='yes'){
                                $thirdLevelData = Engine_Api::_()->getDbtable('categories', $menuItem->module)->getModuleSubcategory(array('column_name' => "*", 'category_id' => $menuData->category_id)); 
                            } ?>
                            <?php if(count($thirdLevelData)) { ?>
                                <i class="fa fa-angle-right change-icon sesmenu_first_level"></i>
                            <?php } ?>
                            <ul class="mobile_third_level">
                                <?php $thirdLevelCounter = 0; ?>
                                <?php foreach($thirdLevelData as $thirdmenuData) { ?>
                                    <?php if($menuItem->categories_count == $thirdLevelCounter) { ?>
                                    <?php break; } ?>
                                    <li><a href="<?php echo $thirdmenuData->getHref(); ?>">	<?php echo $thirdmenuData->category_name; ?></a></li>
                                <?php $thirdLevelCounter++; } ?>
                            </ul>
                        </li>
                    <?php $counter++; } ?>
                    <?php } ?>
                <?php }else if($menuItem->design_cat == 5) {  ?>
                    <?php $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($menuItem->module.'_main'); 
                    ?>
                    <?php if(count($subMenus)) { ?>
                        <?php $subMenusCounter = 0; ?>
                        <?php foreach($subMenus as $subMenu) { ?>
                        <?php if($menuItem->categories_count == $subMenusCounter) { ?>
                            <?php break; } ?>
                        <li class="open-third-level">
                            <a href="<?php echo $subMenu->getHref(); ?>" >
                                <?php echo $this->translate($subMenu->getLabel()); ?>
                            </a>
                            
                            <ul class="mobile_third_level">
                            </ul>
                        </li>
                        <?php $subMenusCounter++; } ?>
                    <?php } ?>
                <?php } ?>
            </ul>
        </li>
    </ul>
    <?php  $menucounter++; } ?>
    </div>
  </div>
</div>  
<script>
	function showHideInformation( id) {
    if($(id).style.display == 'block') {
      $(id).style.display = 'none';
			$('down_arrow').style.display = 'block';
			$('uparrow').style.display = 'none';
    } else {
      $(id).style.display = 'block';
			$('down_arrow').style.display = 'none';
			$('uparrow').style.display = 'block';
    }
	}
</script>
<script>
var getSelectedMenuItem;
var getCurrentElementLi;
sesJqueryObject('.sesmenu_main_menu_items > li').on('mouseover',function(e){
        if(typeof getSelectedMenuItem == "undefined" || getSelectedMenuItem == ""){
            getSelectedMenuItem = sesJqueryObject('.sesmenu_main_menu_items').find('.active');
        }
        sesJqueryObject('.sesmenu_main_menu_items').find('.active').removeClass('active');
        sesJqueryObject(this).addClass("active");
        getCurrentElementLi = sesJqueryObject(this);
 });

	sesJqueryObject(document).mousemove(function(e){
       var currentElement = sesJqueryObject(e.target);
       if(typeof getSelectedMenuItem != "undefined" && getSelectedMenuItem != "" && getCurrentElementLi.has(sesJqueryObject(e.target)).length){
        //silence
       }else if(typeof getSelectedMenuItem != "undefined" && getSelectedMenuItem != ""){
         sesJqueryObject('.sesmenu_main_menu_items').find('.active').removeClass('active');
         sesJqueryObject(getSelectedMenuItem).addClass("active");
         getSelectedMenuItem = undefined;
       }  
     });		
    window.addEvent('domready',function(){
        sesJqueryObject('.sesmenu_main_menu_items').children().each(function(e){
            if(!sesJqueryObject(this).hasClass('more_tab') && <?php echo $isShowMenu; ?>)
                designChanger(sesJqueryObject(this).data('id'));
        })
    });
    window.addEvent('domready',function(){
    sesJqueryObject('.sesmenu_main_menu_items').find(".selected_tab").on('mouseover',function(e){
            if(sesJqueryObject(this).parents("li").data('design')==15){
                categoriesData(sesJqueryObject(this).parents("li").children("ul").children("li:first").children("a"));
            }
            if(sesJqueryObject(this).parents("li").data('design')== 4){
                tabdata(sesJqueryObject(this).parents("li").children("ul").children("li:first").children("a"));
            }
            if(sesJqueryObject(this).parents("li").data('design')==16){
               selectedCatData(sesJqueryObject(this).parents("li").find(".sesbasic_filter_tabs ul li:first"));
            }
            if(sesJqueryObject(this).parents("li").data('design')==10){
                selectedTabData(sesJqueryObject(this).parents("li").find(".sesbasic_filter_tabs ul li:first"));
            }
            if(sesJqueryObject(this).parents("li").data('design')==5){
                subMenus(sesJqueryObject(this).parents("li").children("ul").children("li:first").children("a"));
            }
        });
        sesJqueryObject('.menu_core_main').children().on('mouseout',function(e){
        
        });
    });
    
var requestTabDesign4;
function tabdata(design4)
{
    sesJqueryObject(design4).parents(".sesmenu_submenu").find('ul').hide();
    sesJqueryObject(design4).closest('ul').find('.active_tab').removeClass('active_tab');
    sesJqueryObject(design4).parent().addClass("active_tab");
    
    var tab_id = sesJqueryObject(design4).data('tab');
    var module_name =  sesJqueryObject(design4).data('module');
    var menuid =  sesJqueryObject(design4).data('menu');
    var limit =  sesJqueryObject(design4).data('limit');
    sesJqueryObject("#"+tab_id+"-"+module_name+"-content").css("display","block");
    if(typeof sesJqueryObject(design4).data('loadded') != "undefined"){
        return;
    }
    sesJqueryObject("#"+tab_id+"-"+module_name+"-content").html("<img src='application/modules/Sesmenu/externals/images/loading.gif' class='sesmenu_loader'>");
    
    if(typeof requestTabDesign4 != "undefined"){
        requestTabDesign4.cancel();
    }
	
	requestTabDesign4 = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesmenu/index/get-content-data/',
	  'data': {
		tab_id: tab_id,
		limit :limit,
		module_name :module_name,
		menuid :menuid,
		isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
        sesJqueryObject(design4).attr('data-loadded',"true");
		sesJqueryObject("#"+tab_id+"-"+module_name+"-content").html(responseHTML);
	  }
	})).send();
}   

var requestTabDesign5;
function subMenus(design5)
{	
    sesJqueryObject(design5).closest('ul').find("ul").hide();
    sesJqueryObject(design5).closest('ul').find('.active_tab').removeClass('active_tab');
    sesJqueryObject(design5).parent().addClass("active_tab");
   
    var submenuid = sesJqueryObject(design5).data('submenu');
    var module_name =  sesJqueryObject(design5).data('module');
    var menuId =  sesJqueryObject(design5).data('menuid');
    sesJqueryObject("#container-"+submenuid+"-"+module_name+"-data").show();
     
	if(typeof sesJqueryObject(design5).data('loaded') != "undefined"){
        return;
	}

	sesJqueryObject("#container-"+submenuid+"-"+module_name+"-data").html("<img src='application/modules/Sesmenu/externals/images/loading.gif' class='sesmenu_loader'>");
	if(typeof requestTabDesign5 != 'undefined'){
		requestTabDesign5.cancel();
	}
	requestTabDesign5 = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesmenu/index/get-submenu-data/',
	  'data': {
		module_name :module_name,
		submenuid :submenuid,
		menuId :menuId,
		isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        sesJqueryObject(design5).attr('data-loaded',"true");
        sesJqueryObject("#container-"+submenuid+"-"+module_name+"-data").html(responseHTML);
	  }
	})).send();
}

var requestTabDesign10;
function selectedTabData(design10)
{   
    sesJqueryObject(".sesmenu_tabs_content > ul").hide();
    sesJqueryObject(design10).parents('ul').find('.active_tab').removeClass('active_tab');
    sesJqueryObject(design10).addClass("active_tab");
    var tab_id = sesJqueryObject(design10).data('tab');
    var modulename =  sesJqueryObject(design10).data('modulename');
    var menuid =  sesJqueryObject(design10).data('menu');
    var limit =  sesJqueryObject(design10).data('limit');
    sesJqueryObject("#"+tab_id+"-"+modulename+"-content-data").show();
    if(typeof sesJqueryObject(design10).data('loadded') != "undefined"){
        return;
    }
    
	sesJqueryObject("#"+tab_id+"-"+modulename+"-content-data").html("<img src='application/modules/Sesmenu/externals/images/loading.gif' class='sesmenu_loader'>");
	if(typeof requestTabDesign10 != "undefined"){
	  requestTabDesign10.cancel();
	}
	requestTabDesign10 = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesmenu/index/get-content-data/',
	  'data': {
		tab_id : tab_id,
		limit :limit,
		module_name :modulename,
		menuid :menuid,
		tabdata : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
		sesJqueryObject("#"+tab_id+"-"+modulename+"-content-data").html(responseHTML);
		sesJqueryObject(design10).attr('data-loadded',"true");
	  }
	})).send();
}

var requestTabDesign15;
function categoriesData(design15)
{	
    sesJqueryObject(design15).closest('ul').find("ul").hide();
    sesJqueryObject(design15).closest('ul').find('.active_tab').removeClass('active_tab');
    sesJqueryObject(design15).parent().addClass("active_tab");
    var category_id = sesJqueryObject(design15).data('catid');
    var module_name =  sesJqueryObject(design15).data('modulename');
    var menuid =  sesJqueryObject(design15).data('menuid');
    var limit =  sesJqueryObject(design15).data('catlimit');
    
    sesJqueryObject("#"+module_name+"_"+category_id+"_content_tab_data").show();
    if(typeof sesJqueryObject(design15).data('loadded') != "undefined"){
        return;
    }
    
	sesJqueryObject("#"+module_name+"_"+category_id+"_content_tab_data").html("<img src='application/modules/Sesmenu/externals/images/loading.gif' class='sesmenu_loader'>");
	
    if(typeof requestTabDesign15 != "undefined"){
        requestTabDesign15.cancel();
    }
    requestTabDesign15 = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesmenu/index/get-content-data/',
	  'data': {
		category_id : category_id,
		limit :limit,
		module_name :module_name,
		menuid :menuid,
		isAjax : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
		sesJqueryObject("#"+module_name+"_"+category_id+"_content_tab_data").html(responseHTML);
        sesJqueryObject(design15).attr('data-loadded',"true");
	  }
	})).send();
}

var requestTabDesign16;
function selectedCatData(design16)
{	
    sesJqueryObject(".sesmenu_tabs_content > ul").hide();
    sesJqueryObject(design16).parents("ul").find('.active_tab').removeClass('active_tab');
    sesJqueryObject(design16).addClass("active_tab");
    var tab_id = sesJqueryObject(design16).data('tab');
    var modulename =  sesJqueryObject(design16).data('modulename');
    var menuid =  sesJqueryObject(design16).data('menu');
    //var limit =  sesJqueryObject(design16).data('limit');
    sesJqueryObject("#catContainer-"+tab_id+"-"+modulename+"-data").show();
    if(typeof sesJqueryObject(design16).data('loadded') != "undefined"){
        return;
    }
	sesJqueryObject("#catContainer-"+tab_id+"-"+modulename+"-data").html("<img src='application/modules/Sesmenu/externals/images/loading.gif' class='sesmenu_loader'>");

	if(typeof requestTabDesign16 != 'undefined'){
		requestTabDesign16.cancel();
	}
	requestTabDesign16 = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesmenu/index/get-category-data/',
	  'data': {
		category_id: tab_id,
		module_name :modulename,
		menuid :menuid,
		tabdata : 1,
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) { 
    sesJqueryObject(design16).attr('data-loadded',"true");
		sesJqueryObject("#catContainer-"+tab_id+"-"+modulename+"-data").html(responseHTML);
	  }
	})).send();
}
var requestTabChanger;
function designChanger(menu_id)
{
	sesJqueryObject("#designerContainer_"+menu_id).html("<img src='application/modules/Sesmenu/externals/images/loading.gif' class='sesmenu_loader'>");
	if(typeof requestTabChanger != 'undefined'){
	  //requestTabChanger.cancel();
	}
	requestTabChanger = (new Request.HTML({
	  method: 'post',
	  format: 'html',
	  'url': en4.core.baseUrl + 'sesmenu/index/index/',
	  'data': {
		menu_id: menu_id,
		is_ajax : 1,
		
	  },
	  onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {			  
	  if(responseHTML.length == 6) { 
     sesJqueryObject("#designerContainer_"+menu_id).remove();
     return false;
    }
		sesJqueryObject("#designerContainer_"+menu_id).html(responseHTML);
		sesJqueryObject("#designerContainer_"+menu_id).removeAttr("onmouseover");
		
        if(sesJqueryObject("#menuId_"+menu_id).data('design') == '8') {
            sesJqueryObject('.sesmenu_items_carousel_inner').owlCarousel({
                nav : true,
                loop:true,
                items:1,
            })
            sesJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
            sesJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
        }
	  }
	})).send();
}

</script>
<script>
function showMenu() {
    if(document.getElementById('show_mob_menu').style.display != 'block') {
        sesJqueryObject(document.body).addClass("sesmenu-open-design");
    }
  }
	function hideSidePanel() {
      sesJqueryObject(document.body).removeClass("sesmenu-open-design");
  }

/* Set the width of the side navigation to 250px */
//function openNav() {
//  document.getElementById("mySidenav").style.width = "250px";
//}

/* Set the width of the side navigation to 200px */
//function closeNav() {
//  document.getElementById("mySidenav").style.width = "0";
//}

    sesJqueryObject(document).ready(function(){
    sesJqueryObject('.mobile_first_level > li > i').click(function(e){
    var parent = sesJqueryObject(this).parent().find('.mobile_second_level');
    console.log(parent.children().length);
        if(parent.children().length > 0){
        if(parent.hasClass('open')){
            sesJqueryObject(this).removeClass('fa-angle-up').addClass('fa-angle-right');
            parent.removeClass('open');
            e.preventDefault();
            parent.slideUp();
        }else{
            sesJqueryObject(this).removeClass('fa-angle-right').addClass('fa-angle-up');
            parent.addClass('open');
            e.preventDefault();
            parent.slideDown();
        }
        }
    });
	sesJqueryObject(".sesmenu_first_level").click(function(e){
    var parent = sesJqueryObject(this).next();
    if(parent.children().length > 0){
    if(parent.hasClass('open')){
        sesJqueryObject(this).removeClass('fa-angle-up').addClass('fa-angle-right');
        parent.removeClass('open');
        e.preventDefault();
        parent.slideUp();
    }else{
        sesJqueryObject(this).removeClass('fa-angle-right').addClass('fa-angle-up');
        parent.addClass('open');
        e.preventDefault();
        parent.slideDown();
     }
    }
  });
});
</script>
<script type="application/javascript">
  sesJqueryObject('.sesmenu_items_carousel_inner').owlCarousel({
    nav : true,
    loop:true,
    items:1,
  })
  sesJqueryObject(".owl-prev").html('<i class="fa fa-angle-left"></i>');
  sesJqueryObject(".owl-next").html('<i class="fa fa-angle-right"></i>');
</script>

