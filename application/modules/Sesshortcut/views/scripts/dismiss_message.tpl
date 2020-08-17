<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesshortcut
 * @package    Sesshortcut
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: dismiss_message.tpl 2018-01-25 00:00:00 SocialEngineSolutions $
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

<h2><?php echo $this->translate("Add To Shortcuts / Bookmarks Plugin") ?></h2>
<div class="sesbasic_nav_btns">
  <a href="http://socialenginesolutions.com/tickets/" target = "_blank" class="request-btn">Submit a Ticket</a>
  <a href="https://www.socialenginesolutions.com/contact-us" target = "_blank" class="request-btn">Request a Feature</a>
</div>
<?php if( count($this->navigation) ): ?>
  <div class='tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render(); ?>
  </div>
<?php endif; ?>