<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seseventmusic
 * @package    Seseventmusic
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2015-03-30 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
?>
<div class="sesbasic_breadcrumb">
  <?php if($this->viewPageType == 'album'): ?>
      <a href="<?php echo $this->url(array('action' => 'home'), "seseventmusic_general"); ?>"><?php echo $this->translate("Music Album Home"); ?></a>&nbsp;&raquo;
      <a href="<?php echo $this->event->getHref(); ?>"><?php echo $this->event->getTitle(); ?></a>&nbsp;&raquo;
      <?php echo $this->album->getTitle(); ?>
  <?php elseif($this->viewPageType == 'song'): ?>
    <a href="<?php echo $this->url(array('action' => 'home'), "seseventmusic_general"); ?>"><?php echo $this->translate("Music Album Home"); ?></a>&nbsp;&raquo;
    <a href="<?php echo $this->event->getHref(); ?>"><?php echo $this->event->getTitle() ?></a>&nbsp;&raquo;
    <?php echo $this->htmlLink($this->album->getHref(), $this->album->getTitle()) ?>&nbsp;&raquo;
    <?php echo $this->albumSong->getTitle(); ?>
  <?php endif; ?>
</div>
