<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sespageveroth
 * @package    Sespageveroth
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: view.tpl  2018-11-02 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sespageveroth/externals/styles/styles.css'); ?>
<div class="sespageveroth_details_popup sesbasic_bxs">
	<div class="_head"><?php echo $this->translate("%s has been verified by:", $this->resource->getTitle()); ?></div>
  <div class="_content">
  	<ul>	
      <?php foreach($this->allRequests as $requests) { ?>
        <li class="sesbasic_clearfix sespageveroth_details_popup_item">
          <?php $poster = Engine_Api::_()->getItem('user', $requests['poster_id']); ?>
          <div class="_thumb"><?php echo $this->htmlLink($poster->getHref(), $this->itemPhoto($poster, 'thumb.profile')); ?></div>
          <div class="_cont">
          	<div class="_name"><a href="<?php echo $poster->getHref(); ?>"><?php echo $poster->getTitle(); ?></a></div>
          	<?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.enablecomment', 1) && Engine_Api::_()->getApi('settings', 'core')->getSetting('sespageveroth.displaycomment', 1)) { ?>
            <div class="_des"><?php echo $requests['description']; ?></div>
          	<?php } ?>
    			</div>
        </li>
      <?php } ?>
    </ul>
  </div>
</div>
