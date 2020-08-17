<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessocialtube
 * @package    Sessocialtube
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $countMenu = 0; ?>

<div class="socialtube_main_navigation">
  <ul>
    <?php foreach( $this->navigation as $navigationMenu ): ?>
      <?php if( $countMenu < $this->max ): ?>
        <?php $mainMenuIcon = Engine_Api::_()->getApi('menus', 'sessocialtube')->getIconsMenu(end((explode(' ', $navigationMenu->class))));?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if(end((explode(' ', $navigationMenu->class)))== 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif(end((explode(' ', $navigationMenu->class)))== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'>
            <!--<a class= "<?php //echo $navigationMenu->class ?>" href='<?php //echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>-->
          <?php endif;?>
            <?php if(!empty($mainMenuIcon)):?>
              <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
            <?php endif;?>
            <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php else:?>
        <?php break;?>
      <?php endif;?>
      <?php $countMenu++;?>
    <?php endforeach; ?>
    <?php if (count($this->navigation) > $this->max):?>
    <?php $countMenu = 0; ?>  
    <li class="socialtube_main_nav_more">
      <a href="javascript:void(0);">
        <span><?php echo $this->translate($this->moreText) ?></span>
        <i class="fa fa-angle-down"></i>
      </a>
      <ul class="socialtube_main_nav_submenu">
        <?php foreach( $this->navigation as  $navigationMenu ): ?>
          <?php $mainMenuIcon = Engine_Api::_()->getApi('menus', 'sessocialtube')->getIconsMenu(end((explode(' ', $navigationMenu->class))));?>
          <?php if ($countMenu >= $this->max): ?>
            <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?> >
		          <?php if(end((explode(' ', $navigationMenu->class)))== 'core_main_invite'):?>
		            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
		          <?php elseif(end((explode(' ', $navigationMenu->class)))== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
		            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
		          <?php else:?>
		            <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'>
		            <!--<a class= "<?php //echo $navigationMenu->class ?>" href='<?php //echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>-->
		          <?php endif;?>
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

<?php $header_fixed = Engine_Api::_()->sessocialtube()->getContantValueXML('socialtube_header_fixed_layout'); 
if($header_fixed == '1'):
?>
	<script>
	 
	sesJqueryObject(document).ready(function(e){

	var height = sesJqueryObject('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
	</script>
<?php endif; ?>
