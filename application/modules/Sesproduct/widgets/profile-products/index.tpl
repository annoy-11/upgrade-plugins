<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesproduct
 * @package    Sesproduct
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2019-03-04 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<ul class="sesproducts_browse">
  <?php foreach( $this->paginator as $item ): ?>
    <li>
      <div class='sesproducts_browse_info'>
        <p class='sesproducts_browse_info_title'>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle()) ?>
        </p>
        <p class='sesproducts_browse_info_date'>
          <?php echo $this->translate('Posted');?> <?php echo $this->timestamp($item->publish_date) ?>
        </p>
        <p class='sesproducts_browse_info_blurb'>
          <?php echo $this->string()->truncate($this->string()->stripTags($item->body), 300) ?>
        </p>
      </div>
    </li>
  <?php endforeach; ?>
</ul>
