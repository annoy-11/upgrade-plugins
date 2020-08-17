<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesytube
 * @package    Sesytube
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-02-01 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php 
$module_name = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
$action_name = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
$controller_name = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
?>
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
<div class="menu_left_panel" id="menu_left_panel">
	<div class="menu_left_panel_container mCustomScrollbar" data-mcs-theme="minimal-dark">
    <div class="menu_left_panel_nav_container sesbasic_clearfix">
      <ul class="menu_left_panel_nav clearfix">
        <?php foreach( $this->navigation as $navigationMenu ): ?>
          <?php 
            $explodedString = explode(' ', @$navigationMenu->class);
            $menuName = end($explodedString); 
            $moduleName = str_replace('core_main_', '', $menuName);
          ?>
          <?php $mainMenuIcon = Engine_Api::_()->sesytube()->getMenuIcon(end($explodedString));
              $activeMenuIcon = Engine_Api::_()->sesytube()->getActiveMenuIcon(end($explodedString));
          ?>
           <?php 
           if($this->submenu){
            $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($moduleName.'_main'); 
              $menuSubArray = $subMenus->toArray();
            }else
              $subMenus = array();
           ?>
          <li class="<?php if ($navigationMenu->active): ?>active<?php endif; ?> <?php if(count($subMenus) > 0): ?>toggled_menu_parant<?php endif; ?>">
            <?php if(end($explodedString)== 'core_main_invite'):?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
            <?php elseif(end($explodedString)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
            <?php else:?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $navigationMenu->getHref() ?>'>
            <?php endif;?>
              <?php if(!empty($mainMenuIcon) && empty($navigationMenu->active)):?>
                <?php $icon = $this->storage->get($mainMenuIcon, '');
                if($icon) { ?>
                <i class="menuicon" style="background-image:url(<?php echo $icon->getPhotoUrl(); ?>);"></i>
                <?php } ?>
              <?php elseif(!empty($activeMenuIcon) && !empty($navigationMenu->active)): ?>
                <?php $activeIcon = $this->storage->get($activeMenuIcon, '');
                if($activeIcon) { ?>
                <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($activeMenuIcon, '')->getPhotoUrl(); ?>);"></i>
                <?php } ?>
              <?php else: ?>
                <?php $icon = $this->storage->get($mainMenuIcon, '');
                if($icon) { ?>
                  <i class="menuicon" style="background-image:url(<?php echo $icon->getPhotoUrl(); ?>);"></i>
                <?php } ?>
              <?php endif;?>
              <?php if(count($subMenus) > 0): ?><i class="expcoll-icon sesytube_menu_main"></i><?php endif;?>
              <span><?php echo $this->translate($navigationMenu->label); ?></span>
            </a> 
            <?php if(count($subMenus) > 0 && $this->submenu): ?>
              <ul class="sesytube_toggle_sub_menu" style="display:none;">
                <?php 
                $counter = 0; 
                foreach( $subMenus as $subMenu): 
                $active = isset($menuSubArray[$counter]['active']) ? $menuSubArray[$counter]['active'] : 0;
                ?>
                  <li class="sesbasic_clearfix <?php echo ($active) ? 'selected_sub_main_menu' : '' ?>">
                      <a href="<?php echo $subMenu->getHref(); ?>" class="<?php echo $subMenu->getClass(); ?>">
                      <?php if($this->show_menu_icon):?><i class="fa fa-angle-right"></i><?php endif;?><span><?php echo $this->translate($subMenu->getLabel()); ?></span>
                    </a>
                  </li>
                <?php 
                $counter++;
                endforeach; ?>
              </ul>
            <?php endif; ?>            
          </li>
        <?php endforeach; ?>
      </ul>
      <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) { ?>
        <?php $getFollowChannel = Engine_Api::_()->getDbTable('chanelfollows', 'sesvideo')->getUserFollowChannel($this->viewer->getIdentity()); 
          if(count($getFollowChannel) > 0) {
          ?>
        <div class="clear menu_left_panel_section menu_left_panel_subscriptions">
          <div class="menu_left_panel_section_header">
            <a href="javascript:;" class="menu_left_panel_section_link">
              <i></i>
              <span><?php echo $this->translate("Subscriptions")?></span>
            </a>
          </div>
          
          <ul class="menu_left_panel_nav">
            <?php foreach($getFollowChannel as $item) {  ?>
              <?php $chanel = Engine_Api::_()->getItem('sesvideo_chanel', $item->chanel_id); ?>
              <li><a href="<?php echo $chanel->getHref(); ?>"><img src="<?php echo $chanel->getPhotoUrl('thumb.icon'); ?>" class="menuicon" /><span><?php echo $chanel->getTitle(); ?></span></a></li>
            <?php } ?>
          </ul>
        </div>
      <?php } } ?>
      
      <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('video') || Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesvideo')) { ?>
        <div class="clear menu_left_panel_section menu_left_panel_categories">
          <div class="menu_left_panel_section_header">
            <a href="javascript:;" class="menu_left_panel_section_link">
              <i></i>
              <span><?php echo $this->translate("Popular Categories")?></span>
            </a>
          </div>
          <ul class="menu_left_panel_nav">
          <?php foreach(Engine_Api::_()->sesytube()->getCategory(array('hasVideo' => true, 'videoDesc' => 'desc', 'limit' => 30)) as $category){ ?>
            <li><a href="<?php echo $category->getHref() ?>">
            <?php if(!empty($category->cat_icon)){ ?>
              <i class="menuicon" ><img src="<?php echo  $this->storage->get($category->cat_icon, '')->getPhotoUrl() ?>"/></i>
            <?php } ?>
            <span><?php echo $category->category_name; ?></span></a></li>
          <?php } ?>
          </ul>
        </div>
      <?php } ?>
      
      <div class="menu_left_panel_section menu_left_panel_section_footer">
      	<div class="_logo"><?php echo $this->content()->renderWidget('sesytube.menu-logo',array('logofooter'=>$this->footerlogo)); ?></div>
      	<div class="_links">
        	<ul>
            <?php foreach( $this->footernavigation as $item ): 
              $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
                'reset_params', 'route', 'module', 'controller', 'action', 'type',
                'visible', 'label', 'href'
              )));
              ?>
              <li>
                <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), $attribs) ?>
              </li>
            <?php endforeach; ?>
        	</ul>
        </div>
				<div class="_social">
          <?php
            echo $this->navigation()
              ->menu()
              ->setContainer($this->socialnavigation)
              ->setPartial('application/modules/Core/views/scripts/_navFontIcons.tpl')
              ->render()
          ?>
        </div>      
      	<?php if( 1 !== count($this->languageNameList) ): ?>
          <div class="_lang">
            <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
              <?php $selectedLanguage = $this->translate()->getLocale() ?>
              <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
              <?php echo $this->formHidden('return', $this->url()) ?>
            </form>
          </div>
        <?php endif; ?>
        <div class="_copy">
          <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	sesJqueryObject(document).on('click','.sesytube_menu_main',function(e){
	  if(sesJqueryObject(this).parent().parent().find('ul').children().length == 0)
	  	return true;
			e.preventDefault();
			if(sesJqueryObject(this).parent().hasClass('open_toggled_menu')){
			sesJqueryObject('.open_toggled_menu').parent().find('ul').slideToggle('slow');
			sesJqueryObject(this).parent().removeClass('open_toggled_menu');
	  }else{
			sesJqueryObject('.open_toggled_menu').parent().find('ul').slideToggle('slow');
			sesJqueryObject(this).parent().parent().find('ul').slideToggle('slow');
			sesJqueryObject('.open_toggled_menu').removeClass('open_toggled_menu');
			sesJqueryObject(this).parent().addClass('open_toggled_menu');
	  }
	  return false;
  });

	sesJqueryObject(document).on('click','.menu_left_panel_section_link',function(e){
	  if(sesJqueryObject(this).parent().parent().find('ul').children().length == 0)
	  	return true;
			e.preventDefault();
			if(sesJqueryObject(this).parent().hasClass('menu_left_panel_section_close')){
			sesJqueryObject('.menu_left_panel_section_close').parent().find('ul').slideToggle('slow');
			sesJqueryObject(this).parent().removeClass('menu_left_panel_section_close');
	  }else{
			sesJqueryObject('.menu_left_panel_section_close').parent().find('ul').slideToggle('slow');
			sesJqueryObject(this).parent().parent().find('ul').slideToggle('slow');
			sesJqueryObject('.menu_left_panel_section_close').removeClass('menu_left_panel_section_close');
			sesJqueryObject(this).parent().addClass('menu_left_panel_section_close');
	  }
	  return false;
  });
  
  sesJqueryObject(document).on('click','#sidebar_panel_menu_btn',function(){
    if(sesJqueryObject (this).hasClass('activesesytube')) {
     sesJqueryObject (this).removeClass('activesesytube');
     sesJqueryObject ("body").removeClass('sidebar-toggled');
	   setCookiePannel('sesytube','1','30');
    } else {
     sesJqueryObject (this).addClass('activesesytube');
     sesJqueryObject ("body").addClass('sidebar-toggled');
	   setCookiePannel('sesytube','2','30');
    }
 });
 sesJqueryObject(document).ready(function(){
	var menuElement = sesJqueryObject('.sesytube_menu_main').parent().parent("[class*='active']");
    menuElement.find('ul').show();
   	if(menuElement.find('ul').length)
		menuElement.find('a').addClass('open_toggled_menu');
    var slectedIndex = sesJqueryObject('.selected_sub_main_menu').index();
	if(sesJqueryObject('.selected_sub_main_menu').parent().hasClass('sesytube_toggle_sub_menu')){
	  sesJqueryObject('.selected_sub_main_menu').parent().children().each(function(index,element){
		if(index == slectedIndex)  
			return false;
		sesJqueryObject(this).addClass('sesytube_sub_menu_selected');
	  });
	}
 })
 // cookie get and set function
function setCookiePannel(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var ytubeires = "expires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + ytubeires+"; path=/";
} 

function getCookiePannel(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
	}
	return "";
}
// end cookie get and set function.
 function getVisible() {    
    var $el = sesJqueryObject('#global_footer'),
        scrollTop = sesJqueryObject(this).scrollTop(),
        scrollBot = scrollTop + sesJqueryObject(this).height(),
        elTop = $el.offset().top,
        elBottom = elTop + $el.outerHeight(),
        visibleTop = elTop < scrollTop ? scrollTop : elTop,
        visibleBottom = elBottom > scrollBot ? scrollBot : elBottom;
    	var height = visibleBottom - visibleTop;
			doResizeForButton();
//		if(height > 0){
//		  sesJqueryObject('#menu_left_panel').css('bottom',height+'px');
//		}else
//		  sesJqueryObject('#menu_left_panel').css('bottom','0px');
}

sesJqueryObject(window).on('scroll resize', getVisible);

function doResizeForButton(){
  sesJqueryObject('.layout_sesytube_menu_main').show();
  if (matchMedia('only screen and (max-width: 1200px)').matches) {
    sesJqueryObject ('#sidebar_panel_menu_btn').addClass('activesesytube');
    sesJqueryObject ("body").addClass('sidebar-toggled');
  }
  <?php 
  if(empty($_COOKIE['sesytube'])){ ?>
    sesJqueryObject ('#sidebar_panel_menu_btn').addClass('activesesytube');
  <?php 
  }
  ?>
	if(getCookiePannel('sesytube') == 2 && getCookiePannel('sesytube') != '') {
    sesJqueryObject('#sidebar_panel_menu_btn').addClass('activesesytube');
		//sesJqueryObject('#sidebar_panel_menu_btn').trigger('click');
	}
	
	var height = sesJqueryObject(".layout_sesytube_header").height();
	if($("menu_left_panel")) {
		$("menu_left_panel").setStyle("top", height+"px");
	}
	  
	var heightPannel = sesJqueryObject("#menu_left_panel").height();
	sesJqueryObject('#global_content').css('min-height',heightPannel+'px');
}
sesJqueryObject(document).ready(function(){
	doResizeForButton();
});

setTimeout(function(){ sesJqueryObject ("body").addClass('showmenupanel'); }, 100);
</script>

