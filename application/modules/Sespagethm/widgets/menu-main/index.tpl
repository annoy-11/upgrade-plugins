<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagethm
 * @package    Sespagethm
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php $countMenu = 0; ?>

<div class="sespagethm_main_navigation">
  <ul>
    <?php foreach( $this->navigation as $navigationMenu ): 
      $class = explode(' ', $navigationMenu->class);
      ?>
      <?php if( $countMenu < $this->max ): ?>
        <?php //$mainMenuIcon = Engine_Api::_()->getApi('menus', 'sespagethm')->getIconsMenu(end($class));?>
        <?php $mainMenuIcon = Engine_Api::_()->sespagethm()->getMenuIcon(end(explode(' ', $navigationMenu->class)));?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if(end($class)== 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif(end($class)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php elseif($navClass == 'core_main_chat' && ($this->viewer->getIdentity() != 0)): ?>
            <a class= "<?php echo $navigationMenu->class ?>" href='chat'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>' <?php if( $navigationMenu->get('target') ): ?>target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?>>
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
    <li class="sespagethm_main_nav_more">
      <a href="javascript:void(0);">
        <span><?php echo $this->translate($this->moreText) ?></span>
        <i class="fa fa-angle-down"></i>
      </a>
      <ul class="sespagethm_main_nav_submenu">
        <?php foreach( $this->navigation as  $navigationMenu ): ?>
          <?php //$mainMenuIcon = Engine_Api::_()->getApi('menus', 'sespagethm')->getIconsMenu(end($class));?>
          <?php $mainMenuIcon = Engine_Api::_()->sespagethm()->getMenuIcon(end(explode(' ', $navigationMenu->class)));?>
          <?php if ($countMenu >= $this->max): ?>
            <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?> >
		          <?php if(end($class)== 'core_main_invite'):?>
		            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
		          <?php elseif(end($class)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
		            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
              <?php elseif($navClass == 'core_main_chat' && ($this->viewer->getIdentity() != 0)): ?>
                <a class= "<?php echo $navigationMenu->class ?>" href='chat'>
		          <?php else:?>
		            <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>' <?php if( $navigationMenu->get('target') ): ?>target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?>>
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

<?php $header_fixed = Engine_Api::_()->sespagethm()->getContantValueXML('sespagethm_header_fixed_layout'); 
if($header_fixed == '1'):
?>
	<script>
	 
	jqueryObjectOfSes(document).ready(function(e){

	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
	</script>
<?php endif; ?>
