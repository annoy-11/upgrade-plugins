<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesrecipe
 * @package    Sesrecipe
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2018-05-07 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<ul class="sesrecipes_browse">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class='sesrecipes_browse_info'>
        <p class='sesrecipes_browse_info_title'>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
        </p>
        <p class='sesrecipes_browse_info_date'>
          <?php echo $this->translate('Posted');?> <?php echo $this->timestamp($item->publish_date) ?>
        </p>
        <p class='sesrecipes_browse_info_blurb'>
          <?php echo $this->string()->truncate($this->string()->stripTags($item->body), 300) ?>
        </p>
      </div>
    </li>
  <?php endforeach; ?>
</ul>