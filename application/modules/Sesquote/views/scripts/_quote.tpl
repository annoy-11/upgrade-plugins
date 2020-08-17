<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesquote
 * @package    Sesquote
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _quote.tpl  2017-12-12 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<div class="sesquote_feed_quote">
  <?php if($this->quote->mediatype == 1 && !empty($this->quote->photo_id)) { ?>
    <div class="sesquote_img"><?php echo $this->itemPhoto($this->quote, 'thumb.main') ?></div>
  <?php } else if($this->quote->mediatype == 2 && $this->quote->code) { ?>
    <div class="sesquote_video"><?php echo $this->quote->code; ?></div>
  <?php } ?>
  <?php if(!empty($this->quote->quotetitle)) { ?>
    <div class="sesquote_title">  
      <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.show', 0)) { ?>
        <a href="<?php echo $this->quote->getHref(); ?>"><?php echo $this->quote->quotetitle; ?></a>
      <?php } else { ?>
        <a data-url='sesquote/index/quote-popup/quote_id/<?php echo $this->quote->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->quote->quotetitle; ?></a>
      <?php } ?>
    </div>
  <?php } ?>
  <p class="sesquote_quote">
    <?php $title = mb_substr(nl2br($this->quote->title),0,200).'...';?>
    <?php echo nl2br($title); ?>
  </p>
  <?php if($this->quote->source) { ?>
    <p class="sesbasic_text_light sesquote_quote_src">&mdash; <?php echo $this->quote->source; ?></p>
  <?php } ?>
  <p class="sesquote_quote_link">
    <?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesquote.show', 0)) { ?>
      <a href="<?php echo $this->quote->getHref(); ?>"><?php echo $this->translate('Read More'); ?></a>
    <?php } else { ?>
      <a data-url='sesquote/index/quote-popup/quote_id/<?php echo $this->quote->getIdentity(); ?>' class="sessmoothbox" href="javascript:;"><?php echo $this->translate('Read More'); ?></a>
    <?php } ?>
  </span>
</div>
