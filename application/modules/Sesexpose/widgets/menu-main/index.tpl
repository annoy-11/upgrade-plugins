<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesexpose
 * @package    Sesexpose
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2017-06-17 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<?php if($this->headerview != 3) { ?>
  <div class="mobile_nav_searhbox"><a  href="javascript:void(0);" class="top_header-search_box" id="mobile_header_searchbox_toggle"><i class="fa fa-search"></i></a></div>
  <a class="expose_mobile_nav_toggle" id="expose_mobile_nav_toggle" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
  <div class="sesexp_mobile_nav sesexp_main_menu" id="expose_mobile_nav">
    <ul class="navigation">
      <?php foreach( $this->navigation as $navigationMenu ): 
            $class = explode(' ', $navigationMenu->class); 
      ?>
        <?php 
          $mainMenuID = Engine_Api::_()->getApi('menus', 'sesexpose')->getMenuId(end($class));
          $menus = Engine_Api::_()->getApi('menus', 'sesexpose')->getMenuObject($mainMenuID);
          $getRow = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($mainMenuID);
        ?>
        <li class="<?php echo $navigationMenu->get('active') ? 'active' : '' ?>">
          <a href='<?php echo $navigationMenu->getHref() ?>' class="<?php echo $navigationMenu->getClass() ? ' ' . $navigationMenu->getClass() : ''  ?>" <?php if( $navigationMenu->get('target') ): ?> target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?> >
            <?php if(!empty($getRow) && $getRow->icon_type == 0):?>
							<?php $photo = Engine_Api::_()->storage()->get($getRow->icon_id, ''); ?>
							<?php if($photo) { ?>
								<i style="background-image:url(<?php echo $photo->getPhotoUrl(); ?>);"></i>
              <?php } ?>
            <?php elseif($getRow->icon_type == 1 && !empty($getRow->font_icon)): ?>
              <i class="fa <?php echo $getRow->font_icon ?>"></i>
            <?php endif;?>
            <span><?php echo $this->translate($navigationMenu->label); ?></span>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <script>
    $('expose_mobile_nav_toggle').addEvent('click', function(event){
      event.stop();
      if($('expose_mobile_nav').hasClass('show-nav'))
        $('expose_mobile_nav').removeClass('show-nav');
      else
        $('expose_mobile_nav').addClass('show-nav');
      return false;
    });
  </script>
<?php } ?>

<div class="sesexp_main_menu">
  <ul class="navigation">
    <?php $countMenu = 0; ?>
    <?php foreach( $this->navigation as $navigationMenu ): $class = explode(' ', $navigationMenu->class);  ?>
        <?php 
          $mainMenuID = Engine_Api::_()->getApi('menus', 'sesexpose')->getMenuId(end($class));
          $menus = Engine_Api::_()->getApi('menus', 'sesexpose')->getMenuObject($mainMenuID);
          $getRow = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($mainMenuID);
        ?>
      <?php if( $countMenu < $this->max ): ?>
        <li class="<?php echo $navigationMenu->get('active') ? 'active' : '' ?>">
          <a href='<?php echo $navigationMenu->getHref() ?>' class="<?php echo $navigationMenu->getClass() ? ' ' . $navigationMenu->getClass() : ''  ?>" <?php if( $navigationMenu->get('target') ): ?> target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?> >
            <?php if(!empty($getRow) && $getRow->icon_type == 0):?>
							<?php $photo = Engine_Api::_()->storage()->get($getRow->icon_id, ''); ?>
							<?php if($photo) { ?>
								<i style="background-image:url(<?php echo $photo->getPhotoUrl(); ?>);"></i>
              <?php } ?>
            <?php elseif($getRow->icon_type == 1 && !empty($getRow->font_icon)): ?>
              <i class="fa <?php echo $getRow->font_icon ?>"></i>
            <?php endif;?>
            <span><?php echo $this->translate($navigationMenu->getlabel()) ?></span>
          </a>
        </li>
      <?php else:?>
        <?php break;?>
      <?php endif;?>
      <?php $countMenu++;?>
    <?php endforeach; ?>
    <?php if (count($this->navigation) > $this->max): ?>
      <?php $countMenu = 0; ?>  
      <li class="more_tab">
        <a class="menu_core_main core_menu_more" href="javascript:void(0);"><span><?php echo $this->translate($this->moreText); ?> <i class="fa fa-angle-down"></i></span></a>
        <ul class="main_menu_submenu">
          <?php foreach( $this->navigation as  $navigationMenu ): $class = explode(' ', $navigationMenu->class); ?>
					<?php 
						$mainMenuID = Engine_Api::_()->getApi('menus', 'sesexpose')->getMenuId(end($class));
						$menus = Engine_Api::_()->getApi('menus', 'sesexpose')->getMenuObject($mainMenuID);
						$getRow = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($mainMenuID);
					?>
            <?php if ($countMenu >= $this->max): ?>
              <li class="<?php echo $navigationMenu->get('active') ? 'active' : '' ?>">
                <a href='<?php echo $navigationMenu->getHref() ?>' class="<?php echo $navigationMenu->getClass() ? ' ' . $navigationMenu->getClass() : ''  ?>" <?php if( $navigationMenu->get('target') ): ?> target='<?php echo $navigationMenu->get('target') ?>' <?php endif; ?> >
									<?php if(!empty($getRow) && $getRow->icon_type == 0):?>
										<?php $photo = Engine_Api::_()->storage()->get($getRow->icon_id, ''); ?>
										<?php if($photo) { ?>
											<i style="background-image:url(<?php echo $photo->getPhotoUrl(); ?>);"></i>
										<?php } ?>
									<?php elseif($getRow->icon_type == 1 && !empty($getRow->font_icon)): ?>
										<i class="fa <?php echo $getRow->font_icon ?>"></i>
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
  
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexp_enable_footer', 1) && $this->headerview == 3) { ?>
      <div class="sesexp_main_menu_footer">
    <p class="copyright_right"><?php echo $this->translate('Copyright &copy;%s', date('Y')) ?></p>
    <p class="liks_right">
    <?php foreach( $this->footernavigation as $item ):
      $attribs = array_diff_key(array_filter($item->toArray()), array_flip(array(
        'reset_params', 'route', 'module', 'controller', 'action', 'type',
        'visible', 'label', 'href'
      )));
      ?>
      <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), $attribs) ?>
    <?php endforeach; ?></p>

    <?php if( 1 !== count($this->languageNameList) ): ?>
        <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
          <?php $selectedLanguage = $this->translate()->getLocale() ?>
          <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
          <?php echo $this->formHidden('return', $this->url()) ?>
        </form>
    <?php endif; ?>
    </div>
  <?php } ?>
</div>
<?php $header_fixed = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesexpose.header.fixed', 1); ?>
<?php if($header_fixed == '1'): ?>
	<script>
	sesJqueryObject(document).ready(function(e){
		if(sesJqueryObject('.layout_page_header')) {
	    sesJqueryObject('.layout_page_header').addClass("header_fixed");
	  }
	});
	</script>
<?php endif; ?>
