<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Seselegant
 * @package    Seselegant
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-04-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
  <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
<?php $countMenu = 0; ?>
<a class="elegant_mobile_nav_toggle" id="elegant_mobile_nav_toggle" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
<div class="elegant_mobile_nav elg_main_menu" id="elegant_mobile_nav">
	<ul class="navigation">
    <?php foreach( $this->navigation as $navigationMenu ): ?>
      <?php $class = explode(' ', $navigationMenu->class); ?>
    	<?php $mainMenuIcon = Engine_Api::_()->seselegant()->getMenuIcon(end($class));?>
      <li <?php if (@$navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
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
<div class="elg_main_menu">
  <ul class="navigation">
    <?php foreach( $this->navigation as $navigationMenu ): ?>
      <?php if( $countMenu < $this->max ): ?>
        <?php $class = explode(' ', $navigationMenu->class); ?>
        <?php $mainMenuIcon = Engine_Api::_()->seselegant()->getMenuIcon(end($class));?>
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
      <?php else:?>
        <?php break;?>
      <?php endif;?>
      <?php $countMenu++;?>
    <?php endforeach; ?>
    <?php if (count($this->navigation) > $this->max):?>
    <?php $countMenu = 0; ?>  
    <li class="more_tab">
      <a href="javascript:void(0);">
        <i></i>
      </a>
      <ul class="main_menu_submenu">
        <?php foreach( $this->navigation as  $navigationMenu ): ?>
          <?php $class = explode(' ', $navigationMenu->class); ?>
          <?php $mainMenuIcon = Engine_Api::_()->seselegant()->getMenuIcon(end($class));?>
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
      <?php } ?>
<script>
$('elegant_mobile_nav_toggle').addEvent('click', function(event){
	event.stop();
	if($('elegant_mobile_nav').hasClass('show-nav'))
		$('elegant_mobile_nav').removeClass('show-nav');
	else
		$('elegant_mobile_nav').addClass('show-nav');
	return false;
});
</script>
