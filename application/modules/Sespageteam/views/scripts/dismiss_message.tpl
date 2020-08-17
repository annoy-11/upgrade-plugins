<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageteam
 * @package    Sespageteam
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl  2018-11-14 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<script type="text/javascript">
function dismiss(coockiesValue) {
  var d = new Date();
  d.setTime(d.getTime()+(365*24*60*60*1000));
  var expires = "expires="+d.toGMTString();
  document.cookie = coockiesValue + "=" + 1 + "; " + expires;
    $(coockiesValue).style.display = 'none';
}
</script>
<?php if( !isset($_COOKIE["dismiss_developer"])): ?>
  <div id="dismiss_developer" class="tip">
    <span>
      <?php echo "Can you rate our developer profile on <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>socialengine.com</a> to support us? <a href='https://www.socialengine.com/experts/profile/socialenginesolutions' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"dismiss_developer\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>
<?php if( !isset($_COOKIE["dismiss_sespageteamplugin"])): ?>
  <div id="dismiss_sespageteamplugin" class="tip">
    <span>
      <?php echo "Can you rate our plugin on <a href='http://www.socialengine.com/customize/se4/mod-page?mod_id=1429' target='_blank'>socialengine.com</a> to support our plugin? <a href='http://www.socialengine.com/customize/se4/mod-page?mod_id=1429' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"dismiss_sespageteamplugin\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>

<h2><?php echo $this->translate("Page Team Showcase Extension") ?></h2>
<?php if( count($this->navigation) ): ?>
  <div class='sesbasic-admin-navgation'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>
