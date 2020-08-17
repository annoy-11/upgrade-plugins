<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesbusiness
 * @package    Sesbusiness
 * @copyright  Copyright 2017-2018 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-07-13 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
?>
<!--<h3><?php echo $this->translate("Businesses liked by this Business"); ?></h3>-->
<div class="sesbasic_sidebar_block sesbasic_clearfix sesbasic_bxs sesbusiness_linked_pages_block">
  <?php foreach($this->result as $result){ 
  	$business = Engine_Api::_()->getItem('businesses',$result->like_business_id);
    if(!$business)
    continue;
  ?>
    <div class="sesbasic_sidebar_list">
    	<div class="_thumb">
      	<a href="<?php echo $business->getHref(); ?>"><img src="<?php echo $business->getPhotoUrl('thumb.icon'); ?>" class="thumb_icon"></a>
      </div> 
      <div class="sesbasic_sidebar_list_info">
      	<div class="sesbasic_sidebar_list_title"> 
      		<a href="<?php echo $business->getHref(); ?>"><?php echo $business->getTitle(); ?></a>
    		</div>
      </div>
    </div>
  <?php } ?>
</div>
