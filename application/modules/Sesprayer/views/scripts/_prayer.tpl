<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesprayer
 * @package    Sesprayer
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _prayer.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesprayer/externals/styles/styles.css'); ?>
<div class="sesprayer_feed_prayer">
  <?php if($this->prayer->mediatype == 1 && !empty($this->prayer->photo_id)) { ?>
    <div class="sesprayer_img"><?php echo $this->itemPhoto($this->prayer, 'thumb.main') ?></div>
  <?php } else if($this->prayer->mediatype == 2 && $this->prayer->code) { ?>
    <div class="sesprayer_video"><?php echo $this->prayer->code; ?></div>
  <?php } ?>
  <?php if(!empty($this->prayer->prayertitle)) { ?>
    <div class="sesprayer_title">  
      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
        <a href="<?php echo $this->prayer->getHref(); ?>"><?php echo $this->prayer->prayertitle; ?></a>
      <?php } else { ?>
        <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $this->prayer->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->prayer->prayertitle; ?></a>
      <?php } ?>
    </div>
  <?php } ?>
  <p class="sesprayer_prayer">
    <?php echo nl2br($this->prayer->title); ?>
  </p>
  <?php if($this->prayer->source) { ?>
    <p class="sesbasic_text_light sesprayer_prayer_src">&mdash; <?php echo $this->prayer->source; ?></p>
  <?php } ?>
  <p class="sesprayer_prayer_link">
    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesprayer.show', 0)) { ?>
      <a href="<?php echo $this->prayer->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
    <?php } else { ?>
      <a data-url='sesprayer/index/prayer-popup/prayer_id/<?php echo $this->prayer->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
    <?php } ?>
  </span>
</div>