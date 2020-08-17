<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seswishe
 * @package    Seswishe
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _wishe.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="seswishe_feed_wishe">
  <?php if($this->wishe->mediatype == 1 && !empty($this->wishe->photo_id)) { ?>
    <div class="seswishe_img"><?php echo $this->itemPhoto($this->wishe, 'thumb.main') ?></div>
  <?php } else if($this->wishe->mediatype == 2 && $this->wishe->code) { ?>
    <div class="seswishe_video"><?php echo $this->wishe->code; ?></div>
  <?php } ?>
  <?php if(!empty($this->wishe->wishetitle)) { ?>
    <div class="seswishe_title">  
      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.show', 0)) { ?>
        <a href="<?php echo $this->wishe->getHref(); ?>"><?php echo $this->wishe->wishetitle; ?></a>
      <?php } else { ?>
        <a data-url='seswishe/index/wishe-popup/wishe_id/<?php echo $this->wishe->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->wishe->wishetitle; ?></a>
      <?php } ?>
    </div>
  <?php } ?>
  <p class="seswishe_wishe">
    <?php echo nl2br($this->wishe->title); ?>
  </p>
  <?php if($this->wishe->source) { ?>
    <p class="sesbasic_text_light seswishe_wishe_src">&mdash; <?php echo $this->wishe->source; ?></p>
  <?php } ?>
  <p class="seswishe_wishe_link">
    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('seswishe.show', 0)) { ?>
      <a href="<?php echo $this->wishe->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
    <?php } else { ?>
      <a data-url='seswishe/index/wishe-popup/wishe_id/<?php echo $this->wishe->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
    <?php } ?>
  </span>
</div>