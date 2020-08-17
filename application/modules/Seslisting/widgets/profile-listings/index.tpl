<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Seslisting
 * @package    Seslisting
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-04-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<ul class="seslistings_browse">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class='seslistings_browse_info'>
        <p class='seslistings_browse_info_title'>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
        </p>
        <p class='seslistings_browse_info_date'>
          <?php echo $this->translate('Posted');?> <?php echo $this->timestamp($item->publish_date) ?>
        </p>
        <p class='seslistings_browse_info_blurb'>
          <?php echo $item->getDescription(300);?>
        </p>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
