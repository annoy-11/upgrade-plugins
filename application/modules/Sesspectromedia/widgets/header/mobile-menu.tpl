<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesspectromedia
 * @package    Sesspectromedia
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: login-or-signup.tpl 2015-10-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<a href="javascript:void;" class="sm_mobile_menu_toggle" id="sm_mobile_menu_toggle"><i class="fa fa-bars"></i></a>
<div class="sm_mobile_menu_container" id="sm_mobile_menu_container">
  <div class="sm_mobile_menu_search">
    <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
    }else{
    echo $this->content()->renderWidget("sesspectromedia.search");
    }
    ?>
  </div>
  <div class="sm_mobile_menu_links">
    <ul>
      <?php foreach( $this->navigation as $navigationMenu ): 
        $class = explode(' ', $navigationMenu->class);
        ?>
        <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
          <?php if(end($class) == 'core_main_invite'):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
          <?php elseif(end($class) == 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
            <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
          <?php else:?>
            <a class= "<?php echo $navigationMenu->getClass() ?>" href='<?php echo $navigationMenu->getHref() ?>' <?php if( $navigationMenu->get('target') ): ?>target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?>>
          <?php endif;?>
            <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>    
<script>
$('sm_mobile_menu_toggle').addEvent('click', function(event){
	event.stop();
	if($('sm_mobile_menu_container').hasClass('show-menu'))
		$('sm_mobile_menu_container').removeClass('show-menu');
	else
		$('sm_mobile_menu_container').addClass('show-menu');
	return false;
});
</script>
