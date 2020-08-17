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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesexpose/externals/styles/styles.css'); ?>

<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if($this->heading): ?>
  <h3><?php echo $this->translate("%s members and counting ...", $this->member_count); ?></h3>
<?php endif; ?>
<ul class="expose_member_block sesbasic_clearfix sesbasic_bxs">
  <?php foreach( $this->paginator as $user ): ?>
    <li style="width:<?php echo $this->width ?>px;">
      <div class="expose_member_block_thumb sesbasic_animation" style="height:<?php echo $this->height ?>px;"><?php echo $this->htmlLink($user->getHref(), $this->itemPhoto($user, 'thumb.profile')) ?></div>
      <?php if($this->showTitle): ?>
      <div class='member_info sesbasic_animation'>
        <?php echo $user->displayname; ?>
      </div>
      <?php endif; ?>
    </li>
  <?php endforeach; ?>
</ul>

<script type="application/javascript">
imagebW(window).load(function(){
    imagebW('.bwWrapper').BlackAndWhite({
        hoverEffect : true, // default true
        // set the path to BnWWorker.js for a superfast implementation
        webworkerPath : false,
        // this option works only on the modern browsers ( on IE lower than 9 it remains always 1)
        intensity:1,
        speed: { //this property could also be just speed: value for both fadeIn and fadeOut
            fadeIn: 100, // 200ms for fadeIn animations
            fadeOut: 800 // 800ms for fadeOut animations
        }
    });
});
</script>