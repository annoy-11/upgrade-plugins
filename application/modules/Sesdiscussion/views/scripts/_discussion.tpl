<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesdiscussion
 * @package    Sesdiscussion
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _discussion.tpl  2018-12-18 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesdiscussion_feed_discussion">
  <?php if(in_array($this->discussion->mediatype, array(1, 3, 4)) && !empty($this->discussion->photo_id)) { ?>
    <div class="sesdiscussion_img"><?php echo $this->itemPhoto($this->discussion, 'thumb.main') ?></div>
  <?php } else if($this->discussion->mediatype == 2 && $this->discussion->code) { ?>
    <div class="sesdiscussion_video"><?php echo $this->discussion->code; ?></div>
  <?php } ?>
  <?php if(!empty($this->discussion->title)) { ?>
    <div class="sesdiscussion_title">  
      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.show', 0)) { ?>
        <a href="<?php echo $this->discussion->getHref(); ?>"><?php echo $this->discussion->title; ?></a>
      <?php } else { ?>
        <a data-url='sesdiscussion/index/discussion-popup/discussion_id/<?php echo $this->discussion->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->discussion->titlesss; ?></a>
      <?php } ?>
    </div>
  <?php } ?>
  <p class="sesdiscussion_discussion">
    <?php echo nl2br($this->discussion->discussiontitle); ?>
  </p>
  <?php if($this->discussion->source) { ?>
    <p class="sesbasic_text_light sesdiscussion_discussion_link">&mdash; <?php echo $this->discussion->source; ?></p>
  <?php } ?>
  <p class="sesdiscussion_discussion_more_link">
    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesdiscussion.show', 0)) { ?>
      <a href="<?php echo $this->discussion->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
    <?php } else { ?>
      <a data-url='sesdiscussion/index/discussion-popup/discussion_id/<?php echo $this->discussion->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
    <?php } ?>
  </span>
</div>
