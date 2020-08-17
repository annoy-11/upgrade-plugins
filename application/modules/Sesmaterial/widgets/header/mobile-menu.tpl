<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesmaterial
 * @package    Sesmaterial
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: login-or-signup.tpl 2018-07-28 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>

<a href="javascript:void;" class="sesmaterial_mobile_menu_toggle" id="sesmaterial_mobile_menu_toggle"><i class="fa fa-bars"></i></a>
<div class="sesmaterial_mobile_menu_search"><i class="fa fa-search"></i>
  <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
  }else{
  echo $this->content()->renderWidget("sesmaterial.search");
  }
  ?>
</div>

<div class="sesmaterial_mobile_menu_container" id="sesmaterial_mobile_menu_container">
  <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesmaterial.menu-logo'); ?>
      </div>
      <?php endif; ?>
  <div class="sesmaterial_mobile_menu_links">
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
$('sesmaterial_mobile_menu_toggle').addEvent('click', function(event){
	event.stop();
	if($('sesmaterial_mobile_menu_container').hasClass('show-menu'))
		$('sesmaterial_mobile_menu_container').removeClass('show-menu');
	else
		$('sesmaterial_mobile_menu_container').addClass('show-menu');
	return false;
});
</script>
<script>
sesJqueryObject(document).ready(function(){
    sesJqueryObject(".sesmaterial_mobile_menu_search > i").click(function(){
        sesJqueryObject(".sesmaterial_mobile_menu_search .header_searchbox").toggle();
    });
		 sesJqueryObject(".sesmaterial_mobile_menu_search > i").click(function(){
        sesJqueryObject(".sesmaterial_mobile_menu_search .advancedsearch_box").toggle();
    });
});
</script>
