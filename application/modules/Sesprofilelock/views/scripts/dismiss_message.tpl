<?php

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
<?php if(0): ?>
<?php //if( !isset($_COOKIE["dismiss_sesspectromediaplugin"])): ?>
  <div id="dismiss_sesspectromediaplugin" class="tip">
    <span>
      <?php echo "Can you rate our plugin on <a href='http://www.socialengine.com/customize/se4/mod-page?mod_id=1482' target='_blank'>socialengine.com</a> to support our plugin? <a href='http://www.socialengine.com/customize/se4/mod-page?mod_id=1482' target='_blank'>Yes</a> or <a href='javascript:void(0);' onclick='dismiss(\"dismiss_sesspectromediaplugin\")'>No, not now</a>.";
    ?>
    </span>
  </div>
<?php endif; ?>
<h2><?php echo $this->translate("User Accounts Privacy & Content Security with Password Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="<?php echo $this->url(array('module' => 'sesbasic', 'controller' => 'settings', 'action' => 'contact-us'),'admin_default',true); ?>" target = "_blank" class="request-btn">Feature Request</a>
</div>
<?php $sesprofilelock_adminmenu = Zend_Registry::isRegistered('sesprofilelock_adminmenu') ? Zend_Registry::get('sesprofilelock_adminmenu') : null; ?>
<?php if(!empty($sesprofilelock_adminmenu)) { ?>
  <?php if( count($this->navigation) ): ?>
    <div class='tabs'>
      <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
    </div>
  <?php endif; ?>
<?php } ?>
