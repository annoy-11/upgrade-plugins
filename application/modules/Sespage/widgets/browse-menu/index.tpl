<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespage
 * @package    Sespage
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-04-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/styles.css'); ?> 
<div class="headline">
  <h2>
    <?php if(!empty($this->params['title'])): ?>
      <?php echo $this->translate($this->params['title']); ?>
    <?php else: ?>
      <?php echo $this->translate('Pages'); ?>
    <?php endif; ?>
  </h2>
  <?php $countMenu = 0; ?>
  <?php if( count($this->navigation) > 0 ): ?>
    <div class="tabs">
      <ul class="navigation">
	  <?php foreach( $this->navigation as $navigationMenu ): 
      $explodedString = explode(' ', @$navigationMenu->class);
        $menuName = end($explodedString); 
        if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('enableglocation', 1) && $menuName == 'sespage_main_browselocations') {
          continue;
        }
	  ?>
	    <?php if( $countMenu < $this->max ): ?>
	      <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
	      <?php if ($navigationMenu->action): ?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array('action' => $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
              <?php else : ?>
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
              <?php endif; ?>
	      </li>
	    <?php else:?>
	      <?php break;?>
	    <?php endif;?>
	    <?php $countMenu++;?>
	  <?php endforeach; ?>
	<?php if (count($this->navigation) > $this->max):?>
	  <?php $countMenu = 0; ?>
	    <li class="sesbasic_browse_nav_tab_closed sesbasic_browse_nav_pulldown" onclick="moreTabSwitch($(this));">
	      <a href="javascript:void(0);"><?php echo $this->translate('More +') ?><span></span></a>
	      <div class="tab_pulldown_contents_wrapper sesbasic_bxs">
          <div class="tab_pulldown_contents">
            <ul>
              <?php foreach( $this->navigation as  $navigationMenu ): ?>
                <?php if ($countMenu >= $this->max): ?>
                <?php $urlNavigation = empty($navigationMenu->uri) ? $this->url(array('action' => $navigationMenu->action), $navigationMenu->route, true) : $navigationMenu->uri ?>
           <?php $http_https = isset($_SERVER['HTTPS']) ? 'https://' : 'http://'; ?>
 <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?> <?php if ($urlNavigation == "$http_https$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"): ?><?php echo "class='active'";?><?php endif; ?>  >
            <?php if ($navigationMenu->action): ?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $urlNavigation ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
            <?php else : ?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'><?php echo $this->translate($navigationMenu->label); ?></a>
            <?php endif; ?>
            </li>
                <?php endif;?>
                <?php $countMenu++;?>
              <?php endforeach; ?>
            </ul>
          </div>
	      </div>
	    </li>
	<?php endif;?>
      </ul>
    </div>
  <?php endif; ?>
</div>
<script type="text/javascript">
  en4.core.runonce.add(function() {
    var moreTabSwitch = window.moreTabSwitch = function(el) {
      el.toggleClass('sesbasic_browse_nav_tab_open');
      el.toggleClass('sesbasic_browse_nav_tab_closed');
    }
  });
  <?php if(($this->popup || Engine_Api::_()->getApi('settings', 'core')->getSetting('sespage.icon.open.smoothbox', 1)) && !Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagepackage.enable.package', 0)){ ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Observer.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Local.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl .'externals/autocompleter/Autocompleter.Request.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'externals/tinymce/tinymce.min.js'); ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/jquery.timepicker.css'); ?>
    <?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/styles/bootstrap-datepicker.css'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery1.11.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/scripts/jquery.timepicker.js'); ?>
    <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sespage/externals/scripts/bootstrap-datepicker.js'); ?>
    sesJqueryObject('.sespage_main_create').addClass('sessmoothbox');
  <?php } ?>
</script>
