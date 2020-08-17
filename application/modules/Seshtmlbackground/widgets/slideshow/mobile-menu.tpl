<?php


?>

<a href="javascript:void;" class="temp_mobile_menu_toggle" id="temp_mobile_menu_toggle"><i class="fa fa-bars"></i></a>
<div class="temp_mobile_menu_container" id="temp_mobile_menu_container">
  <div class="temp_mobile_menu_links">
    <ul>
      <?php foreach( $this->navigation as $navigationMenu ): 
        $class = explode(' ', $navigationMenu->class);
        ?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if(end($class) == 'core_main_invite'):?>
            <a class= "<?php echo $class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif(end($class) == 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>'>
          <?php endif;?>
            <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>    
<script>
$('temp_mobile_menu_toggle').addEvent('click', function(event){
	event.stop();
	if($('temp_mobile_menu_container').hasClass('show-menu'))
		$('temp_mobile_menu_container').removeClass('show-menu');
	else
		$('temp_mobile_menu_container').addClass('show-menu');
	return false;
});
</script>