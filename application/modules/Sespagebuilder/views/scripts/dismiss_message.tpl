<?php 
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespagebuilder
 * @package    Sespagebuilder
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2015-07-31 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */ 
 ?>
<script type="text/javascript">
function dismiss(coockiesValue) {
  var d = new Date();
  d.setTime(d.getTime()+(365*24*60*60*1000));
  var expires = "expires="+d.toGMTString();
  document.cookie = coockiesValue + "=" + 1 + "; " + expires;
	$('dismiss_developer').style.display = 'none';
}
</script>
<?php if( !isset($_COOKIE["developer_profile"])): ?>
  <div id="dismiss_developer" class="tip">
    <span>
      <?php echo "Can you rate our developer profile on <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>socialengine.com</a> to support us? <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"developer_profile\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>
<?php //if( !isset($_COOKIE["sespagebuilder_product"])): ?>
<?php if(0): ?>
  <div id="dismiss_developer" class="tip">
    <span>
      <?php echo "Can you rate our plugin on <a href='https://www.socialengine.com/customize/se4/mod-page?mod_id=1426' target='_blank'>socialengine.com</a> to support our plugin?  <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"sespagebuilder_product\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>
<h2><?php echo $this->translate("SESPAGEBUILDER_PLUGIN") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'settings', 'action' => 'contact-us'),'admin_default',true); ?>" target = "_blank" class="request-btn">Feature Request</a>
</div>
<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespagebuilder.pluginactivated')): ?>
  <?php if( count($this->navigation) ): ?>
    <div class='sesbasic-admin-navgation'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php endif; ?>