<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespagebuilder/externals/styles/styles.css'); ?>
<?php 
$module_name = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
$action_name = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
$moduleArray = array('album','blog','classified','group','video','event','sesalbum','sesmusic','poll');
?>
<?php if($this->menuName == 'core_main' && isset($this->show_type) && $this->show_type == '0'): ?>
	<a class="sespagebuilder_nav_mob_btn fa fa-bars" id="sespagebuilder_nav_mob_btn" href="javascript:void(0);"></a>
<?php endif; ?>
<div id="sespagebuilder_generic_menu_<?php echo $this->identity; ?>" class="<?php if($this->menuName == 'core_main'): ?> <?php if(isset($this->show_type) && $this->show_type == '0'): ?> layout_core_menu_main <?php else: ?>sespagebuilder_generic_menu sesbasic_clearfix sesbasic_bxs sespagebuilder_generic_menu_vertical<?php endif; ?> <?php else: ?> sespagebuilder_generic_menu sesbasic_clearfix sesbasic_bxs sespagebuilder_generic_menu_<?php echo (isset($this->show_type) && $this->show_type == '0') ? 'horizontal' : 'vertical'; ?><?php endif; ?>">
    <ul id="navigation">
        <?php $s = 0;
        $total = 0;
        $more = array();
        foreach ($this->navigation as $item): ?>
          <?php 
            $explodedString = explode(' ', $item->class);
            $menuName = end($explodedString); 
            $moduleName = str_replace('core_main_', '', $menuName);
          ?>
          <?php
          $label = $item->getLabel();
          $class = $item->getClass();
          if ($s < $this->menucount) {
            // We have to this manually
            if ((strstr(strtolower($label), $module_name) != "") || ($module_name == "core" && $label == "Home") || ($module_name == "user" && $label == "Home" && $action_name == "home") || ($module_name == "user" && $label == "Members" && $action_name == "browse")) {
              ?>
              <li class="active">
                <a href="<?php echo $item->getHref(); ?>" class="<?php echo $class; ?>"><span><?php echo $this->translate($item->getLabel()); ?></span></a>
              </li>
              <?php
              $total += 1;
              $s += 1;
            } else {
              ?>
              <?php if(in_array($moduleName,$moduleArray)): ?>
                <?php if($this->show_menu && $this->show_menu != '2'):?>
                  <?php $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($moduleName.'_main'); ?>
                    <li <?php if(count($subMenus) > 0): ?> onmouseover='showCategory("<?php echo $moduleName;?>");' onmouseout='removeCategory("<?php echo $moduleName;?>", event);' <?php endif; ?> ><a href="<?php echo $item->getHref(); ?>" class="<?php echo $class; ?>"><span><?php echo $this->translate($item->getLabel()); ?></span></a>  
                      <?php if(count($subMenus) > 0): ?>
                        <ul class="sespagebuilder_menu_submenu sesbasic_clearfix">
                          <?php foreach( $subMenus as $subMenu): ?>
                            <li class="sesbasic_clearfix">
                            	<a href="<?php echo $subMenu->getHref(); ?>" class="<?php echo $subMenu->getClass(); ?>">
                              	<?php if($this->show_menu_icon):?><i class="fa fa-angle-right"></i><?php endif;?><span><?php echo $this->translate($subMenu->getLabel()); ?></span>
                              </a>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                      <?php endif; ?>
                    </li>
                <?php elseif($this->show_menu != '2'):?>
                  <?php $categories = Engine_Api::_()->sespagebuilder()->getCategories(array('module_name' => $moduleName)); ?>
                  <li <?php if(count($categories) > 0): ?> onmouseover='showCategory("<?php echo $moduleName;?>");' onmouseout='removeCategory("<?php echo $moduleName;?>", event);' <?php endif; ?> ><a href="<?php echo $item->getHref(); ?>" class="<?php echo $class; ?>"><span><?php echo $this->translate($item->getLabel()); ?></span></a>  
                    <?php if ($moduleName == 'group' || $moduleName == 'forum' || $moduleName == 'event'): ?>
                    <?php $catFieldName = 'title'; ?>
                    <?php else: ?>
                      <?php $catFieldName = 'category_name'; ?>
                    <?php endif; ?>
                    <?php if(count($categories) > 0): ?>
                      <?php $catParams = Engine_Api::_()->sespagebuilder()->catParameters(array('module_name' => $moduleName)); ?>
                      <div class="sespagebuilder_menu_catmenu sesbasic_bxs">
                  <?php foreach( $categories as $catrgory): ?>
                    <?php $URL = $catParams["URL"] . $catrgory['category_id'];  ?>
                    <a href='<?php echo $URL ?>'>
                      <?php if($this->show_menu_icon):?><i class="fa fa-angle-right"></i><?php endif;?><span><?php echo $this->translate($catrgory[$catFieldName]); ?></span>
                    </a>
                  <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                  </li>
                <?php endif;?>
              <?php else: ?>
                <li><a href="<?php echo $item->getHref(); ?>" class="<?php echo $class; ?>"><span><?php echo $this->translate($item->getLabel()); ?></span></a></li>
              <?php endif; ?>
              <?php
                  $s += 1;
                }
              } else {
                if (strstr(strtolower($label), $module_name) != "") {
                  $more[$s] = "<li class='active'><a href='" . $item->getHref() . "' class='" . $class . "'><span>" . $this->translate($item->getLabel()) . "</span></a></li>";
                  $s += 1;
                } else {
                  if($this->show_menu_icon) {
		    $more[$s] = "<li><a href='" . $item->getHref() . "' class='" . $class . "'><i class='fa fa-angle-right'></i><span>" . $this->translate($item->getLabel()) . "</span></a></li>";
                  }
                  else {
                    $more[$s] = "<li><a href='" . $item->getHref() . "' class='" . $class . "'><span>" . $this->translate($item->getLabel()) . "</span></a></li>";
                  }
                  $s += 1;
                }
              }
              ?>
        <?php
        endforeach;
        if ($s > $this->menucount) {
        ?>
          <li class="explore">
              <a href="javascript:void(0);">
                  <span>
                  <?php
                  if (empty($this->menuname)) {
                    echo $this->translate('Explore');
                  } else {
                    echo $this->translate($this->menuname);
                  }
                  ?>
                  </span>
              </a>
              <ul class="sespagebuilder_menu_submenu sesbasic_clearfix">
                <?php
                  foreach ($more as $more_item) {
                    echo $more_item;
                  }
                ?>
              </ul>
          </li>
        <?php
        }
        ?>
    </ul>
</div>
<script>
  function showCategory(menuName) {
    if($(menuName))
    $(menuName).style.display = 'block';
  }

  function removeCategory(menuName, event) {
    if($(menuName))
    $(menuName).style.display = 'none';
  }
</script>

<?php if($this->menuName == 'core_main' && isset($this->show_type) && $this->show_type == '0'): ?>
	<script>
  $('sespagebuilder_nav_mob_btn').addEvent('click', function(event){
    event.stop();
    if($('sespagebuilder_generic_menu_<?php echo $this->identity; ?>').hasClass('show-navigation'))
      $('sespagebuilder_generic_menu_<?php echo $this->identity; ?>').removeClass('show-navigation');
    else
      $('sespagebuilder_generic_menu_<?php echo $this->identity; ?>').addClass('show-navigation');
    return false;
  });
  </script>
<?php endif;?>
<?php if($this->customcolor):?>
  <style type="text/css">
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?>,
  #sespagebuilder_generic_menu_<?php echo $this->identity; ?> ul,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_catmenu,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_submenu{
	  background-color:#<?php echo $this->menuBgColor?>;
  }
  #sespagebuilder_generic_menu_<?php echo $this->identity; ?> > ul > li > a,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_catmenu a,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_submenu li a{
	  color:#<?php echo $this->menuTextColor?> !important;
	  font-size:<?php echo $this->menuTextFontSize?>px;
  }
  #sespagebuilder_generic_menu_<?php echo $this->identity; ?> > ul > li.active > a,
  #sespagebuilder_generic_menu_<?php echo $this->identity; ?> > ul > li:hover > a,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_catmenu a:hover,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_submenu li:hover a, 
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_submenu li.active a{
	  background-color:#<?php echo $this->menuHoverBgColor?>;
	  color:#<?php echo $this->menuHoverTextColor?>;
  }
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?>,
  #sespagebuilder_generic_menu_<?php echo $this->identity; ?> ul,
  #sespagebuilder_generic_menu_<?php echo $this->identity; ?> ul li,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?>.sespagebuilder_generic_menu_vertical .sespagebuilder_menu_submenu a + a,
	#sespagebuilder_generic_menu_<?php echo $this->identity; ?> .sespagebuilder_menu_submenu li{
	  border-color:#<?php echo $this->menuBorderColor?>;
  }
	<?php if($this->menuName == 'core_main' && isset($this->show_type) && $this->show_type == '0'): ?>
	@media only screen and (max-width:767px){
		.sespagebuilder_nav_mob_btn{background-color:#<?php echo $this->menuBgColor?>;}
		.sespagebuilder_nav_mob_btn:hover{background-color:#<?php echo $this->menuHoverBgColor?>;}
		.sespagebuilder_nav_mob_btn:before{color:#<?php echo $this->menuTextColor?> !important;}
		.sespagebuilder_nav_mob_btn:before:hover{color:#<?php echo $this->menuHoverTextColor?>;}
	}
	<?php endif; ?>
  </style>
<?php endif;?>