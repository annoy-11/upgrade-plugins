<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesariana
 * @package    Sesariana
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-11-22 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php 
$module_name = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
$action_name = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
$controller_name = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
?>
<?php if($this->headerDesign == 1){ ?>
<?php $countMenu = 0; ?>
<a class="ariana_mobile_nav_toggle" id="ariana_mobile_nav_toggle" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
<div class="sesariana_mobile_nav sesariana_main_menu" id="ariana_mobile_nav">
	<ul class="navigation">
    <?php foreach( $this->navigation as $navigationMenu ): ?>
      <?php $class = explode(' ', $navigationMenu->class); ?>
    	<?php $mainMenuIcon = Engine_Api::_()->sesariana()->getMenuIcon(end($class));?>
      <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
        <?php if(end($class)== 'core_main_invite'):?>
          <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
        <?php elseif(end($class)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
          <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
        <?php elseif($navClass == 'core_main_chat' && ($this->viewer->getIdentity() != 0)): ?>
          <a class= "<?php echo $navigationMenu->class ?>" href='chat'>
        <?php else:?>
          <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
        <?php endif;?>
          <?php if(!empty($mainMenuIcon)):?>
            <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
          <?php endif;?>
          <span><?php echo $this->translate($navigationMenu->label); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="sesariana_main_menu">
  <ul class="navigation">
    <?php foreach( $this->navigation as $navigationMenu ):
      $class = explode(' ', $navigationMenu->class);
      ?>
      <?php if( $countMenu < $this->max ): ?>
        <?php $mainMenuIcon = Engine_Api::_()->sesariana()->getMenuIcon(end($class));?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if(end($class)== 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif(end($class)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_chat' && ($this->viewer->getIdentity() != 0)): ?>
            <a class= "<?php echo $navigationMenu->class ?>" href='chat'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
          <?php endif;?>
            <?php if(!empty($mainMenuIcon)):?>
              <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
            <?php endif;?>
            <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
            <?php 
              
              $menuName = end($class); 
              $moduleName = str_replace('core_main_', '', $menuName);
            ?>
           <?php $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($moduleName.'_main'); 
              $menuSubArray = $subMenus->toArray();
           ?>
          <?php if(count($subMenus) > 0 && $this->submenu): ?>
            <ul class="main_menu_submenu">
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
      <?php else:?>
        <?php break;?>
      <?php endif;?>
      <?php $countMenu++;?>
    <?php endforeach; ?>
    <?php if (count($this->navigation) > $this->max):?>
    <?php $countMenu = 0; ?>  
    <li class="more_tab">
      <a class="menu_core_main core_menu_more" href="javascript:void(0);">
        <span><?php echo $this->translate($this->moretext);?> + </span>
      </a>
      <ul class="main_menu_submenu">
        <?php foreach( $this->navigation as  $navigationMenu ): 
        $class = explode(' ', $navigationMenu->class);
        ?>
          <?php $mainMenuIcon = Engine_Api::_()->sesariana()->getMenuIcon(end($class));?>
          <?php if ($countMenu >= $this->max): ?>
            <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?> >
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
                <?php if(!empty($mainMenuIcon)):?>
                  <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
                <?php endif;?>
                <span><?php echo $this->translate($navigationMenu->label); ?></span>
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
<script>
<?php if($this->headerDesign == 1){ ?>
	sesJqueryObject ("body").addClass('_headernotfix');
	
	if (matchMedia('only screen and (min-width: 767px)').matches) {
		jqueryObjectOfSes(document).ready(function(e){	
		var height = jqueryObjectOfSes('.header_top').height();
			if($('sesariana_main_menu')) {
				$('sesariana_main_menu').setStyle('margin-top', height+"px");
			}
		});
	};
<?php } ?>

$('ariana_mobile_nav_toggle').addEvent('click', function(event){
	event.stop();
	if($('ariana_mobile_nav').hasClass('show-nav'))
		$('ariana_mobile_nav').removeClass('show-nav');
	else
		$('ariana_mobile_nav').addClass('show-nav');
	return false;
});
</script>

<?php  }else{ ?>
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
    <?php if($this->viewer()->getIdentity() != 0){ ?>
      <div class="menu_left_panel_top_section clearfix" style="background-image:url(<?php echo $this->menuinformationimg; ?>);">
        <div class="menu_left_panel_top_section_img">
        	<?php echo $this->htmlLink($this->viewer()->getHref(), $this->itemPhoto($this->viewer(), 'thumb.profile')) ?>
        </div>
        <div class="menu_left_panel_top_section_name">
        	<span><?php echo $this->viewer()->getTitle(); ?></span>
          <a href="javascript:void(0);" class="menu_left_panel_top_section_btn" onclick="showHideInformation('sesariana_information');"><i class="fa fa-chevron-down" id="down_arrow"></i><i id="uparrow" class="fa fa-chevron-up" style="display:none;"></i></a>
        </div>
        <div class="menu_left_panel_top_section_options clearfix" style="display:none;" id="sesariana_information">
        	<div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
       		<?php //echo $this->content()->renderWidget("user.home-links"); ?>
       		  <?php // This is rendered by application/modules/core/views/scripts/_navIcons.tpl
              echo $this->navigation()->menu()->setContainer($this->homelinksnavigation)->setPartial(array('_navIcons.tpl', 'core'))->render();
            ?>
        </div>   
    	</div>
    <?php } ?>
    
    <div class="menu_left_panel_nav_container sesbasic_clearfix" style="background-image:url(<?php echo $this->backgroundImg; ?>);">
      <ul class="menu_left_panel_nav clearfix">
        <?php foreach( $this->navigation as $navigationMenu ): ?>
          <?php 
            $class = explode(' ', @$navigationMenu->class);
            $menuName = end($class); 
            $moduleName = str_replace('core_main_', '', $menuName);
          ?>
          <?php $mainMenuIcon = Engine_Api::_()->sesariana()->getMenuIcon(end($class));
              
          ?>
           <?php 
           if($this->submenu){
            $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($moduleName.'_main'); 
              $menuSubArray = $subMenus->toArray();
            }else
              $subMenus = array();
           ?>
          <li class="<?php if ($navigationMenu->active): ?>active<?php endif; ?> <?php if(count($subMenus) > 0): ?>toggled_menu_parant<?php endif; ?>">
            <?php if(end($class)== 'core_main_invite'):?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
            <?php elseif(end($class)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
            <?php elseif($navClass == 'core_main_chat' && ($this->viewer->getIdentity() != 0)): ?>
              <a class= "<?php echo $navigationMenu->class ?>" href='chat'>
            <?php else:?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $navigationMenu->getHref() ?>'>
            <?php endif;?>
              <?php if(!empty($mainMenuIcon)):?>
                <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
              <?php endif;?>
              <?php if(count($subMenus) > 0): ?><i class="expcoll-icon sesariana_menu_main"></i><?php endif;?>
              <span><?php echo $this->translate($navigationMenu->label); ?></span>
            </a> 
            <?php if(count($subMenus) > 0 && $this->submenu): ?>
              <ul class="sesariana_toggle_sub_menu" style="display:none;">
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
    </div>
  </div>
</div>

<script type="text/javascript">
	sesJqueryObject(document).on('click','.sesariana_menu_main',function(e){
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
  
  sesJqueryObject(document).on('click','#sidebar_panel_menu_btn',function(){
    if(sesJqueryObject (this).hasClass('activesesariana')) {
     sesJqueryObject (this).removeClass('activesesariana');
     sesJqueryObject ("body").removeClass('sidebar-toggled');
	   setCookiePannel('sesariana','1','30');
    } else {
     sesJqueryObject (this).addClass('activesesariana');
     sesJqueryObject ("body").addClass('sidebar-toggled');
	   setCookiePannel('sesariana','2','30');
    }
 });
 sesJqueryObject(document).ready(function(){
	var menuElement = sesJqueryObject('.sesariana_menu_main').parent().parent("[class*='active']");
    menuElement.find('ul').show();
   	if(menuElement.find('ul').length)
		menuElement.find('a').addClass('open_toggled_menu');
    var slectedIndex = sesJqueryObject('.selected_sub_main_menu').index();
	if(sesJqueryObject('.selected_sub_main_menu').parent().hasClass('sesariana_toggle_sub_menu')){
	  sesJqueryObject('.selected_sub_main_menu').parent().children().each(function(index,element){
		if(index == slectedIndex)  
			return false;
		sesJqueryObject(this).addClass('sesariana_sub_menu_selected');
	  });
	}
 })
 // cookie get and set function
function setCookiePannel(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var arianaires = "expires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + arianaires+"; path=/";
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
  sesJqueryObject('.layout_sesariana_menu_main').show();
  if (matchMedia('only screen and (max-width: 1200px)').matches) {
    sesJqueryObject ('#sidebar_panel_menu_btn').addClass('activesesariana');
    sesJqueryObject ("body").addClass('sidebar-toggled');
  }
  <?php 
  if(empty($_COOKIE['sesariana'])){ ?>
    sesJqueryObject ('#sidebar_panel_menu_btn').addClass('activesesariana');
  <?php 
  }
  ?>
	if(getCookiePannel('sesariana') == 2 && getCookiePannel('sesariana') != '') {
    sesJqueryObject('#sidebar_panel_menu_btn').addClass('activesesariana');
		//sesJqueryObject('#sidebar_panel_menu_btn').trigger('click');
	}
	
	var height = sesJqueryObject(".layout_sesariana_header").height();
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

<?php } ?>
