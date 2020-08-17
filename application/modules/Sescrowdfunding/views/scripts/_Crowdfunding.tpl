<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sescrowdfunding
 * @package    Sescrowdfunding
 * @copyright  Copyright 2019-2020 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: _Crowdfunding.tpl  2019-01-08 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $crowdfunding = $this->crowdfunding; ?>

<div class=" feed_item_attachments ">
	<span class="feed_attachment_crowdfunding">
		<div>
			<a href="<?php echo $crowdfunding->getHref(); ?>">
			<img src="<?php echo $crowdfunding->getPhotoUrl('thumb.profile'); ?>" alt="zxcxzczxc" class="_sesactpinimg thumb_main item_photo_crowdfunding ">
			</a>
		<div>
		<div class="feed_item_link_title">
			<a data-src="<?php echo $crowdfunding->getGuid(); ?>" class="ses_tooltip" href="<?php echo $crowdfunding->getHref(); ?>"><?php echo $crowdfunding->getTitle(); ?></a>                        </div>
			<?php $desc = strip_tags($crowdfunding->description); ?>
			<div class="feed_item_link_desc"><?php echo (Engine_String::strlen($desc) > 255 ? Engine_String::substr($desc, 0, 255) . '...' : $desc); ?></div>
	</div>
	</div>
	</span>
</div>
