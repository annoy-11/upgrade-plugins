<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sessiteiframe
 * @package    Sessiteiframe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.php  2017-10-18 00:00:00 SocialEngineSolutions $
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
<?php if( !isset($_COOKIE["dismiss_sessiteiframeplugin"]) && 0): ?>
  <div id="dismiss_sesalbumplugin" class="tip">
    <span>
      <?php echo "Can you rate our plugin on <a href='http://www.socialengine.com/customize/se4/mod-page?mod_id=1449' target='_blank'>socialengine.com</a> to support our plugin?  <a href='http://www.socialengine.com/customize/se4/mod-page?mod_id=1449' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"dismiss_sesalbumplugin\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>
<h2>
  <?php echo $this->translate("Embed Site in iFrame for Continuous Music") ?>
</h2>
<div class="sessiteiframe_nav_btns">
  <a href="https://www.socialenginesolutions.com/contact-us/" class="request-btn" target="_blank">Feature Request</a>
</div>
<?php //check default tpl code in core
  //check file exists
  if(file_exists('application/modules/Core/layouts/scripts/default.tpl')){
    $getContent = file_get_contents('application/modules/Core/layouts/scripts/default.tpl');
    if(strpos($getContent,'application/modules/Sessiteiframe/views/scripts/Core/default.tpl') == false){ ?>
      <p>
        <?php echo $this->translate("It seems that the code which we added to the SE core file to make this plugin work is not there in the file right now. So if you wish to manually add the code, then click the “Update Code” button available in this tip or manually add the code by following the steps mentioned in the FAQ section of this plugin."); ?>
      </p>
      <a class="sesbasic_button" href="<?php echo $this->url(array('module' => 'sessiteiframe', 'controller' => 'settings', 'action' => 'fix-default'),'admin_default',true); ?>"><?php echo $this->translate("Update Code"); ?></a>
   <?php
    }
  }
 ?>