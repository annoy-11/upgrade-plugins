<?php
/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesfooter
 * @package    Sesfooter
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesfooter_follow_widget sesfooter_clearfix sesbsic_bxs">
  <div class="sesfooter_follow_widget_inner">
    <span class="ssesfooter_follow_text">
      <?php echo $this->title; ?>
    </span>
    <span class="sesfooter_follow_icons">
      <?php foreach ($this->paginator as $item): ?>
        <?php $link = (preg_match("#https?://#", $item->url) === 0) ? 'http://'.$item->url : $item->url; ?>
        <?php if($item->name == 'facebook'):?>
          <a class="sesfooter_icon_facebook sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-facebook"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'google'):?>
          <a class="sesfooter_icon_gplus sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-google-plus"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'linkdin'):?>
          <a class="sesfooter_icon_linkedin sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-linkedin"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'twitter'):?>
          <a class="sesfooter_icon_twitter sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-twitter"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'pinintrest'):?>
          <a class="sesfooter_icon_pinintrest sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-pinterest-p"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'instragram'):?>
          <a class="sesfooter_icon_instragram sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-instagram"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'youtube'):?>
          <a class="sesfooter_icon_youtube sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-youtube"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'vimeo'):?>
          <a class="sesfooter_icon_vimeo sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-vimeo"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'tumblr'):?>
          <a class="sesfooter_icon_tumblr sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-tumblr"></i>
          </a>
        <?php endif;?>
        <?php if($item->name == 'flickr'):?>
          <a class="sesfooter_icon_flickr sesfooter_animation" href="<?php echo $link;?>" target="_blank" title="<?php echo $this->translate($item->title); ?>">
            <i class="fa fa-flickr"></i>
          </a>
        <?php endif;?>
      <?php endforeach; ?>
    </span>
  </div>
</div>
<style type="text/css">
.sesfooter_follow_widget{
  background-color:#<?php echo $this->background_color; ?>;
}
.ssesfooter_follow_text{
  color:#<?php echo $this->text_color; ?>;
}
.sesfooter_follow_icons a{
  border-color:#<?php echo $this->text_color; ?>;
}
.sesfooter_follow_icons a i:before{
  color:#<?php echo $this->text_color; ?>;
}
.sesfooter_follow_icons a:hover{
  background-color:#<?php echo $this->text_color; ?>;
}
.sesfooter_follow_icons a:hover i:before{
  color:#<?php echo $this->background_color; ?>;
}
</style>
