<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesarticle
 * @package    Sesarticle
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl 2016-07-23 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

?>
<ul class="sesarticles_browse">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class='sesarticles_browse_info'>
        <p class='sesarticles_browse_info_title'>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
        </p>
        <p class='sesarticles_browse_info_date'>
          <?php echo $this->translate('Posted');?> <?php echo $this->timestamp($item->publish_date) ?>
        </p>
        <p class='sesarticles_browse_info_blurb'>
          <?php echo $item->getDescription(300);?>
        </p>
      </div>
    </li>
  <?php endforeach; ?>
</ul>