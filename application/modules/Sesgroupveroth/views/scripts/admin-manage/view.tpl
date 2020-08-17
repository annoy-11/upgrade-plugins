<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesgroupveroth
 * @package    Sesgroupveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<div class="sesgroupveroth_details_popup">
	<div class="_head"><?php echo $this->translate("%s has been verified by:", $this->resource->getTitle()); ?></div>
  <div class="_content">
  	<ul>	
      <?php foreach($this->allRequests as $requests) { ?>
        <li class="sesgroupveroth_details_popup_item">
          <?php $poster = Engine_Api::_()->getItem('user', $requests['poster_id']); ?>
          <div class="_thumb"><?php echo $this->htmlLink($poster->getHref(), $this->itemPhoto($poster, 'thumb.profile')); ?></div>
          <div class="_cont">
            <div class="_name"><a herf="<?php echo $poster->getHref(); ?>"><?php echo $poster->getTitle(); ?></a></div>
            <div class="_des"><?php echo $requests['description']; ?></div>
          </div>
        </li>
      <?php } ?>
  	</ul>
	</div>
  <div class="_footer">
    <button onclick='javascript:parent.Smoothbox.close()'><?php echo $this->translate("Close") ?></button>
	</div>
</div>
