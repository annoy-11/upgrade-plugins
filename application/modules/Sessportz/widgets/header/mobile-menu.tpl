<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessportz
 * @package    Sessportz
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: mobile-menu.tpl  2019-04-16 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<a href="javascript:void;" class="sessportz_mobile_menu_toggle" id="sessportz_mobile_menu_toggle"><i class="fa fa-bars"></i></a>
<div class="sessportz_mobile_menu_search"><i class="fa fa-search"></i>
  <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
  }else{
  echo $this->content()->renderWidget("sessportz.search");
  }
  ?>
</div>

<div class="sessportz_mobile_menu_container" id="sessportz_mobile_menu_container">
  <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sessportz.menu-logo'); ?>
      </div>
      <?php endif; ?>
  <div class="sessportz_mobile_menu_links">
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
$('sessportz_mobile_menu_toggle').addEvent('click', function(event){
	event.stop();
	if($('sessportz_mobile_menu_container').hasClass('show-menu'))
		$('sessportz_mobile_menu_container').removeClass('show-menu');
	else
		$('sessportz_mobile_menu_container').addClass('show-menu');
	return false;
});
</script>
<script>
sesJqueryObject(document).ready(function(){
    sesJqueryObject(".sessportz_mobile_menu_search > i").click(function(){
        sesJqueryObject(".sessportz_mobile_menu_search .header_searchbox").toggle();
    });
});
</script>